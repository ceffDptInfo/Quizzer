var errorMessage;

function init() {
  errorMsg = document.getElementById("errorMessage");
}

function ParseFile(input, code) {

  let reader = new FileReader();
  errorMsg.innerHTML = "";

  let questions;
  let images = [];

  for (let file of input.files) {
    const extension = file.name.slice(file.name.lastIndexOf("."));
    if (extension == ".txt") {
      questions = file;
    } else if ([".jpg", ".jpeg", ".gif", ".png"].includes(extension)) {
      images.push(file);
    }
  }

  if (questions == null || questions == undefined) {
    errorMsg.innerHTML = "Aucun fichier .txt n'a été trouvé !";
    return;
  }
  reader.readAsText(questions);

  reader.onload = function () {
    const SplitQuestions = reader.result.split("\n");
    SendFile(SplitQuestions, code, images);
  };

  reader.onerror = function () {
    console.log(reader.error);
  };

}

async function SendFile(result, code, images) {
  const form = new FormData();

  form.append("data", JSON.stringify(result));
  form.append("code", code);
  for (img of images) {
    form.append("file_" + img.name, img);
  }
  const response = await fetch('../parsefile.php', {
    method: 'POST',
    body: form
  });
  const text = await response.text();
  errorMsg.innerHTML = text;

}