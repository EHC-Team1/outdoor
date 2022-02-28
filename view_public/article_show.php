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
// TOP.php , public_search_index.phpにaタグ設置
if (isset($_GET["article_id"]) && $_GET["article_id"] !== "") {
  $article_id = $_GET["article_id"];
  // } else {
  //   return false;
}

// ArticleModelファイルを読み込み
require_once('../Model/ArticleModel.php');
//  Articleクラスを呼び出し
$pdo = new ArticleModel();
// showメソッドを呼び出し
$articles_show = $pdo->show($article_id);
// 取得データを配列に格納
$articles_show = $articles_show->fetch(PDO::FETCH_ASSOC);

// ItemModelファイルを読み込み
// require_once('../Model/ItemModel.php');
//  Articleクラスを呼び出し
// $pdo = new ItemModel();
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
    <div class="col-md-7">
      <div class="row">
        <?php $target = $articles_show["article_image"]; ?>
        <?php if ($articles_show["extension"] == "jpeg" || $articles_show["extension"] == "png" || $articles_show["extension"] == "gif") { ?>
          <img src="../view_common/article_image.php?target=<?= $target ?>" alt="article_image" class="img-fluid">
        <?php } ?>
      </div>
      <div class="row mt-4">
        <smalls class="text-muted">
          <div class="d-flex justify-content-end"><?= $articles_show["updated_at"] ?></div>
        </small>
      </div>
      <div class="row">
        <h3 class="ms-3"><?= $articles_show["title"] ?></h3>
      </div>
      <div class="row mt-3">
        <div class="ms-5"><?= nl2br($articles_show["body"]) ?></div>
      </div>
      <!-- 関連商品あり、販売可能状態の場合に表示 -->
      <?php if ((!empty($item['item_article_id'])) && ($item['item_is_status'] == 1)) : ?>
        <div class="row row-cols-1 row-cols-md-1 g-3 mt-3">
          <div class="card mb-3" style="max-width: auto;">
            <a href="../view_public/item_show.php?item_id=<?= $item["item_id"] ?>" class="card-body text-dark" style="text-decoration:none">
              <div class="row g-0">
                <div class="col-md-4">
                  <?php $target = $item["item_image"]; ?>
                  <?php if ($item["item_extension"] == "jpeg" || $item["item_extension"] == "png" || $item["item_extension"] == "gif") { ?>
                    <img src="../view_common/item_image.php?target=<?= $target ?>" alt="item_image" class="img-fluid">
                  <?php } ?>
                </div>
                <div class="col-md-6">
                  <div class="card-body">
                    <h3 class="mb-4">関連商品</h3>
                    <h3 class="card-title ms-3 mb-2"><?= $item['name'] ?> / <?= $item['genre_name'] ?></h3>
                    <h3 class="card-text ms-3">￥<?= $item['price'] ?></h3>
                  </div>
                </div>
              </div>
            </a>
          </div>
        </div>
      <?php endif ?>
    </div>

    <?php require_once '../view_common/footer.php'; ?>