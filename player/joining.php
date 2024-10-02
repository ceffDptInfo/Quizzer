<!doctype html>
<html lang="en">

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
  <link rel="stylesheet" href="../style/players.css">
  <script src="../javascript/color-selection.js"></script>
</head>

<?php
require_once("../controller.php");
$canJoin = true;

if (isset($_POST['code']) && isset($_POST['username']) && isset($_POST['color']) && isset($_POST['join'])) {
  $result = JoinGame($_POST['code'], $_POST['username'], $_POST['color']);
  if ($result != false) {
    $canJoin = true;
    $_SESSION['id'] = $result;
    header("location: joined.php");
    exit();
  } else {
    $canJoin = false;
  }
}
?>

<body>
  <?php require_once('../components/header.php') ?>
  <main>
    <form method="post" class="position-absolute top-50 start-50 translate-middle d-flex flex-column">
      <label for="code" class="d-block fs-5">Code:</label>
      <input type="text" name="code" id="code" class="gray rounded border p-3 w-100" placeholder="AAAA" maxlength="4" minlength="4" style="text-transform: uppercase;" required value="<?= isset($_GET['code']) == true ? $_GET['code'] : ''; ?>">

      <label for="username" class="d-block fs-5">Pseudo:</label>
      <input type="text" name="username" id="username" class="gray rounded border p-3 w-100" minlength="1" maxlength="20" required>

      <!-- La valeur de la couleur est géré par un script js -->
      <input type="hidden" name="color" value="red" id="colorSelection">
      <div class="d-flex flex-wrap mt-5" style="width: 272px;">
        <div class="player-red me-1 mb-1 selected-color" style="width: 30px; height:30px ;" onclick="SelectColor(event);"></div>
        <div class="player-orange me-1 mb-1" style="width: 30px; height:30px ;" onclick="SelectColor(event);"></div>
        <div class="player-gold me-1 mb-1" style="width: 30px; height:30px ;" onclick="SelectColor(event);"></div>
        <div class="player-yellow me-1 mb-1" style="width: 30px; height:30px ;" onclick="SelectColor(event);"></div>
        <div class="player-lime me-1 mb-1" style="width: 30px; height:30px ;" onclick="SelectColor(event);"></div>
        <div class="player-green me-1 mb-1" style="width: 30px; height:30px ;" onclick="SelectColor(event);"></div>
        <div class="player-cyan me-1 mb-1" style="width: 30px; height:30px ;" onclick="SelectColor(event);"></div>
        <div class="player-mint me-1 mb-1" style="width: 30px; height:30px ;" onclick="SelectColor(event);"></div>
        <div class="player-sky me-1 mb-1" style="width: 30px; height:30px ;" onclick="SelectColor(event);"></div>
        <div class="player-blue me-1 mb-1" style="width: 30px; height:30px ;" onclick="SelectColor(event);"></div>
        <div class="player-marine me-1 mb-1" style="width: 30px; height:30px ;" onclick="SelectColor(event);"></div>
        <div class="player-purple me-1 mb-1" style="width: 30px; height:30px ;" onclick="SelectColor(event);"></div>
        <div class="player-violet me-1 mb-1" style="width: 30px; height:30px ;" onclick="SelectColor(event);"></div>
        <div class="player-lila me-1 mb-1" style="width: 30px; height:30px ;" onclick="SelectColor(event);"></div>
        <div class="player-pink me-1 mb-1" style="width: 30px; height:30px ;" onclick="SelectColor(event);"></div>
        <div class="player-rose me-1 mb-1" style="width: 30px; height:30px ;" onclick="SelectColor(event);"></div>
      </div>

      <p class="text-center text-danger <?php if ($canJoin == true) {
                                          echo "visually-hidden";
                                        } ?>">Veuillez choisir une autre couleure</p>
      <button type="submit" name="join" class="btn gray w-100 mt-3">Rejoindre</button>
      <button class="btn gray w-75 mt-3 mx-auto" onclick="window.location.href='../index.php'">Annuler</button>
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