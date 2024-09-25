timeleft = 3
let countdown;

function Countdown() {
  document.getElementById("count").innerHTML = timeleft;
  timeleft--;
  if (timeleft == -1) {
    clearInterval(countdown);
    window.location.href =  "../host/started.php";
    }
}

function init() {
  countdown = setInterval(Countdown, 1000);
  Countdown();
}