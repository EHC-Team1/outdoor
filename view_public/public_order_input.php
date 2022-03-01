<?php
// セッションを宣言
session_start();

// OrderModelファイルを読み込み
require_once('../Model/OrderModel.php');
// Orderクラスを呼び出し
$pdo = new OrderModel();

// CustomerModelファイルを読み込み
require_once('../Model/CustomerModel.php');
// Customerクラス呼び出し
$pdo = new CustomerModel();
// showメソッドを呼び出し
$customers = $pdo->show();
$deliveries = $deliveries->fetchAll(PDO::FETCH_ASSOC);

// Deliveryクラス呼び出し
require_once('../Model/DeliveryModel.php');
// Deliveryクラスを呼び出し
$pdo = new DeliveryModel();
// indexメソッドを呼び出し
$deliveries = $pdo->index();

// 確認ボタンが押された場合
if (isset($_POST['input_order'])) {
  // Orderクラスを呼び出し
  require_once('../Model/OrderModel.php');
  $pdo = new OrderModel();
  // inputクラスを呼び出し
  $pdo = $pdo->input();
  // エラーメッセージを$messageに格納
  $message = $pdo;
}
$message = "";

?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center mt-5 mb-5">注文情報入力</h1>
    <div class="col-md-10">
      <form action="public_order_check.php" method="POST">
        <div class="form-group">
          <h4><label class="row">支払方法</label></h4>
          <ul>
            <li class="list-unstyled">
              <label><input type="radio" id="transfer" name="payment-way" value="振込み" checked></label>
              <label for="transfer">振込み</label>
            </li>
            <li class="list-unstyled">
              <label><input type="radio" id="card" name="payment-way" value="クレジットカード"></label>
              <label for="card">クレジットカード</label>
            </li>
          </ul>
        </div>

        <div class="form-group">
          <h4><label class="row">お届け先</label></h4>
          <ul>
            <li class="list-unstyled">
              <input type="radio" id="my-address" name="delivery-target" checked>
              <label for="my-address">ご自身の住所</label>
              <div class="mb-2">
                
                〒<?= $customer['postal_code']; ?> <?= $customer['address']; ?> <?= $customer['name_last']; ?><?= $customer['name_first']; ?>
              </div>
            </li>
            <li class="list-unstyled">
              <input type="radio" id="registration-address" name="delivery-target">
              <label for="registration-address">登録先住所から選択</label><br>
              <select class="form-select mt-2 mb-2" name="address" id="address-select">
                <?php 
                foreach ($deliveries as $delivery) { ?>
                  <option selected>〒<?= $delivery['postal_code'], $delivery['address'], $delivery['name']; ?></option>
                <?php } ?>
              </select>
            </li>
            <li class="list-unstyled">
              <input type="radio" id="new-delivery" name="delivery-target">
              <label for="new-delivery">新しいお届け先</label>
              <table class="table table-borderless">
                <thead>
                  <tr>
                    <th class="col-2"></th>
                    <th class="col-4"></th>
                    <th class="col-4"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><label for="new_postal_code">郵便番号(ハイフンなし)</label></td>
                    <td><input type="text" class="form-control" id="new_postal_code" placeholder="0001111"></td>
                  </tr>
                  <tr>
                    <td><label for="new_address">住所</label></td>
                    <td><input type="text" class="form-control" id="new_address" placeholder="東京都豊島区池袋0-0-0"></td>
                  </tr>
                  <tr>
                    <td><label for="new_name">宛名</label></td>
                    <td><input type="text" class="form-control" id="new_name" placeholder="藤浪翔平"></td>
                  </tr>
                </tbody>
              </table>
            </li>
          </ul>
        </div>
        <div class="d-flex align-items-center justify-content-center">
          <input type="submit" name="input_order" class="btn btn-outline-primary btn-lg" id="order_confirm_btn" value="確認画面へ進む">
        </div>
      </form>
    </div>
  </div>
</div>

<script src="../js/public_order_input.js"></script>
<?php require_once '../view_common/footer.php'; ?>