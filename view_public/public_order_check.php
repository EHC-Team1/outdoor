<?php
// セッションを宣言
session_start();

// CartItemModelファイル読み込み
require_once('../Model/CartItemModel.php');
// CartItemクラス呼び出し
$pdo = new CartItemModel();
// indexメソッド呼び出し
$cart_items = $pdo->index();

// 注文を確定するボタンが押された場合
if (isset($_POST['fixed_order'])) {
  // OrderModelファイルを読み込み
  require_once('../Model/OrderModel.php');
  // Orderクラスを呼び出し
  $pdo = new OrderModel();
  // inputメソッドを呼び出してordersテーブルへ格納
  $order = $pdo->input();
  $order_id = $order;
  // OrderDetailModelファイル読み込み
  require_once('../Model/OrderDetailModel.php');
  // OrderDetailクラス呼び出し
  $pdo = new OrderDetailModel();
  $cart_items = $cart_items->fetchAll(PDO::FETCH_ASSOC);
  // inputメソッドを呼び出してorder_detailsテーブルへ格納
  $order_details = $pdo->input($order_id, $cart_items);
  // CartItemクラスを呼び出し
  $pdo = new CartItemModel();
  // all_deleteメソッドを呼び出し
  $cart_item = $pdo->all_delete();
  header('Location: public_order_complete.php');
}

// ご自身の住所が選択された場合
if ($_POST['delivery'] == 0) {
  // CustomerModelファイルを読み込み
  require_once('../Model/CustomerModel.php');
  // Customerクラス呼び出し
  $pdo = new CustomerModel();
  // showメソッドを呼び出し
  $customers = $pdo->show();
  $customers = $customers->fetch(PDO::FETCH_ASSOC);
  // 登録済の配送先が選択された場合
} else {
  $delivery_id = $_POST['delivery_id'];
  // Deliveryクラス呼び出し
  require_once('../Model/DeliveryModel.php');
  // Deliveryクラスを呼び出し
  $pdo = new DeliveryModel();
  // showメソッドを呼び出し
  $customers = $pdo->show($delivery_id);
  $customers = $customers->fetch(PDO::FETCH_ASSOC);
}

?>

<?php require_once '../view_common/header.php'; ?>
<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center mt-5 mb-3">注文情報の確認</h1>
    <div class="col-md-9">
      <form method="POST">
        <div class="d-flex justify-content-end">
          <button type="submit" name="back" formaction="./public_order_input.php" class="btn btn-outline-secondary mb-3">注文情報入力へ戻る</button>
        </div>
        <input type="hidden" name="customer_id" value="<?= $_SESSION['customer']['id'] ?>">
        <table class="table table-bordered border-dark">
          <thead class="table-active">
            <tr>
              <th scope="col" class="col-6">商品名</th>
              <th scope="col" class="col-2">単価(税込み)</th>
              <th scope="col" class="col-2">数量</th>
              <th scope="col" class="col-2">小計</th>
            </tr>
          </thead>
          <!-- 購入商品の表示 -->
          <?php $cart_items = $cart_items->fetchAll(PDO::FETCH_ASSOC);
          // 合計の初期値は0
          $total = 0;
          foreach ($cart_items as $cart_item) {
            // 各商品の小計を取得
            $subtotal = (int)$cart_item['price'] * (int)$cart_item['quantity'];
            // 各商品の小計を$totalに足す
            $total += $subtotal;
            $target = $cart_item["item_image"]; ?>
            <tbody>
              <tr>
                <form method="post" id="cart_item_index">
                  <input type="hidden" name="id" value="<?= $cart_item['id'] ?>">
                  <input type="hidden" name="item_id" value="<?= $cart_item['item_id'] ?>">
                  <td>
                    <?php
                    if ($cart_item["extension"] == "jpeg" || $cart_item["extension"] == "png" || $cart_item["extension"] == "gif") {
                      echo ("<img src='../view_common/item_image.php?target=$target'width=60 height=60>");
                    }
                    ?>
                    <?= $cart_item['name'] ?>
                  </td>
                  <td class="align-middle"><?= number_format($cart_item['price']); ?></td>
                  <input type="hidden" name="price" value="<?= $cart_item['price'] ?>">
                  <td class="align-middle"><?= number_format($cart_item['quantity']); ?></td>
                  <input type="hidden" name="quantity" value="<?= $cart_item['quantity'] ?>">
                  <td class="align-middle"><?= number_format($subtotal); ?></td>
                </form>
              </tr>
            </tbody>
          <?php } ?>
        </table>
        <div class="row">
          <div class="col-md-4">
            <table class="table table-bordered border-dark">
              <tbody>
                <tr>
                  <th scope="col" class="table-active">送料</th>
                  <td>500</td>
                  <input type="hidden" name="postage" value="500">
                </tr>
                <tr>
                  <th scope="col" class="table-active">商品合計</th>
                  <td><?= number_format($total); ?></td>
                </tr>
                <tr>
                  <th scope="col" class="table-active">請求額</th>
                  <td><?= number_format($total + 500); ?></td>
                  <input type="hidden" name="total_payment" value="<?= $total + 500 ?>">
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-md-8">
            <h5><label class="row">支払方法</label></h5>
            <ul>
              <li class="list-unstyled">
                <?php if ($_POST['payment-way'] == '振込み') { ?>
                  <?= $_POST['payment-way']; ?>
                  <input type="hidden" name="payment_way" value=0>
                <?php } else { ?>
                  <?= $_POST['payment-way']; ?>
                  <input type="hidden" name="payment_way" value=1>
                <?php } ?>
              </li>
            </ul>
            <h5><label class="row">お届け先</label></h5>
            <ul>
              <li class="list-unstyled">
                <?php if ($_POST['delivery'] == 0) { ?>
                  <?= '〒' . '&nbsp' . substr_replace($customers['postal_code'], '-', 3, 0) . '&nbsp' . $customers['address'] . $customers['house_num'] . '&nbsp' . $customers['name_last'] . $customers['name_first']; ?>
                  <input type="hidden" name="postal_code" value="<?= $customers['postal_code'] ?>">
                  <input type="hidden" name="address" value="<?= $customers['address'] ?>">
                  <input type="hidden" name="house_num" value="<?= $customers['house_num'] ?>">
                  <input type="hidden" name="orderer_name" value="<?= $customers['name_last'] . $customers['name_first'] ?>">
                <?php } else { ?>
                  <?= '〒' . '&nbsp' . substr_replace($customers['postal_code'], '-', 3, 0) . '&nbsp' . $customers['address'] . $customers['house_num'] . '&nbsp' . $customers['name']; ?>
                  <input type="hidden" name="postal_code" value="<?= $customers['postal_code'] ?>">
                  <input type="hidden" name="address" value="<?= $customers['address'] ?>">
                  <input type="hidden" name="house_num" value="<?= $customers['house_num'] ?>">
                  <input type="hidden" name="orderer_name" value="<?= $customers['name'] ?>">
                <?php } ?>
              </li>
            </ul>
          </div>
        </div>
        <div class="text-center mb-5">
          <input type="submit" name="fixed_order" class="btn btn-outline-primary btn-lg" value="注文を確定する">
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once '../view_common/footer.php'; ?>