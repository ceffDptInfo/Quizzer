<?php
require_once('../controller.php');

$content = json_decode($_POST['data']);

$nocomment = RemoveComments($content);

$_SESSION['questions'] = $nocomment;
CreateQuestions($_SESSION['questions'], end($content));