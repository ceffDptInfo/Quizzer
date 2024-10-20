<!doctype html>
<html lang="fr">

<head>
  <title>Le Quizzer</title>
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
</head>

<?php
require_once('../controller.php');
if (isset($_POST['quit'])) {
  QuitGame($_SESSION['id']);
  header("location: ../index.php");
  exit();
}
?>

<body>
  <!-- Listen du kick avec le code stocké dans la session -->
  <p class="visually-hidden" id="id"><?= $_SESSION['id']; ?></p>
  <script>
    async function ListenKick() {
      const id = document.getElementById("id").innerHTML;
      const result = await fetch('./amikicked.php?id=' + id);
      const value = await result.text();

      if (value.includes("true")) {
        window.location.href = "../index.php";
      }

    }

    async function GameStarted() {
      const result = await fetch('./gamestarted.php?id=<?= $_SESSION['id'] ?>');
      const value = await result.text();

      if (value.trim() == "true") {
        setTimeout('', 500);
        window.location.href = "./ingame.php";
      }
    }

    setInterval(ListenKick, 1000);
    setInterval(GameStarted, 1000);
  </script>
  <?php require_once('../components/header.php') ?>
  <main class="d-flex flex-column mt-5 align-items-center">
    <div class="flex-fill">
      <h1 class="text-center">Vous avez rejoint la partie</h1>
      <p class="text-center">En attente du leader pour commencer</p>
    </div>
    <form method="post" class="w-100 d-flex mt-auto mb-5">
      <button type="submit" name="quit" class="btn gray w-50 w-sm-25 m-auto">Quitter</button>
    </form>
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