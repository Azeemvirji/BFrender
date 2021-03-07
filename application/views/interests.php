<div class = "container">
  <h3>Interests</h3>
  <? foreach($category as $row){ ?>
    <h4><?= $row['categoryName'] ?></h4>
    <?php foreach ($tags as $tag): ?>
      <?php if ($tag['categoryId'] == $row['categoryId']): ?>
        <p><?= $tag['tagName'] ?></p>
      <?php endif; ?>
    <?php endforeach; ?>
  <? } ?>

  <strong><?= validation_errors() ?></strong>

  <h3>AddTag</h3>
  <?= form_open("Interests/AddTag") ?>
  <?= form_label('Select Category:', 'category'); ?> <br/>
  <select id="category" name="category">
    <? foreach($category as $row){ ?>
      <option value="<?= $row['categoryId'] ?>"><?= $row['categoryName'] ?></option>
    <? } ?>
  </select><br/><br/>
  <?= form_submit('submit', 'Submit'); ?>
  <?= form_reset('reset', 'Clear'); ?>
  <?= form_close() ?>


</div>
