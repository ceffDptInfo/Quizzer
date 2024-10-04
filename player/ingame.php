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
</head>
<?php
require_once('../controller.php');

if (isset($_POST['rep'])) {
  SendResponse($_POST['rep'], date('Y-m-d H:i:s'), $_SESSION['id']);
  header('location: sent.php');
  exit();
}
?>

<body>
  <?php require_once('../components/header.php') ?>
  <main>
    <div class="visually-hidden" id="starting">
      <?php require_once('../components/hold.php'); ?>
    </div>
    <div class="visually-hidden" id="playing">
      <?php require_once('../components/reps.php') ?>
    </div>

    <script>
      async function UpdateScreen() {
        const data = await fetch('getGameStatus.php?id=<?= $_SESSION['id']; ?>');
        const value = await data.text();

        if (value == "commence") {
          document.getElementById("starting").classList.remove("visually-hidden");
        } else if (value == "en cours") {
          document.getElementById("starting").classList.add("visually-hidden");
          document.getElementById("playing").classList.remove("visually-hidden");
          if (typeof Intervalpoints === 'undefined') {
            const Intervalpoints = setInterval(RemovePoints, 20);
          }
        } else if (value == "leaderboard") {
          window.location.href = "sent.php?out=true";
        }
      }
      const Intervalstarted = setInterval(UpdateScreen, 250);
    </script>
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