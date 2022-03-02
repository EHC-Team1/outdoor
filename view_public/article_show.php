<?php
// セッションの宣言
session_start();

// 詳細ページへ飛ぶ何らかのアクションがあった時、記事idを変数へ代入
// TOP.php , public_search_index.phpにaタグ設置
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
$article = $pdo->show($article_id);
// 取得データを配列に格納
$article = $article->fetch(PDO::FETCH_ASSOC);

// article_itemメソッドを呼び出し
$item = $pdo->article_item($article_id);
// 取得データを配列に格納
$item = $item->fetch(PDO::FETCH_ASSOC);
?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex justify-content-center align-items-start my-5">
    <div class="col-auto">
      <?php require_once '../view_public/sidebar.php' ?>
    </div>
    <div class="col-sm-8 ms-3">
      <div class="row">
        <?php $target = $article["article_image"]; ?>
        <?php if ($article["extension"] == "jpeg" || $article["extension"] == "png" || $article["extension"] == "gif") { ?>
          <img src="../view_common/article_image.php?target=<?= $target ?>" alt="article_image" class="img-fluid">
        <?php } ?>
      </div>
      <div class="row text-end mt-3">
        <small class="text-muted">
          <?= $article["updated_at"] ?>
        </small>
      </div>
      <div class="row">
        <h3><?= $article["title"] ?></h3>
      </div>
      <div class="row mt-3">
        <p>
          <?= $article["body"] ?>
        </p>
      </div>
      <!-- 関連商品あり、販売可能状態の場合に表示 -->
      <?php if ((!empty($item['item_article_id'])) && ($item['item_is_status'] == 1)) {
        $target = $item["item_image"]; ?>
        <div class="row-cols-1 row-cols-md-1 g-3 mt-3">
          <h3 class="">関連商品</h3>
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
        </div>
      <?php } ?>
    </div>

    <?php require_once '../view_common/footer.php'; ?>