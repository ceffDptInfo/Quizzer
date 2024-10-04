var errorMessage;

function init() {
  errorMsg = document.getElementById("errorMessage");
}

function ParseFile(input, code) {

  let reader = new FileReader();
  errorMsg.innerHTML = "";

  let questions;
  let images = [];

  ActivateButton(true);

  for (let file of input.files) {
    const extension = file.name.slice(file.name.lastIndexOf("."));
    if (extension == ".txt") {
      questions = file;
    } else if ([".jpg", ".jpeg", ".gif", ".png"].includes(extension)) {
      if (file.size > 1024 * 1024 * 10) {
        errorMsg.innerHTML = "Une image est plus grande que 10Mo";
        ActivateButton(false);
        return;
      }
      images.push(file);
    }
  }

  if (questions == null || questions == undefined) {
    errorMsg.innerHTML = "Aucun fichier .txt n'a été trouvé !";
    ActivateButton(false);
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
  if (errorMsg.innerHTML == "") {
    ActivateButton(true);
  } else {
    ActivateButton(false);
  }

}

function ActivateButton(activated) {
  if (activated) {
    document.getElementById("start").classList.remove("disabled");
  } else {
    document.getElementById("start").classList.add("disabled");
  }
}