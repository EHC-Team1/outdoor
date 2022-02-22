<?php
// セッションを宣言
session_start();

// CartItemModelファイル読み込み
require_once('../Model/CartItemModel.php');
// CartItemクラス呼び出し
$pdo = new CartItemModel();
// indexメソッド呼び出し
$cart_items = $pdo->index();

// 更新ボタンが押下された時
if (isset($_POST['update'])) {
  // CartItemクラスを呼び出し
  $pdo = new CartItemModel();
  // updateメソッドを呼び出し
  $cart_item = $pdo->update();

  // 削除ボタンが押下された時
} elseif (isset($_POST['delete'])) {
  // var_dump($_POST['delete']);
  // exit;
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
  //header('Location: cart_item_index.php');
}

?>

<?php require_once('../view_common/header.php') ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center mt-5 mb-5">ショッピングカート</h1>
    <div class="col-md-8">
      <!-- カート内商品の表示 -->
      <?php $cart_items = $cart_items->fetchAll(PDO::FETCH_ASSOC);
      // 合計の初期値は0
      $total = 0;
      foreach ($cart_items as $cart_item) {
        // 各商品の小計を取得
        $subtotal = (int)$cart_item['price'] * (int)$cart_item['quantity'];
        // 各商品の小計を$totalに足す
        $total += $subtotal;
        $target = $cart_item["item_image"]; ?>
        <div class="card mb-4">
          <div class="row">
            <div class="col">
              <div class="card-body">
                <?php
                if ($cart_item["extension"] == "jpeg" || $cart_item["extension"] == "png" || $cart_item["extension"] == "gif") {
                  echo ("<img src='../view_common/item_image.php?target=$target'width=200 height=200>");
                }
                ?>
              </div>
            </div>
            <div class="col">
              <div class="card m-3">
                <div class="card-body">
                  <form method="post" id="cart_item_index">
                    <input type="hidden" name="id" value="<?php echo $cart_item['id'] ?>">
                    <button type="submit" name="delete" class="btn-close text-right" aria-label="Close"></button>
                    <?= $cart_item['name'] ?><br>
                    ¥<?= number_format($cart_item['price']); ?>(税込)
                    小計 ¥<?= number_format($subtotal); ?>
                    <select class="form-select form-select-lg mt-2 mb-2" name="quantity">
                      <option selected><?= $cart_item['quantity'] ?></option>
                      <?php for ($quantity = 1; $quantity <= 50; $quantity++) { ?>
                        <option name="quantity" value="<?= $quantity ?>"><?= $quantity ?></option>
                      <?php } ?>
                    </select>
                    <button type="submit" name="update" class="btn btn-outline-success">更新</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
      <table class="table table-borderless">
        <tbody>
          <tr>
            <td class="text-center">商品合計(税込み)</td>
            <td>¥<?= number_format($total); ?></td><br>
          </tr>
          <tr>
            <td class="text-center">送料</td>
            <td>¥500</td>
          </tr>
        </tbody>
      </table>
      <div class="card">
        <div class="card-body">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td class="text-center">
                  <h5>注文合計(税込)</h5>
                </td>
                <td>¥<?= number_format($total + 500); ?></td><br>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="d-flex align-items-center justify-content-evenly mt-5 mb-5 md-5">
        <button type="submit" name="all_delete" form="cart_item_index" class="btn btn-outline-danger btn-lg">カート内を空にする</button>
        <button type="submit" class="btn btn-outline-success btn-lg" onclick="location.href='top.php'">お買い物を続ける</button>
        <?php if (!empty($cart_item)) : ?>
          <button type="submit" class="btn btn-outline-primary btn-lg" onclick="location.href='public_order_input.php'">ご注文手続きへ</button>
        <?php elseif(empty($cart_item)) : ?>
        <?php endif ?>
      </div>
    </div>
  </div>
</div>

<?php require_once('../view_common/footer.php') ?>