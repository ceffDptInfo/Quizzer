<?php $responses = GetResponses($_SESSION['id']); ?>
<form method="post">
  <input type="hidden" name="time" id="time">
  <div class="d-flex px-5 position-absolute top-50 start-50 translate-middle w-100 flex-wrap text-center">
    <?php foreach ($responses as $key => $rep) {
      if ($rep != null) {
    ?>
        <button name="rep" value="<?= $key + 1 ?>" class="btn gray m-2 col" style="height: 350px;"><?= $rep ?></button>
    <?php }
    } ?>
  </div>
</form>