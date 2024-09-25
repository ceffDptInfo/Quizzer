let timeleft = 10;
let countdown;

function Countdown() {
  document.getElementById("count").innerHTML = timeleft + "s";
  timeleft--;
  if (timeleft == -1) {
    clearInterval(countdown);
    window.location.href = "../host/leaderboard.php";
  }
}

function init() {
  countdown = setInterval(Countdown, 1000);
  Countdown();
}