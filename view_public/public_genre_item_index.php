<?php
// セッションの宣言
session_start();

if (isset($_GET["genre_id"]) && $_GET["genre_id"] !== "") {
  $genre_id = $_GET["genre_id"];
} else {
  return false;
}

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
$pages = $pdo->page_count_public_genre_index($genre_id);
$page_num = $pages->fetchColumn();
// ページネーションの数を取得
$pagination = ceil($page_num / 16);

// Itemクラスを呼び出し
$pdo = new ItemModel();
// genre_indexメソッドを呼び出し
$items = $pdo->public_genre_index($genre_id, $start);
// returnしてきた$itemsを$itemsに格納
$items = $items->fetchAll(PDO::FETCH_ASSOC);

// ジャンル名の参照
// GenreModelファイルを読み込み
require_once('../Model/GenreModel.php');
// Genreクラスを呼び出し
$pdo = new GenreModel();
// showメソッドを呼び出し
$selected_genre = $pdo->show($genre_id);
// モデルからreturnしてきた情報をselected_genreに格納
$selected_genre = $selected_genre->fetch(PDO::FETCH_ASSOC);
?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex justify-content-center align-items-start my-5">
    <div class="col-auto">
      <?php require_once '../view_public/sidebar.php'; ?>
    </div>
    <div class="col-sm-8 ms-3">
      <h3>TOP/<?= $selected_genre['name'] ?></h3>
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
                  <h4 class="card-title"><?= $item['name'] ?></h4>
                  <h4 class="card-title">￥<?= $item['price'] ?></h4>
                </div>
              </a>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <div class="row d-flex align-items-center justify-content-center mt-3 mb-5">
    <div class="col-sm-10 d-flex align-items-center justify-content-center">
      <nav aria-label="Page navigation example">
        <ul class='pagination'>
          <?php if ($page == 1) { ?>
            <!-- 現在のページが1の場合disabledに -->
            <li class="page-item disabled">
              <a class="page-link" href="?genre_id=<?= $genre_id ?>&page=<?= 1 ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
          <?php } else { ?>
            <!-- 現在のページが1でなければ有効 -->
            <li class="page-item">
              <a class="page-link" href="?genre_id=<?= $genre_id ?>&page=<?= 1 ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <?php }
          for ($x = 1; $x <= $pagination; $x++) {
            // 現在のページの場合、disabledに
            if ($x == $page) { ?>
              <li class='page-item disabled'>
                <a class="page-link" href="?genre_id=<?= $genre_id ?>&page=<?= $x ?>">
                  <?= $x; ?>
                </a>
              </li>
            <?php
              // 現在のページでなければ有効
            } else { ?>
              <li class='page-item'>
                <a class="page-link" href="?genre_id=<?= $genre_id ?>&page=<?= $x ?>">
                  <?= $x; ?>
                </a>
              </li>
            <?php }
          }
          if ($pagination > $page) { ?>
            <!-- 最終ページでなければ有効 -->
            <li class="page-item">
              <a class="page-link" href="?genre_id=<?= $genre_id ?>&page=<?= ($page + 1) ?>" aria-label="Previous">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          <?php } else { ?>
            <!-- 最終ページの場合disabledに -->
            <li class="page-item disabled">
              <a class="page-link" href="?genre_id=<?= $genre_id ?>&page=<?= ($page + 1) ?>" aria-label="Previous">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          <?php } ?>
        </ul>
      </nav>
    </div>
  </div>
</div>

<?php require_once '../view_common/footer.php'; ?>