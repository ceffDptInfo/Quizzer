<?php

require_once('../controller.php');

if (GetGameStatus($_SESSION['id']) == "commence" && AnswerExists($_SESSION['id'])) {
  echo "true";
}