<?php
// ArticleModelファイルを読み込み
require_once('../Model/ArticleModel.php');
// Articleクラスを呼び出し
$pdo = new ArticleModel();
// indexメソッドを呼び出し
$articles = $pdo->index();
// モデルからreturnしてきた情報をitemsに格納
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
  <div class="row d-flex align-items-center justify-content-center">
    <div class="col-md-4">
      <?php require_once '../view_public/sidebar.php'; ?>
    </div>

    <div class="col-md-8">
      <table class="table">
        <tbody>
          <?php foreach ($articles as $article) {
            $target = $article["article_image"]; ?>
            <tr>
              <td rowspan="3">
                <?php if ($article["extension"] == "jpeg" || $article["extension"] == "png" || $article["extension"] == "gif") { ?>
                  <img src="../view_common/article_image.php?target=<?= $target ?>" alt="article_image" width=200 height=200>
                <?php } ?>
              </td>
              <td>
                <h5><?= $article['title'] ?></h5>
              </td>
            </tr>
            <tr>
              <td>
                <p><?= $article['body'] ?></p>
              </td>
            </tr>
            <tr>
              <p><small class="text-muted"><?= $article['updated_at'] ?></small></p>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- スライド用jsファイル -->
<script src="../js/top.js"></script>
<?php require_once '../view_common/footer.php'; ?>