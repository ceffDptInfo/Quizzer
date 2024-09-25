<?php

require_once('../controller.php');
$status = GetGameStatus($_GET['id']);

echo $status;