<?php
// セッションの宣言
session_start();

// // ログインしているかチェック
// if (isset($_SESSION['customer'])) {
// } else {
//   header("Location: ../view_public/top.php");
//   die();
// }

// 詳細ページへ飛ぶ何らかのアクションがあった時、記事idを変数へ代入
if (isset($_GET["id"]) && $_GET["id"] !== "") {
  $id = $_GET["id"];
  // } else {
  //   return false;
}

// ArticleModelファイルを読み込み
require_once('../Model/ArticleModel.php');
//  Articleクラスを呼び出し
$pdo = new ArticleModel();
// showメソッドを呼び出し
$articles_show = $pdo->show();
// 取得データを配列に格納
$articles_show = $articles_show->fetch(PDO::FETCH_ASSOC);

?>


<?php require_once '../view_common/header.php'; ?>
<div class="container">
  <div class="row d-flex justify-content-center align-items-start my-5">
    <div class="col-auto">
    <?php require_once '../view_public/sidebar.php' ?>
    </div>
    <div class="col-md-7">
      <div class="row">
        <?php $target = $articles_show["article_image"]; ?>
        <?php if ($articles_show["extension"] == "jpeg" || $articles_show["extension"] == "png" || $articles_show["extension"] == "gif") { ?>
          <img src="../view_common/article_image.php?target=<?= $target ?>" alt="article_image" class="img-fluid">
        <?php } ?>
      </div>
      <div class="row mt-3">
        <h3 class="ms-3"><?= $articles_show["title"] ?></h3>
      </div>
      <div class="row mt-3 mb-3">
        <div class="ms-5"><?= nl2br($articles_show["body"]) ?></div>
      </div>
      <div class="row row-cols-1 row-cols-md-1 g-3">
      <!-- 関連記事が公開状態の時に表示 -->
      <?php if ($item['article_is_status'] == 1) {
              echo ("<div class='card g-0' style='max-width: auto;'>");
            } ?>
        <div class="row m-2">
          <div class="col-md-5">
            <?php $target = $article["article_image"]; ?>
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
      <!-- 関連記事が公開状態の時に表示 -->
      <?php if ($item['article_is_status'] == 1) {
              echo ("</div>");
            } ?>
      </div>
    </div>
  </div>
</div>

<?php require_once '../view_common/footer.php'; ?>