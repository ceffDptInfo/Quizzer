<?php
$_ENV = parse_ini_file('.env');
session_start();

require_once('database.php');
$db = new Database($_ENV['USERNAME'], $_ENV['PASSWORD']);

function CreateGame()
{
  global $db;
  $code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4));
  $statement = $db->GetGameID($code);

  if ($statement->fetch() == false) {
    $db->CreateGame($code);
    $_SESSION['code'] = $code;
  } else {
    CreateGame();
  }
}

function HostQuit()
{
  global $db;
  $id = $db->GetGameID($_SESSION['code'])->fetch()['idGame'];
  $db->RemoveGame($id);
}

function GetPlayers($code)
{
  global $db;
  $id = $db->GetGameID($code)->fetch()['idGame'];
  if ($id != false) {
    $players = $db->ReturnPlayers($id)->fetchAll();
    return $players;
  }
}

function JoinGame($code, $username, $color)
{
  global $db;

  $code = strtoupper($code);
  $id = $db->GetGameID($code)->fetch()['idGame'];
  if ($db->GetPlayerId($username, $color, $id)->fetch()['idPlayer'] != false) {
    return false;
  } else {
    $db->CreatePlayer($username, $color, $id);
    $idPlayer = $db->GetPlayerId($username, $color, $id)->fetch()['idPlayer'];
    return $idPlayer;
  }
}

function QuitGame($idPlayer)
{
  global $db;

  $db->RemovePlayer($idPlayer);
  unset($_SESSION['id']);
}

function KickPlayer($username, $color, $code)
{
  global $db;

  $idGame = $db->GetGameID($code)->fetch()['idGame'];
  $id = $db->GetPlayerId($username, $color, $idGame)->fetch()['idPlayer'];
  $db->RemovePlayer($id);
}

function IsPlayerKicked($id)
{
  global $db;

  if ($db->PlayerExists($id)->fetch()['idPlayer'] == false) {
    $_SESSION['kicked'] = true;
    return true;
  }
}

function UpdateTimeStamp($id)
{
  global $db;
  $db->UpdateTimeStamp($id);
}

function StartGame($code)
{
  global $db;
  $id = $db->GetGameID($code)->fetch()['idGame'];
  $db->UpdateStatus($id, 'commence');
  $db->UpdateQuestion($id, 1);
}

function CreateQuestions($content, $code)
{
  global $db;
  $id = $db->GetGameID($code)->fetch()['idGame'];

  $db->RemoveQuestions($id);

  foreach ($content as $i => $rep) {
    $components = explode(";", $rep);
    foreach ($components as $key => $component) {
      if ($component == "---") {
        $components[$key] = null;
      }
    }
    $db->CreateQuestion($components, $id, $i + 1);
  }
}

function RemoveComments($content)
{
  function IsLineAComment($line)
  {
    if (substr(str_replace(" ", "", $line), 0, 1) == "#" || strlen($line) <= 1) {
      return true;
    } else {
      return false;
    }
  }

  array_pop($content);
  foreach ($content as $line) {
    if (!IsLineAComment($line)) {
      $nocomments[] = $line;
    }
  }

  return $nocomments;
}

function ShowQuestion($nb, $code)
{
  global $db;
  $id = $db->GetGameID($code)->fetch()['idGame'];
  $db->UpdateQuestion($id, $nb + 1);
  $db->UpdateStatus($id, "en cours");

  $data = explode(";", $_SESSION['questions'][$nb]);
  $data;
  $table = [];
  $table['question'] = $data[0];
  $table['rep1'] = $data[1];
  $table['rep2'] = $data[2];
  $table['rep3'] = $data[3];
  $table['rep4'] = $data[4];

  return $table;
}

function GetGameStatus($idPlayer)
{
  global $db;
  $idGame = $db->GetPlayerGame($idPlayer)->fetch()['Game_idGame'];
  $status = $db->GetGameStatus($idGame)->fetch()['Status'];
  return $status;
}

function SendResponse($rep, $time, $userID)
{
  global $db;
  $db->UpdateResponse($rep, $time, $userID);
}

function UpdatePlayersPoints($players, $rep)
{
  global $db;
  $db->UpdateStatus($players[0]['Game_idGame'], 'leaderboard');

  foreach ($players as $player) {
    if ($player['rep'] == $rep) {
      $db->UpdatePoints($player['Points'] + 100, $player['idPlayer']);
    }
  }
}

function GetResponses($userID)
{
  global $db;
  $idGame = $db->GetPlayerGame($userID)->fetch()['Game_idGame'];
  $idQuestion = $db->GetQuestionID($idGame)->fetch()['QuestionID'];
  return $db->GetQuestionAnswers($idGame, $idQuestion);
}

function EndGame($code)
{
  global $db;
  $idGame = $db->GetGameID($code)->fetch()['idGame'];

  unset($_SESSION['current']);
  unset($_SESSION['questions']);

  $db->UpdateStatus($idGame, "termine");
  $db->RemoveQuestions($idGame);
  $db->UpdateQuestion($idGame, 0);

  $players = $db->ReturnPlayers($idGame);
  foreach ($players as $p) {
    $id = $db->GetPlayerId($p['Username'], $p['Color'], $p['Game_idGame'])->fetch()['idPlayer'];
    $db->UpdateTimestamp($id);
    $db->UpdatePoints(0, $id);
  }
}

function AnswerExists($idPlayer)
{
  global $db;
  $idGame = $db->GetPlayerGame($idPlayer)->fetch()['Game_idGame'];
  $result = $db->GetQuestionID($idGame)->fetch();
  if ($result != false) {
    return true;
  }
}

function ResetAnswers($code) {
  global $db;
  $players = GetPlayers($code);
  
  foreach ($players as $p) {
    $db->UpdateResponse(null, null ,$p['idPlayer']);
  }
}