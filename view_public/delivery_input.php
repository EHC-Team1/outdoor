<?php
// セッションを宣言
session_start();

// 「新規登録」ボタンが押された場合
if (isset($_POST['delivery_input'])) {
  // DeliveryModelファイルを読み込み
  require_once('../Model/DeliveryModel.php');
  // Deliveryクラスを呼び出す
  $pdo = new DeliveryModel();
  // inputメソッドを呼び出す
  $delivery = $pdo->input();
  // エラーメッセージを$messageに格納
  $message = $delivery;
}
$message = "";
$message = htmlspecialchars($message);

?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center mt-5 mb-5">配送先新規登録</h1>
    <!-- 戻るボタンは仮置き -->
    <button onclick="history.back();" class="btn btn-outline-secondary">戻る</button>
    <div class="col-md-10">
      <?= $message; ?>
      <form method="POST">
        <input type="hidden" name="customer_id" value="1">
        <table class="table table-borderless">
          <tbody>
            <tr>
              <th scope="row" class="col-md-4 text-right">宛名</th>
              <td class="col-md-8">
                <input type="text" name="name" id="delivery_input" placeholder="藤浪翔平">
              </td>
            </tr>
            <tr>
              <th scope="row" class="col-md-4 text-right">郵便番号</th>
              <td class="col-md-8">
                <input type="text" name="postal_code" id="delivery_input" placeholder="000-1111">
              </td>
            </tr>
            <tr>
              <th scope="row" class="col-md-4 text-right">住所</th>
              <td class="col-md-8">
                <input type="text" name="address" id="delivery_input" class="col-md-8 p-0" placeholder="東京都豊島区池袋0-0-0">
              </td>
            </tr>
          </tbody>
        </table>
        <div class="d-flex align-items-center justify-content-center">
          <button type="submit" name="delivery_input" class="btn btn-outline-primary btn-lg" id="delivery_input_btn">新規登録</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- バリデーション用jsファイル -->
<script src="../js/delivery_input.js"></script>
<?php require_once '../view_common/footer.php'; ?>