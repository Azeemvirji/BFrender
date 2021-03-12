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

</div>
