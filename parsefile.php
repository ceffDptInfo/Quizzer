<?php
require_once('controller.php');

$content = json_decode($_POST['data']);
$nocomment = RemoveComments($content);

for ($i = 0; $i < count($nocomment); $i++) {
  $questions[] = QuestionToArray($nocomment[$i]);
}

$error = CheckQuestions($questions);
if ($error != null) {
  echo $error;
  return;
}

if (count($_FILES) > 0) {
  if (!file_exists("images/" . $_POST['code'])) {
    mkdir("images/" . $_POST['code']);
  }
  $target_dir = "images/" . $_POST['code'] . "/";

  foreach ($_FILES as $file) {
    $target_file = $target_dir . basename($file['name']);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "gif" || $imageFileType == "jpeg") {
      move_uploaded_file($file['tmp_name'], $target_file);
    }
  }
}

$_SESSION['questions'] = $questions;
CreateQuestions($_SESSION['questions'], $_POST['code']);
