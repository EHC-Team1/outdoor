<div class="card g-0" style="max-width: auto;">
  <div class="row m-2">
    <div class="col-md-5">
      <?php if ($article["extension"] == "jpeg" || $article["extension"] == "png" || $article["extension"] == "gif") { ?>
        <img src="../view_common/article_image.php?target=<?= $target ?>" alt="article_image" class="img-fluid">
      <?php } ?>
    </div>
    <div class="col-md-7">
      <div class="card-body">
        <h5 class="card-title"><?= $article['title'] ?></h5>
        <p class="card-text"><?= $article['body'] ?></p>
        <p class="card-text"><small class="text-muted"><?= $article['updated_at'] ?></small></p>
      </div>
    </div>
  </div>
</div>