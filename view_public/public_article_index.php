<?php require_once '../view_common/header.php'; ?>

<div class="container">

  <div class="row d-flex justify-content-center align-items-start my-5">
    <div class="col-auto">
      <?php require_once '../view_public/sidebar.php'; ?>
    </div>

    <div class="col-md-8 ms-3">
      <?php
      foreach ($search_articles as $search_article) {
        $target = $search_article["article_image"]; ?>
        <div class="row row-cols-1 row-cols-md-1 g-3">
          <div class="card g-0" style="max-width: auto;">
            <div class="row m-2">
              <div class="col-md-5">
                <?php if ($search_article["extension"] == "jpeg" || $search_article["extension"] == "png" || $search_article["extension"] == "gif") { ?>
                  <img src="../view_common/article_image.php?target=<?= $target ?>" alt="search_article_image" class="img-fluid">
                <?php } ?>
              </div>
              <div class="col-md-7">
                <div class="card-body">
                  <h5 class="card-title"><?= $search_article['name'] ?></h5>
                  <p class="card-text"><?= $search_article['introduction'] ?></p>
                  <p class="card-text"><small class="text-muted"><?= $search_article['updated_at'] ?></small></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
<?php require_once '../view_common/footer.php'; ?>