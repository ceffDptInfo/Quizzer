function SelectColor(event) {
  const selected = document.querySelectorAll(".selected-color");
  if (selected.length > 0) {
    selected[0].classList.remove("selected-color");
    }
    event.target.classList.add("selected-color");
    document.getElementById("colorSelection").value = event.target.classList[0].replace("player-", "");
}