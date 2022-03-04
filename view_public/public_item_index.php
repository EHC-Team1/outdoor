<?php
// セッションの宣言
session_start();

// 該当ジャンル商品一覧表示
// ItemModelファイルを読み込み
require_once('../Model/ItemModel.php');

// 現在のページ数を取得
if (isset($_GET['page'])) {
  $page = (int)$_GET['page'];
} else {
  $page = 1;
}
// スタートのページを計算
if ($page > 1) {
  $start = ($page * 16) - 16;
} else {
  $start = 0;
}

// itemsテーブルから該当ジャンルのデータ件数を取得
$pdo = new ItemModel();
$pages = $pdo->page_count_public_index();
$page_num = $pages->fetchColumn();
// ページネーションの数を取得
$pagination = ceil($page_num / 16);

// Itemクラスを呼び出し
$pdo = new ItemModel();
// public_indexメソッドを呼び出し
$items = $pdo->public_index($start);
// モデルからreturnしてきた情報をitemsに格納
$items = $items->fetchAll(PDO::FETCH_ASSOC);

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
      <h3>TOP / 商品一覧</h3>
      <div class="row">
        <?php foreach ($items as $item) {
          $target = $item["item_image"]; ?>
          <div class="col-lg-6">
            <div class="card text-white bg-dark mb-3">
              <a href="../view_public/item_show.php?item_id=<?= $item["id"] ?>" class="text-white" style="text-decoration:none">
                <?php if ($item["extension"] == "jpeg" || $item["extension"] == "png" || $item["extension"] == "gif") { ?>
                  <img src="../view_common/item_image.php?target=<?= $target ?>" alt="item_image" class="card-img-top img-fluid">
                <?php } ?>
                <div class="card-body">
                  <h4 class="card-title"><?= $item['item_name'] ?></h4>
                  <h4 class="card-title">￥<?= $item['price'] ?></h4>
                </div>
              </a>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <?php require_once '../view_common/paging.php'; ?>
</div>




<?php require_once '../view_common/footer.php'; ?>