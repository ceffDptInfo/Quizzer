
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

function GetPlayers($code, $limit = 0)
{
  global $db;
  $id = $db->GetGameID($code)->fetch()['idGame'];
  if ($id != false && $limit == 0) {
    $players = $db->ReturnPlayers($id)->fetchAll();
    return $players;
  } else if ($id != false) {
    $players = $db->ReturnPlayersLimit($id, $limit);
    return $players;
  }
}

function JoinGame($code, $username, $color)
{
  global $db;

  $code = strtoupper($code);
  $id = $db->GetGameID($code)->fetch()['idGame'];

  if ($db->GetGameStatus($id)->fetch()['Status'] == "en attente" || $db->GetGameStatus($id)->fetch()['Status'] == "termine") {
    if ($db->GetPlayerId($username, $color, $id)->fetch()['idPlayer'] != false) {
      return false;
    } else {
      $db->CreatePlayer($username, $color, $id);
      $idPlayer = $db->GetPlayerId($username, $color, $id)->fetch()['idPlayer'];
      return $idPlayer;
    }
  } else {
    return false;
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

  for ($i = 0; $i < count($content); $i++) {
    $reps = [];
    for ($j = 0; $j < 4; $j++) {
      $reps[] = $content[$i][0][$j + 1];
    }
    $db->CreateQuestion($reps, $id, $i + 1);
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

  foreach ($content as $line) {
    if (!IsLineAComment($line)) {
      $nocomments[] = $line;
    }
  }

  return $nocomments;
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

function UpdatePlayersPoints($players, $rep, $code)
{
  global $db;
  $idGame = $db->GetGameID($code)->fetch()['idGame'];
  $db->UpdateStatus($idGame, 'leaderboard');
  $questionDate = new DateTime($db->GetQuestionTime($idGame));
  $time = 10;
  if (count($_SESSION['questions'][$_SESSION['current']][1]) > 1) {
    $time = $_SESSION['questions'][$_SESSION['current']][1][0];
  }

  foreach ($players as $player) {
    if ($player['rep'] == $rep) {
      $date = new DateTime($player['ResponseTime']);
      $db->UpdatePoints($player['Points'] + 100 + ($time - $date->diff($questionDate)->s), $player['idPlayer']);
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

  DeleteImages($code);
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

function ResetAnswers($code)
{
  global $db;
  $players = GetPlayers($code);

  foreach ($players as $p) {
    $db->UpdateResponse(null, null, $p['idPlayer']);
  }
}

function QuestionToArray($question)
{
  $components = explode("::", $question);
  $qa = explode(";", $components[0]);
  $param = [];
  if (count($components) > 1) {
    $param = explode(";", $components[1]);
  }

  for ($i = 0; $i < count($qa); $i++) {
    if (str_contains($qa[$i], " ")) {
      $qa[$i] = trim($qa[$i]);
    }

    if ($qa[$i] == "---") {
      $qa[$i] = null;
    }
  }

  for ($i = 0; $i < count($param); $i++) {
    if (str_contains($param[$i], " ")) {
      $param[$i] = trim($param[$i]);
    }
  }

  $array[] = $qa;
  $array[] = $param;

  return $array;
}

function DeleteImages($code)
{
  foreach (scandir('../images/' . $code) as $file) {
    if ($file != "." && $file != "..") {
      unlink('../images/' . $code . "/" . $file);
    }
  }
  rmdir('../images/' . $code);
}

function SetStatus($code, $status)
{
  global $db;
  $idGame = $db->GetGameID($code)->fetch()['idGame'];
  $db->UpdateStatus($idGame, $status);
}

function SetGameQuestion($code, $question)
{
  global $db;
  $idGame = $db->GetGameID($code)->fetch()['idGame'];
  $db->UpdateQuestion($idGame, $question);
}

function GetPendingPlayers($code)
{
  global $db;
  $idGame = $db->GetGameID($code)->fetch()['idGame'];
  $players = $db->GetNullRepPlayers($idGame);
  $nbPlayers = count($players);
  return $nbPlayers;
}

function CheckQuestions($questions)
{
  $filesName = [];
  foreach ($_FILES as $file) {
    $filesName[] = $file['name'];
  }

  foreach ($questions as $key => $q) {
    if (count($q[0]) < 5) {
      return "Erreur : La question N." . ($key + 1) . " ne possède pas assez d'arguments.";
    }

    if ($q[0][(int) $q[0][5]] == null) {
      return "Erreur : La réponse de la question N." . ($key + 1) . " indique une réponse vide";
    }

    if (count($q) > 1 && count($q[1]) > 1) {
      if (!in_array(trim($q[1][1]), $filesName, true)) {
        return "Erreur : L'image de la question N." . ($key + 1) . " n'existe pas";
      }
    }
  }
}

function SetQuestionTime($code)
{
  global $db;
  $idGame = $db->GetGameID($code)->fetch()['idGame'];

  $db->UpdateGameQuestionTime($idGame, date('Y-m-d H:i:s'));
}
