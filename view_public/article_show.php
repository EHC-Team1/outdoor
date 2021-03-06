<?php
// セッションの宣言
session_start();

if (isset($_GET["article_id"]) && $_GET["article_id"] !== "") {
  $article_id = $_GET["article_id"];
} else {
  return false;
}

// ArticleModelファイルを読み込み
require_once('../Model/ArticleModel.php');
//  Articleクラスを呼び出し
$pdo = new ArticleModel();
// showメソッドを呼び出し
$article_show = $pdo->show($article_id);
// 取得データを配列に格納
$article_show = $article_show->fetch(PDO::FETCH_ASSOC);

// article_itemメソッドを呼び出し
$items = $pdo->article_item($article_id);
// 取得データを配列に格納
$items = $items->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex justify-content-center align-items-start my-5">
    <div class="col-auto">
      <?php require_once '../view_public/sidebar.php' ?>
    </div>
    <div class="col-sm-8 ms-3">
      <div class="row">
        <?php $target = $article_show["article_image"]; ?>
        <?php if ($article_show["extension"] == "jpeg" || $article_show["extension"] == "png" || $article_show["extension"] == "gif") { ?>
          <img src="../view_common/article_image.php?target=<?= $target ?>" alt="article_image" class="img-fluid">
        <?php } ?>
      </div>
      <div class="row text-end mt-3">
        <small class="text-muted">
          <?= $article_show["updated_at"] ?>
        </small>
      </div>
      <div class="row">
        <h3><?= $article_show["title"] ?></h3>
      </div>
      <div class="row mt-3">
        <p>
          <?= nl2br($article_show["body"]) ?>
        </p>
      </div>
      <!-- 購入可能状態の関連商品がある場合に表示 -->
      <?php if (!empty($items)) { ?>
        <h3>関連商品</h3>
        <div class="row-cols-1 row-cols-md-1 g-3">
          <?php foreach ($items as $item) {
            $target = $item["item_image"]; ?>
            <div class="card mb-2" style="max-width: auto;">
              <a href="../view_public/item_show.php?item_id=<?= $item["item_id"] ?>" class="text-dark" style="text-decoration:none">
                <div class="row g-0">
                  <div class="col-lg-5 d-flex align-items-center">
                    <div class="card-body">
                      <?php if ($item["item_extension"] == "jpeg" || $item["item_extension"] == "png" || $item["item_extension"] == "gif") { ?>
                        <img src="../view_common/item_image.php?target=<?= $target ?>" alt="item_image" class="img-fluid">
                      <?php } ?>
                    </div>
                  </div>
                  <div class="col-lg-7 d-flex align-items-center">
                    <div class="card-body">
                      <h3 class="card-title"><?= $item['name'] ?> / <?= $item['genre_name'] ?></h3>
                      <h4 class="card-text">￥<?= $item['price'] ?></h4>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
    </div>

    <?php require_once '../view_common/footer.php'; ?>