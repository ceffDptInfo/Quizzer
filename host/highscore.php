<!doctype html>
<html lang="en">

<head>
  <title>Quizzer - Résultats</title>
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
</head>

<?php
require_once("../controller.php");

$players = GetPlayers($_SESSION['code'], 5);

if (isset($_POST['end'])) {
  EndGame($_SESSION['code']);
  header('location: lobby.php');
  exit();
}
?>

<body>
  <?php require_once("../components/header.php"); ?>
  <main style="height: 80vh;" class="d-flex flex-column">
    <h1 class="text-center mt-4">Résultats :</h1>
    <div class="container-fluid mt-3">
      <?php
      foreach ($players as $player):
      ?>
        <div class="gray w-75 mx-auto d-flex my-2">
          <div class="player-<?= $player['Color'] ?> m-2" style="width:40px; height:40px;"></div>
          <div class="fs-2 flex-fill"><?= $player['Username'] ?></div>
          <div class="fw-bold fs-1 my-auto me-2"><?= $player['Points'] ?></div>
        </div>

      <?php
      endforeach;
      ?>
    </div>
    <div class="w-100 d-flex align-items-center mt-auto mb-5">
      <form method="post" class="mx-auto  ">
        <button type="submit" class="btn gray mx-auto px-4" name="end">Retour au Lobby</button>
      </form>
    </div>
  </main>
  <?php require_once("../components/footer.php"); ?>
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