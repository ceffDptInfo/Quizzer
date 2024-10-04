<?php $responses = GetResponses($_SESSION['id']); ?>
<form method="post">
  <div class="d-flex position-absolute flex-column flex-sm-row translate-middle-y translate-sm-middle w-100 w-sm-auto start-0 start-sm-50 px-2 px-sm-5 top-50 flex-wrap text-center row-cols-2 row-cols-sm-12">
    <?php foreach ($responses as $key => $rep) {
      if ($rep != null) {
    ?>
        <button name="rep" value="<?= $key + 1 ?>" class="btn gray m-sm-2 col-sm col-12 my-2 my-sm-0 w-100" id="response"><?= $rep ?></button>
    <?php }
    } ?>
  </div>
</form>