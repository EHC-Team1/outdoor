<?php
// セッションを宣言
session_start();

// ログインしているかチェック
if (isset($_SESSION['customer'])) {
} else {
  // ログインしていなければトップ画面に遷移
  header("Location: ../view_public/top.php");
}

// CartItemModelファイル読み込み
require_once('../Model/CartItemModel.php');

// CartItemクラス呼び出し
$pdo = new CartItemModel();
// count_cart_itemsメソッド呼び出し
$count_cart_items = $pdo->count_cart_items();
// カート内商品数を取得
$count_cart_items = $count_cart_items->fetchColumn();

// CartItemクラス呼び出し
$pdo = new CartItemModel();
// indexメソッド呼び出し
$cart_items = $pdo->index();
$cart_items = $cart_items->fetchAll(PDO::FETCH_ASSOC);

// 更新ボタンが押下された時
if (isset($_POST['cart_item_id'])) {
  // CartItemクラスを呼び出し
  $pdo = new CartItemModel();
  // updateメソッドを呼び出し
  $cart_item = $pdo->update();

  // 削除ボタンが押下された時
} elseif (isset($_POST['delete'])) {
  // CartItemクラスを呼び出し
  $pdo = new CartItemModel();
  // deleteメソッドを呼び出し
  $cart_item = $pdo->delete();

  // カート内を空にするボタンが押下された時
} elseif (isset($_POST['all_delete'])) {
  // CartItemクラスを呼び出し
  $pdo = new CartItemModel();
  // all_deleteメソッドを呼び出し
  $cart_item = $pdo->all_delete();
} else {
}
// header('Location: cart_item_index.php');
?>

<?php require_once('../view_common/header.php') ?>

<div class="container">
  <!-- カートに商品がある場合 -->
  <?php if ($count_cart_items) { ?>
    <h1 class="text-center my-5">ショッピングカート</h1>
    <div class="row d-flex align-items-start justify-content-center">
      <div class="col-sm-8">
        <div class="row-cols-1 row-cols-md-1 g-3">
          <?php // 合計の初期値は0
          $total = 0;
          foreach ($cart_items as $cart_item) {
            $target = $cart_item["item_image"];
            // 各商品の小計を取得
            $subtotal = (int)$cart_item['price'] * (int)$cart_item['quantity'];
            // 各商品の小計を$totalに足す
            $total += $subtotal; ?>
            <div class="card mb-3" style="max-width: auto;">
              <div class="row g-0">
                <div class="col-lg-5 d-flex align-items-center">
                  <div class="card-body">
                    <a href="../view_public/item_show.php?item_id=<?= $cart_item["item_id"] ?>" class="text-dark" style="text-decoration:none">
                      <?php if ($cart_item["extension"] == "jpeg" || $cart_item["extension"] == "png" || $cart_item["extension"] == "gif") { ?>
                        <img src="../view_common/item_image.php?target=<?= $target ?>" alt="item_image" class="img-fluid">
                      <?php } ?>
                    </a>
                  </div>
                </div>
                <div class="col-lg-7 d-flex align-items-center">
                  <div class="card-body">
                    <form method="post" id="cart_item_index">
                      <input type="hidden" name="id" value="<?= $cart_item['id'] ?>">
                      <button type="submit" name="delete" class="btn-close position-absolute top-0 end-0" aria-label="Close"></button>
                      <h4 class="text-center"><?= $cart_item['name'] ?></h4>
                      <div class="row d-flex justify-content-center my-4">
                        <div class="col-sm-8">
                          <h4 class="text-center">¥<?= number_format($cart_item['price']); ?>(税込)</h4>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-select" name="<?= $cart_item['id'] ?>">
                            <option value="<?= $cart_item['quantity'] ?>"><?= $cart_item['quantity'] ?></option>
                            <?php for ($quantity = 1; $quantity <= 50; $quantity++) { ?>
                              <option name="<?= $cart_item['id'] ?>" value="<?= $quantity ?>"><?= $quantity ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <h4 class="text-center"> 小計 ¥<?= number_format($subtotal); ?></h4>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
          <div class="card mb-2" style="max-width: auto;">
            <div class="row g-0">
              <div class="card-body">
                <div class="row d-flex justify-content-center">
                  <div class="col-sm-8">
                    <h4 class="text-center">商品合計(税込み) ¥<?= number_format($total); ?></h4>
                  </div>
                  <div class="col-sm-4">
                    <h4 class="text-center">送料 ¥500</h4>
                  </div>
                  <h4 class="text-center mt-4">注文合計(税込)¥<?= number_format($total + 500); ?></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row d-flex justify-content-center my-5">
      <div class="col-sm-8 d-flex justify-content-around">
        <button type="submit" name="all_delete" form="cart_item_index" class="btn btn-outline-danger">カート内を空にする</button>
        <button type="submit" class="btn btn-outline-info mx-4" onclick="location.href='top.php'">お買い物を続ける</button>
        <button type="submit" class="btn btn-outline-primary" onclick="location.href='public_order_input.php'">ご注文手続きへ</button>
      </div>
    </div>
  <?php } else { ?>
    <div class="row d-flex justify-content-center">
      <h1 class="text-center my-5">カートに商品がありません。</h1>
      <div class="col-sm-10 d-flex justify-content-center">
        <button type="submit" class="btn btn-outline-info btn-lg" onclick="location.href='top.php'">トップへ</button>
      </div>
    </div>
  <?php } ?>
</div>

<!-- カート商品更新用js -->
<script src="../js/cart_item_index.js"></script>
<?php require_once('../view_common/footer.php') ?>