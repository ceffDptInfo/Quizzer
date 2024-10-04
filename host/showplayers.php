<?php
require_once('../controller.php');
$players = GetPlayers($_SESSION['code']);
?>

<?php foreach ($players as $player): ?>
  <?php if (time() - $player['timestamp'] > 10) {
    KickPlayer($player['Username'], $player['Color'], $_SESSION['code']);
  } ?>
  <form method="post" class="mb-3">
    <div class="<?= count($players) > 13 ? "col-11" : "col-4" ?>">
      <div class="d-flex gray p-1">
        <input type="hidden" name="color" value="<?= $player['Color'] ?>">
        <input type="hidden" name="name" value="<?= htmlspecialchars($player['Username']) ?>">
        <button type="submit" name="kick" class="player-<?= $player['Color'] ?> text-center align-content-center fw-bold" style="height: 30px; width: 30px; border:none;">X</button>
        <div class="flex-fill align-content-center ms-2"><?= $player['Username'] ?></div>
      </div>
    </div>
  </form>
<?php endforeach ?>