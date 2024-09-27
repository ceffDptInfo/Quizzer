function ParseFile(input, code) {

  let questions;
  let images = [];
  let reader = new FileReader();

  for (let file of input.files) {
    if (file.name.includes("questions")) {
      questions = file;
    } else {
      images.push(file);
    }
  }

  if (questions == null) {
    document.querySelector("#file-name").classList.remove("visually-hidden")
  }

  const extension = questions.name.slice(questions.name.lastIndexOf("."));

  if (extension == '.txt' || extension == '.qcm') {
    document.querySelector("#file-extension").classList.add("visually-hidden")
    reader.readAsText(questions);

    reader.onload = function () {
      const SplitQuestions = reader.result.split("\n");
      SendFile(SplitQuestions, code, images);
    };

    reader.onerror = function () {
      console.log(reader.error);
    };
  } else {
    document.querySelector("#file-extension").classList.remove("visually-hidden")
  }
}

async function SendFile(result, code, images) {
  const form = new FormData();

  form.append("data", JSON.stringify(result));
  form.append("code", code);
  for (img of images) {
    form.append("file_" + img.name, img);
  }
  const response = await fetch('../host/parsefile.php', {
    method: 'POST',
    body: form
  });
  const text = await response.text();
  console.log(text);

}