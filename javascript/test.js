async function UpdateScreen() {
  const data = await fetch('getGameStatus.php?id=<?= $_SESSION['id']; ?>');
  const value = await data.text();
  if (value == "leaderboard") {
    next = true;
  } else if (value == "en cours" && next == true) {
    window.location.href = "ingame.php";
  } else if (value == "termine") {
    window.location.href = "joined.php";
  }
}
const Intervalstarted = setInterval(UpdateScreen, 250);