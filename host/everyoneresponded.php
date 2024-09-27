<?php
require_once("../controller.php");

if (GetPendingPlayers($_GET['code']) == 0 && count(GetPlayers($_GET['code'])) > 0) {
  echo "true";
}
