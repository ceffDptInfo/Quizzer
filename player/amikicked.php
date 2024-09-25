<?php
require_once('../controller.php');

UpdateTimeStamp($_GET['id']);

if (IsPlayerKicked($_GET['id'])) {
  echo "true";
}
?>