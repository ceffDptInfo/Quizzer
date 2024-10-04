<?php
class Database
{

  private $db;

  function __construct($username, $password)
  {
    $this->db = new PDO('mysql:host=localhost;dbname=quizzer', $username, $password);
  }

  function GetGameID(string $code)
  {
    $stmt = $this->db->prepare("SELECT `idGame` FROM `quizzer`.`game` WHERE `Code` = ?");
    $stmt->bindParam(1, $code);
    $stmt->execute();
    return $stmt;
  }

  function CreateGame(string $code)
  {
    $stmt = $this->db->prepare("INSERT INTO `quizzer`.`game` (Code) VALUES (?)");
    $stmt->bindParam(1, $code);
    $stmt->execute();
    return $stmt;
  }

  function RemoveGame(int $id)
  {
    $stmt = $this->db->prepare("DELETE FROM `quizzer`.`game` WHERE `idGame` = ?");
    $stmt->bindParam(1, $id);
    $stmt->execute();
  }

  function ReturnPlayers(int $id)
  {
    $stmt = $this->db->prepare("SELECT * FROM `quizzer`.`player` WHERE `Game_idGame` = ? ORDER BY `Points` DESC");
    $stmt->bindParam(1, $id);
    $stmt->execute();
    return $stmt;
  }

  function CreatePlayer(string $username, string $color, int $id)
  {
    $stmt = $this->db->prepare("INSERT INTO `quizzer`.`player` (Username, Color, Game_idGame, timestamp) VALUES (?, ?, ?, ?)");
    $stmt->bindParam(1, $username);
    $stmt->bindParam(2, $color);
    $stmt->bindParam(3, $id);
    $stmt->bindParam(4, time());
    $stmt->execute();
  }

  function GetPlayerId(string $username, string $color, int $id)
  {
    $stmt = $this->db->prepare("SELECT `idPlayer` FROM `quizzer`.`player` WHERE `Username` = ? AND `Color` = ? AND `Game_idGame` = ?");
    $stmt->bindParam(1, $username);
    $stmt->bindParam(2, $color);
    $stmt->bindParam(3, $id);
    $stmt->execute();
    return $stmt;
  }

  function RemovePlayer(int $id)
  {
    $stmt = $this->db->prepare("DELETE FROM `quizzer`.`player` WHERE `idPlayer` = ?");
    $stmt->bindParam(1, $id);
    $stmt->execute();
  }

  function PlayerExists(int $id)
  {
    $stmt = $this->db->prepare("SELECT `idPlayer` FROM `quizzer`.`player` WHERE `idPlayer` = ?");
    $stmt->bindParam(1, $id);
    $stmt->execute();
    return $stmt;
  }

  function UpdateTimestamp(int $id)
  {
    $time = time();
    $stmt = $this->db->prepare("UPDATE `quizzer`.`player` SET `timestamp` = ? WHERE `idPlayer` = ?");
    $stmt->bindParam(1, $time);
    $stmt->bindParam(2, $id);
    $stmt->execute();
  }

