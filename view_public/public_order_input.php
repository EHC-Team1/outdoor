<?php
// セッションを宣言
session_start();

// CustomerModelファイルを読み込み
require_once('../Model/CustomerModel.php');
// Customerクラス呼び出し
$pdo = new CustomerModel();
// showメソッドを呼び出し
$customers = $pdo->show();

// Deliveryクラス呼び出し
require_once('../Model/DeliveryModel.php');
// Deliveryクラスを呼び出し
$pdo = new DeliveryModel();
// indexメソッドを呼び出し
$deliveries = $pdo->index();
$deliveries = $deliveries->fetchAll(PDO::FETCH_ASSOC);

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
              <input type="radio" id="my-address" name="delivery" value=0 checked>
              <label for="my-address">ご自身の住所</label>
              <div class="mb-2">
                <?php $customer = $customers->fetch(PDO::FETCH_ASSOC); ?>
                <?= '〒' . '&nbsp' . substr_replace($customer['postal_code'], '-', 3, 0) . '&nbsp' . $customer['address'] . $customer['house_num'] . '&nbsp' . $customer['name_last'] . $customer['name_first'] ?>
              </div>
            </li>
          <!-- 配送先が登録されていたら表示、されていなかったら未表示 -->
            <?php if ($deliveries) : ?>
              <li class="list-unstyled">
                <input type="radio" id="registration-address" name="delivery" value=1>
                <label for="registration-address">登録先住所から選択</label><br>
                <select class="form-select mt-2 mb-2" name="delivery_id" id="address-select">
                  <?php
                  foreach ($deliveries as $delivery) { ?>
                    <option value="<?= $delivery['id'] ?>">
                      <?= '〒' . '&nbsp' . substr_replace($delivery['postal_code'], '-', 3, 0) . '&nbsp' . $delivery['address'] . $customer['house_num'] . '&nbsp' . $delivery['name'] ?>
                    </option>
                  <?php } ?>
                </select>
              </li>
            <?php endif ?>
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