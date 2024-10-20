<!doctype html>
<html lang="fr">

<head>
  <title>Quizzer - Home</title>
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
  <link rel="stylesheet" href="style/style.css">
</head>

<?php
require_once("controller.php");

if (isset($_POST["create"])) {
  CreateGame();
  header('location: ./host/lobby.php');
  exit();
}


?>

<body>
  <?php require_once('components/header.php') ?>
  <main>
    <h1 class="text-center fw-bold fs-1 mt-5">Le Quizzer</h1>
    <p class="text-center text-danger fs-5 <?php if (!isset($_SESSION['kicked'])) {
                                              echo "visually-hidden";
                                            } ?>">Vous avez été exclu de la partie</p>
    <form method="post">
      <div class="d-flex w-100 px-3 px-sm-0 flex-column flex-sm-row top-50 start-50 position-absolute translate-middle-x w-sm-50 justify-content-around">
        <button type="button" class="btn gray btn-lg fw-medium" onclick="window.location.href='player/joining.php'">Rejoindre une partie</button>
        <button type="submit" class="btn gray btn-lg fw-medium mt-3 mt-sm-0 d-none d-sm-inline" name="create">Créer une partie</button>
      </div>
    </form>
  </main>
  <?php require_once('components/footer.php') ?>

  <?php
  if (isset($_SESSION['kicked'])) {
    unset($_SESSION['kicked']);
  }
  ?>


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