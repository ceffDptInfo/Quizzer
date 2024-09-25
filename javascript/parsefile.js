function ParseFile(input, code) {

  let file = input.files[0];
  let reader = new FileReader();
  const extension = file['name'].slice(file['name'].lastIndexOf("."));

  if (extension == '.txt' || extension == '.qcm') {
    document.querySelector("#file-extension").classList.add("visually-hidden")
    reader.readAsText(file);

    reader.onload = function () {
      const SplitQuestions = reader.result.split("\n");
      SendFile(SplitQuestions, code);
    };

    reader.onerror = function () {
      console.log(reader.error);
    };
  } else {
    document.querySelector("#file-extension").classList.remove("visually-hidden")
  }
}

async function SendFile(result, code) {
  const form = new FormData();
  result.push(code)
  form.append("data", JSON.stringify(result));
  const response = await fetch('../host/parsefile.php', {
    method: 'POST',
    body:form
  });
  const text = await response.text();
  console.log(text);
  
}