<!doctype html>
<html lang="en">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS v5.2.1 -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
    crossorigin="anonymous" />

  <!-- Custom -->
  <link rel="stylesheet" href="../style/style.css">
  <script src="../javascript/question.js"></script>
</head>

<?php
require_once('../controller.php');

if (isset($_POST['next'])) {
  $_SESSION['current'] += 1;
}
SetStatus($_SESSION['code'], "en cours");
SetGameQuestion($_SESSION['code'], $_SESSION['current'] + 1);

if ($_SESSION['current'] >= count($_SESSION['questions'])) {
  EndGame($_SESSION['code']);
  header("location: lobby.php");
  exit();
}
?>

<body onload="init();">
  <?php require_once('../components/header.php') ?>
  <main>
    <p class="visually-hidden" id="time"><?= $_SESSION['questions'][$_SESSION['current']][1][0] ?></p>
    <div class="d-flex px-5 mt-4 flex-column" style="height: 80vh;">
      <div class="gray w-100 position-relative" style="height: 100px;">
        <p class="text-center position-absolute top-50 start-50 translate-middle fs-2"><?= $_SESSION['questions'][$_SESSION['current']][0][0] ?></p>
      </div>
      <div class="gray circle align-self-end position-relative mt-3" style="width: 100px; height: 100px;">
        <div class="text-center my-auto position-absolute top-50 start-50 translate-middle fs-5 fw-bold" id="count">10s</div>
      </div>
      <?php if (count($_SESSION['questions'][$_SESSION['current']][1]) > 1): ?>
        <img src="../images/<?= $_SESSION['code'] ?>/<?= $_SESSION['questions'][$_SESSION['current']][1][1] ?>" class="object-fit-scale" style="height: 350px;">
      <?php endif; ?>
      <div class="d-flex mt-auto flex-wrap mb-3">
        <div class="w-50 p-2">
          <div class="p-4 gray text-center fs-4"><?= $_SESSION['questions'][$_SESSION['current']][0][1] ?></div>
        </div>
        <div class="w-50 p-2">
          <div class="p-4 gray text-center fs-4"><?= $_SESSION['questions'][$_SESSION['current']][0][2] ?></div>
        </div>
        <div class="w-50 p-2">
          <div class="p-4 gray text-center fs-4 <?php if ($_SESSION['questions'][$_SESSION['current']][0][3] == null) {
                                                  echo "visually-hidden";
                                                } ?>"><?= $_SESSION['questions'][$_SESSION['current']][0][3] ?></div>
        </div>
        <div class="w-50 p-2">
          <div class="p-4 gray text-center fs-4 <?php if ($_SESSION['questions'][$_SESSION['current']][0][4] == null) {
                                                  echo "visually-hidden";
                                                } ?>"><?= $_SESSION['questions'][$_SESSION['current']][0][4] ?></div>
        </div>

      </div>
    </div>
  </main>
  <?php require_once('../components/footer.php') ?>
  <!-- Bootstrap JavaScript Libraries -->
  <script
    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
    crossorigin="anonymous"></script>
</body>

</html>