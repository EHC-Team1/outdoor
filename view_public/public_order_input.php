<?php
// セッションを宣言
session_start();

require_once('../Model/OrderModel.php');
$pdo = new OrderModel();

// Customerクラス呼び出し
require_once('../Model/CustomerModel.php');
$pdo = new CustomerModel();

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
          <label>支払方法</label>
          <ul>
            <li>
              <label><input type="radio" id="transfer" name="payment-way" value="振込み"></label>
              <label for="transfer">振込み</label>
            </li>
            <li>
              <label><input type="radio" id="card" name="payment-way" value="クレジットカード"></label>
              <label for="card">クレジットカード</label>
            </li>
          </ul>
          <label>お届け先</label>
          <ul>
            <li>
              <input type="radio" id="my-address" name="delivery-target">
              <label for="my-address">ご自身の住所</label><br>
              <!-- ログインユーザーの住所を取得 -->
              <?php ?>
            </li>
            <li>
              <input type="radio" id="registration-address" name="delivery-target">
              <label for="registration-address">登録先住所から選択</label><br>
              <select name="address" id="address-select">
                <option selected>
                  <!-- ユーザーが登録している住所を取得 -->
                  <?php  ?>
                </option>
              </select>
            </li>
            <li>
              <input type="radio" id="new-address" name="delivery-target">
              <label for="new-address">新しいお届け先</label><br>
              <label for="">郵便番号(ハイフンなし)</label>
              <input type="text" placeholder="0001111"><br>
              <label for="">住所</label>
              <input type="text" placeholder="東京都豊島区池袋0-0-0"><br>
              <label for="">宛名</label>
              <input type="text" placeholder="藤浪翔平"><br>
            </li>
          </ul>
          <input type="submit" name="input_order" class="btn btn-outline-primary btn-lg" value="確認画面へ">
        </div>
      </form>
    </div>
  </div>
</div>








<?php require_once '../view_common/footer.php'; ?>