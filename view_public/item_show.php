<?php
if (isset($_GET["item_id"]) && $_GET["item_id"] !== "") {
  $item_id = $_GET["item_id"];
} else {
  return false;
}

// ItemModelファイルを読み込み
require_once('../Model/ItemModel.php');
// Itemクラスを呼び出し
$pdo = new ItemModel();
// search_indexメソッドを呼び出し
$item = $pdo->show($item_id);
// returnしてきた$itemを$itemに格納
$item = $item->fetch(PDO::FETCH_ASSOC);
?>

<?php require_once '../view_common/header.php'; ?>
<div class="container">
  <div class="row d-flex justify-content-center align-items-start my-5">
    <div class="col-auto">
      <?php require_once '../view_public/sidebar.php'; ?>
    </div>
    <div class="col-md-7">
      <div class="row">
        <?php $target = $item["item_image"]; ?>
        <?php if ($item["extension"] == "jpeg" || $item["extension"] == "png" || $item["extension"] == "gif") { ?>
          <img src="../view_common/item_image.php?target=<?= $target ?>" alt="item_image" class="img-fluid">
        <?php } ?>
      </div>
      <div class="row mb-3">
        <h3 class="ms-3"><?= $item['item_name'] ?> / <?= $item['genre_name'] ?></h3>
        <h2 class="ms-3 mt-4">￥<?= $item['price'] ?></h2>
      </div>
      <div class="row mb-3">
        <h6 class="ms-3 text-center"><?= $item['introduction'] ?></h6>
      </div>
      <div class="row">
      </div>
    </div>
  </div>
</div>

<?php require_once '../view_common/footer.php'; ?>