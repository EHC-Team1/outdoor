<?php
// セッションの宣言
session_start();

// ArticleModelファイルを読み込み
require_once('../Model/ArticleModel.php');
// Articleクラスを呼び出し
$pdo = new ArticleModel();
// indexメソッドを呼び出し
$articles = $pdo->index();
// モデルからreturnしてきた情報をarticlesに格納
$articles = $articles->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once '../view_common/header.php'; ?>

<div class="main-visual">
  <div class="slide1"></div>
  <div class="slide2"></div>
  <div class="slide3"></div>
  <div class="slide4"></div>
  <div class="slide5"></div>
</div>

<div class="container">
  <div class="row d-flex justify-content-center align-items-start my-5">
    <div class="col-auto">
      <?php require_once '../view_public/sidebar.php'; ?>
    </div>
    <div class="col-sm-8 ms-3">
      <div class="row row-cols-1 row-cols-md-1 g-3">
        <!-- 公開状態の記事のみ表示 -->
        <?php foreach ($articles as $article) {
          $target = $article["article_image"]; ?>
          <div class="card mb-2" style="max-width: auto;">
            <div class="row g-0">
              <div class="col-lg-5 d-flex align-items-center mt-2">
                <?php if ($article["extension"] == "jpeg" || $article["extension"] == "png" || $article["extension"] == "gif") { ?>
                  <img src="../view_common/article_image.php?target=<?= $target ?>" alt="article_image" class="img-fluid">
                <?php } ?>
              </div>
              <div class="col-lg-7">
                <div class="card-body">
                  <h5 class="card-title"><?= $article['title'] ?></h5>
                  <p class="card-text"><?= $article['body'] ?></p>
                  <p class="card-text"><small class="text-muted"><?= $article['updated_at'] ?></small></p>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>

    <?php require_once '../view_common/footer.php'; ?>