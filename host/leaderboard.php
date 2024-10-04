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
  <link rel="stylesheet" href="../style/players.css">
</head>

<?php
require_once('../controller.php');

$players = GetPlayers($_SESSION['code']);
if ($_SESSION['current'] < count($_SESSION['questions'])) {
  UpdatePlayersPoints($players, $_SESSION['questions'][$_SESSION['current']][0][5], $_SESSION['code']);
}

// Refresh
$players = GetPlayers($_SESSION['code'], 10);
?>

<body style="height: 80vh;">
  <?php require_once('../components/header.php'); ?>
  <main class="d-flex flex-column position-relative h-100 px-5">
    <form action="started.php" method="post">
      <?php if (count(GetPlayers($_SESSION['code'])) == 0): ?>
        <button name="exit" type="submit" class="btn btn-danger mt-3 p-2">Partir</button>
      <?php endif; ?>
      <button type="submit" name="next" class="btn gray p-3 end-0 position-absolute m-3"><?php if ($_SESSION['current'] + 1 < count($_SESSION['questions'])) {
                                                                                            echo "Prochaine question";
                                                                                          } else {
                                                                                            echo "Fin du quiz";
                                                                                          } ?></button>
    </form>
    <div class="container mt-4 ms-5 d-flex flex-column flex-wrap" style="height: 65vh;">
      <!-- <div class="col-4"> -->
        <?php 
        $newRow = 0;
        foreach ($players as $player): 
          $newRow++
        ?>
          <div class="d-flex flex-column me-2">
            <div class="gray d-flex flex-row mb-3 border border-3 col-4
            <?php
            if ($player['rep'] == $_SESSION['questions'][$_SESSION['current']][0][5]) {
              echo "border-success";
            } else if ($player['rep'] != $_SESSION['questions'][$_SESSION['current']][0][5] && $player['rep'] != null) {
              echo "border-danger";
            } else {
              echo "border-warning";
            }
            ?>
            ">
              <div class="player-<?= $player['Color'] ?> my-1 mx-2" style="width:30px; height:30px;"></div>
              <div class="d-inline my-auto fs-5 flex-fill"><?= htmlspecialchars($player['Username']) ?></div>
              <div class="d-inline m-auto fs-5 me-2 fw-bold"><?= $player['Points'] ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      <!-- </div> -->
    </div>
    </div>


    <div class="d-flex mt-auto flex-wrap">
      <?php for ($i = 0; $i < 4; $i++): ?>
        <div class="w-50 p-2 <?php if ($i + 1 > 2 && $_SESSION['questions'][$_SESSION['current']][0][$i + 1] == null) {
                                echo "visually-hidden";
                              } ?>">
          <div class="p-4 gray text-center fs-4 <?php if ($i + 1 == $_SESSION['questions'][$_SESSION['current']][0][5]) {
                                                  echo "bg-success";
                                                } ?>"><?= $_SESSION['questions'][$_SESSION['current']][0][$i + 1] ?></div>
        </div>
      <?php endfor; ?>
  </main>
  <?php require_once('../components/footer.php'); ?>
  <?php ResetAnswers($_SESSION['code']); ?>
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