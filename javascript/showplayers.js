async function GetPlayers() {
  const result = await fetch('../host/showplayers.php', {method: "POST"});
  const value = await result.text();
  document.getElementById("displayPlayers").innerHTML = value;
}

setInterval(GetPlayers, 1000);
GetPlayers();