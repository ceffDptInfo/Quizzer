let timeleft;
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
  timeleft = document.getElementById("time").innerHTML.trim();
  if (timeleft == "") {
    timeleft = 10;
  }

  if (timeleft < 5) {
    timeleft = 5;
  } else if (timeleft > 120) {
    timeleft = 120;
  }
  countdown = setInterval(Countdown, 1000);
  Countdown();
}