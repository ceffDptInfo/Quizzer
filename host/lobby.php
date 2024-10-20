<!doctype html>
<html lang="en">

<head>
  <title>Quizzer - Lobby</title>
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
  <link rel="stylesheet" href="../style/players.css">
  <script src="../javascript/showplayers.js"></script>
  <script src="../javascript/parsefile.js"></script>
</head>

<?php
require_once('../controller.php');

$errorMessage = "";

if (isset($_POST['quit'])) {
  HostQuit();
  header('location: ../index.php');
  exit();
}

if (isset($_POST['kick']) && isset($_POST['name']) && isset($_POST['color'])) {
  KickPlayer($_POST['name'], $_POST['color'], $_SESSION['code']);
  header('location:' . $_SERVER['PHP_SELF']);
  exit();
}

if (isset($_POST['start']) && isset($_POST['file'])) {
  StartGame($_SESSION['code']);
  $_SESSION['current'] = 0;
  header('location: starting.php');
  exit();
}
?>

<body onload="init();">
  <?php require_once('../components/header.php') ?>
  <main>
    <div class="container-fluid mt-5">
      <div class="row">
        <!-- Code, QR code and buttons -->
        <div class="offset-1 col-3">
          <p class="text-center fw-bold fs-2 gray" style="height: 50px;"><?= $_SESSION['code']; ?></p>
          <div class="mt-5 gray">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http://<?= $_SERVER['SERVER_ADDR'] . "/player/joining.php?code=" . $_SESSION['code'] ?>" alt="Qr code pour rejoindre la partie" class="w-100 p-4 object-fit-fill">
          </div>
          <form method="post">
            <button type="submit" name="start" class="btn gray start-50 position-relative translate-middle-x mt-5 fw-semibold w-75 disabled" id="start">Commencer</button>
            <button type="submit" name="quit" class="btn gray start-50 position-relative translate-middle-x mt-4 fw-semibold w-50">Retour</button>
        </div>
        <!-- File import and players -->
        <div class="offset-1 col-5">
          <div class="d-flex justify-content-start align-items-stretch flex-column mb-5" style="height: 50px;">
            <div class="d-flex flex-row">
              <input type="file" name="file" class="form-control col" id="file" onchange="ParseFile(this, '<?= $_SESSION['code']; ?>');" accept=".txt, .jpg, .png, .gif, .jpeg" multiple></input>
              <button type="button" class="btn btn-primary col-3 mx-3" onclick="window.location.href = '../tuto.php';">Besoin d'aide ?</button>
            </div>
            <p class="text-danger" id="errorMessage"><?= $errorMessage ?></p>
            </form>
          </div>
          <!-- Players -->
          <div class="container d-flex flex-column flex-wrap w-100" id="displayPlayers" style="height: 70vh;">
            <!-- Foreach php géré par le JS (fetch) -->
          </div>
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