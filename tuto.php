<!doctype html>
<html lang="en">

<head>
  <title>Documentation</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS v5.2.1 -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
    crossorigin="anonymous" />

  <!-- Custom -->
  <link rel="stylesheet" href="./style/style.css">
</head>

<body>
  <?php require_once("./components/header.php") ?>
  <main>
    <div class="m-3">
      <button type="button" class="btn btn-primary position-fixed end-0 me-3" onclick="window.location.href='host/lobby.php'">Retour</button>
      <h2>Comment créer des questions ?</h2>

      <p class="mb-1">Pour créer des question, vous devez <b>créer un dossier</b>, nommez le pour le retrouver. Puis <b>dedans, créer un fichier texte nommé
          <p class="bg-secondary-subtle d-inline p-1 rounded">questions.txt</p>
        </b>. Il doit avoir le nom exact de "questions" sinon il ne sera pas reconnu.</p>

      <h3 class="mt-3">Créer une question simple</h3>
      <p>Voici la syntaxe de base à respecter pour créer des questions</p>
      <ul class="font-monospace">
        <li>Question;Réponse 1;Réponse 2;Réponse 3;Réponse4;&lt;numéro de la bonne réponse (1-4)&gt;</li>
      </ul>
      <p>Exemple : </p>
      <ul class="font-monospace">
        <li>Comment dit-on sciences en Allemand ?;Scienz;Scienss;Wissenschaften;Naturwissenschaften;3</li>
      </ul>

      <h3 class="mt-3">Mettre moins de 4 réponses</h3>
      <p>Une question n'es pas fixé à 4 réponses, elle peut en contenir de 2 à 4.</p>
      <p>Pour ajouter une réponse vide, il faut remplacer le texte de la réponse par "---". Si le numéro de réponse indique une réponse vide, vous aurez une erreur</p>
      <ul class="font-monospace">
        <li>Fabian aime-il le chocolat ?;Oui;Non;---;---;1</li>
      </ul>

      <h3>Paramètres avancés</h3>
      <p>Il est possible d'ajouter des paramètres facultatifs ou des commentaires au fichier</p>

      <h4>Commentaires</h4>
      <p>Toutes les lignes vides ou qui commencent par un "#" vont être ignorés</p>
      <p>TODO : Certains commentaires pourront rédiger une valeur par défaut. Au lieu de taper 20s à chaque fois il suffit de mettre "# TIME:20"</p>

      <h4>Régler le temps</h4>
      <p>Il est possible de régler le nombre de secondes que les joueurs ont pour répondre.</p>
      <p>Pour cela il faut créer le champ des paramètres supplémentaires en écrivant "::" après la bonne réponse. Le nombre indiqué sera le temps (en secondes) disponible aux joueurs (min: 5 max: 240)</p>
      <ul class="font-monospace">
        <li>Fabian aime-il le chocolat ?;Oui;Non;---;---;1::20</li>
        <li>Les joueurs disposent de 20s pour répondre à la question</li>
      </ul>

      <h4>Ajouter des images</h4>
      <p>Il est possible d'ajouter des images à votre quiz. C'est la raison pour laquelle il faut créer un dossier</p>
      <p>Pour ajouter une image, il faut ajouter dans les paramètres avancés le nom du fichier qui doit se trouver dans le meme dossier</p>
      <p>Si votre nom de fichier n'est pas correct une erreur va s'afficher</p>
      <ul class="font-monospace">
        <li>Fabian aime-il le chocolat ?;Oui;Non;---;---;1::20;chocolat.jpg</li>
      </ul>
    </div>
  </main>
  <?php require_once("./components/footer.php") ?>

  <!-- Bootstrap JavaScript Libraries -->
  <script
    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
    crossorigin="anonymous"></script>
</body>

</html>