  function CreateQuestion(array $reps, int $idGame, int $nbQuestion)
  {
    $stmt = $this->db->prepare("INSERT INTO `quizzer`.`question` (`Rep1`, `Rep2`, `Rep3`, `Rep4`, `game_idGame`, `QuestionNumber`) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bindParam(1, $reps[0]);
    $stmt->bindParam(2, $reps[1]);
    $stmt->bindParam(3, $reps[2]);
    $stmt->bindParam(4, $reps[3]);
    $stmt->bindParam(5, $idGame);
    $stmt->bindParam(6, $nbQuestion);
    $stmt->execute();
  }

  function GetPlayerGame(int $idPlayer)
  {
    $stmt = $this->db->prepare("SELECT `Game_idGame` FROM `quizzer`.`player` WHERE `idPlayer` = ?");
    $stmt->bindParam(1, $idPlayer);
    $stmt->execute();
    return $stmt;
  }

  function GetGameStatus(int $idGame)
  {
    $stmt = $this->db->prepare("SELECT `Status` FROM `quizzer`.`game` WHERE `idGame` = ?");
    $stmt->bindParam(1, $idGame);
    $stmt->execute();
    return $stmt;
  }

  function UpdateStatus(int $idGame, string $status)
  {
    $stmt = $this->db->prepare("UPDATE `quizzer`.`game` SET `Status` = ? WHERE `idGame` = ?");
    $stmt->bindParam(1, $status);
    $stmt->bindParam(2, $idGame);
    $stmt->execute();
  }

  function UpdateQuestion(int $idGame, int $question)
  {
    $stmt = $this->db->prepare("UPDATE `quizzer`.`game` SET `QuestionID` = ? WHERE `idGame` = ?");
    $stmt->bindParam(1, $question);
    $stmt->bindParam(2, $idGame);
    $stmt->execute();
  }

  function UpdateResponse($rep, $time, int $idPlayer)
  {
    $stmt = $this->db->prepare("UPDATE `quizzer`.`player` SET `rep` = ?, `ResponseTime` = ? WHERE `idPlayer` = ?");
    $stmt->bindParam(1, $rep);
    $stmt->bindParam(2, $time);
    $stmt->bindParam(3, $idPlayer);
    $stmt->execute();
  }

  function UpdatePoints(int $points, int $idPlayer)
  {
    $stmt = $this->db->prepare("UPDATE `quizzer`.`player` SET `Points` = ? WHERE `idPlayer` = ?");
    $stmt->bindParam(1, $points);
    $stmt->bindParam(2, $idPlayer);
    $stmt->execute();
  }

  function GetQuestionID($idGame)
  {
    $stmt = $this->db->prepare("SELECT `QuestionID` FROM `quizzer`.`game` WHERE `idGame` = ?");
    $stmt->bindParam(1, $idGame);
    $stmt->execute();
    return $stmt;
  }

  function GetQuestionAnswers($idGame, $idQuestion)
  {
    $rep = [];
    $stmt = $this->db->prepare("SELECT `Rep1`, `Rep2`, `Rep3`, `Rep4` FROM `quizzer`.`question` WHERE `game_idGame` = ? AND `QuestionNumber` = ?");
    $stmt->bindParam(1, $idGame);
    $stmt->bindParam(2, $idQuestion);
    $stmt->execute();
    $row = $stmt->fetch();
    if ($row != false) {
      for ($i = 0; $i < 4; $i++) {
        $rep[] = $row[$i];
      }
    }
    return $rep;
  }

  function RemoveQuestions($idGame)
  {
    $stmt = $this->db->prepare("DELETE FROM `quizzer`.`question` WHERE `game_idGame` = ?");
    $stmt->bindParam(1, $idGame);
    $stmt->execute();
  }

  function GetNullRepPlayers($idGame)
  {
    $stmt = $this->db->prepare("SELECT `idPlayer` FROM `player` WHERE `rep` IS NULL AND `Game_idGame` = ?");
    $stmt->bindParam(1, $idGame);
    $stmt->execute();
    $players = $stmt->fetchAll();
    return $players;
  }

  function ReturnPlayersLimit(int $idGame, int $limit)
  {
    $stmt = $this->db->prepare("SELECT * FROM `quizzer`.`player` WHERE `Game_idGame` = ? ORDER BY `Points` DESC LIMIT ?");
    $stmt->bindParam(1, $idGame);
    $stmt->bindParam(2, $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  function UpdateGameQuestionTime(int $idGame, string $timestamp) {
    $stmt = $this->db->prepare("UPDATE `quizzer`.`game` SET `StartedTime` = ? WHERE `idGame` = ?");
    $stmt->bindParam(1, $timestamp);
    $stmt->bindParam(2, $idGame);
    $stmt->execute();
  }

  function GetQuestionTime(int $idGame) {
    $stmt = $this->db->prepare("SELECT `StartedTime` FROM `quizzer`.`game` WHERE `idGame` = ?");
    $stmt->bindParam(1, $idGame);
    $stmt->execute();
    return $stmt->fetch()['StartedTime'];
  }
}
