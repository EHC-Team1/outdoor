<?php
// セッションの宣言
session_start();

if (isset($_GET["genre_id"]) && $_GET["genre_id"] !== "") {
  $genre_id = $_GET["genre_id"];
} else {
  return false;
}

// 選択ジャンル一覧表示
// ItemModelファイルを読み込み
require_once('../Model/ItemModel.php');
// Itemクラスを呼び出し
$pdo = new ItemModel();
// genre_indexメソッドを呼び出し
$items = $pdo->genre_index($genre_id);
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
    <div class="col-md-8 ms-3">
      <h3>TOP/<?= $selected_genre['name'] ?></h3>
      <div class="row">
        <?php foreach ($items as $item) {
          $target = $item["item_image"]; ?>
          <div class="col-md-6">
            <div class="card text-white bg-dark mb-3">
              <?php if ($item["extension"] == "jpeg" || $item["extension"] == "png" || $item["extension"] == "gif") { ?>
                <img src="../view_common/item_image.php?target=<?= $target ?>" alt="item_image" class="card-img-top img-fluid">
              <?php } ?>
              <div class="card-body">
                <h4 class="card-title"><?= $item['item_name'] ?></h4>
                <div class="d-flex justify-content-between">
                  <h4 class="card-title">￥<?= $item['price'] ?></h4>
                  <a href="../view_public/item_show.php?item_id=<?= $item['id'] ?>" class="btn btn-secondary">詳細を見る</a>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<?php require_once '../view_common/footer.php'; ?>