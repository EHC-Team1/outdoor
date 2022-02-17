<?php
// セッションの宣言
session_start();
?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex justify-content-center align-items-start my-5">
    <div class="col-auto">
      <?php require_once '../view_public/sidebar.php'; ?>
    </div>

    <div class="col-md-8 ms-3">
      <div class="row">
        <?php foreach ($search_items as $search_item) {
          $target = $search_item["item_image"]; ?>
          <div class="col-md-6">
            <div class="card text-white bg-dark mb-3">
              <?php if ($search_item["extension"] == "jpeg" || $search_item["extension"] == "png" || $search_item["extension"] == "gif") { ?>
                <img src="../view_common/item_image.php?target=<?= $target ?>" alt="search_item_image" class="card-img-top img-fluid">
              <?php } ?>
              <div class="card-body">
                <h5 class="card-title"><?= $search_item['name'] ?></h5>
                <h5 class="card-title">￥<?= $search_item['price'] ?></h5>
                <div class="d-flex flex-row-reverse">
                  <a href="../view_public/item_show.php?item_id=<?= $search_item['id'] ?>" class="btn btn-secondary">詳細を見る</a>
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