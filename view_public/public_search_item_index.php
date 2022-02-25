<?php
// セッションの宣言
session_start();

// var_dump($_SESSION['search']);
// exit();

if ($_SESSION['search']) {

  // 現在のページ数を取得
  if (isset($_GET['page'])) {
    $page = (int)$_GET['page'];
  } else {
    $page = 1;
  }
  // スタートのページを計算
  if ($page > 1) {
    $start = ($page * 15) - 15;
  } else {
    $start = 0;
  }

  // ItemModelファイルを読み込み
  require_once('../Model/ItemModel.php');
  // itemsテーブルから該当ジャンルのデータ件数を取得
  $pdo = new ItemModel();
  $pages = $pdo->page_count_search_index();
  $page_num = $pages->fetchColumn();
  // ページネーションの数を取得
  $pagination = ceil($page_num / 15);

  // Itemクラスを呼び出し
  $pdo = new ItemModel();
  // search_indexメソッドを呼び出し
  $search_items = $pdo->search_index($start);
  $search_items = $search_items->fetchAll(PDO::FETCH_ASSOC);
} else {
  $_SESSION['search'] = "";
  header('Location: ../view_public/top.php');
}
?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex justify-content-center align-items-start mt-5">
    <div class="col-auto">
      <?php require_once '../view_public/sidebar.php'; ?>
    </div>

    <div class="col-sm-8 ms-3">
      <h3>TOP/<?= $_SESSION['search'] ?></h3>
      <div class="row">
        <?php foreach ($search_items as $item) {
          $target = $item["item_image"]; ?>
          <div class="col-lg-6">
            <div class="card text-white bg-dark mb-3">
              <?php if ($item["extension"] == "jpeg" || $item["extension"] == "png" || $item["extension"] == "gif") { ?>
                <img src="../view_common/item_image.php?target=<?= $target ?>" alt="search_item_image" class="card-img-top img-fluid">
              <?php } ?>
              <div class="card-body">
                <h4 class="card-title"><?= $item['item_name'] ?> / <?= $item['genre_name'] ?></h4>
                <div class="d-flex justify-content-between">
                  <h4 class="card-title">￥<?= $item['price'] ?></h4>
                  <a href="../view_public/item_show.php?item_id=<?= $item['item_id'] ?>" class="btn btn-secondary">詳細を見る</a>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <?php require_once '../view_common/paging.php'; ?>
</div>

<?php require_once '../view_common/footer.php'; ?>