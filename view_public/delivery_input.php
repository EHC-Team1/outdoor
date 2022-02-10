<?php
// セッションを宣言
session_start();

// if (isset($_POST['input_delivery'])) {
//   // 入力情報をデータベースに登録
//   var_dump($_POST);
//   $delivery = $db->prepare("INSERT INTO deliveries SET name=?, postal_code=?, address=?, created=NOW();");
//   $deliveries->execute(array(
//       $_POST['name'],
//       $_POST['postal_code'],
//       $_POST['address'],
//   ));
//   header('Location: mypage.php');
// }

// 「新規登録」ボタンが押された場合
if (isset($_POST['input_delivery'])) {
  // DeliveryModelファイルを読み込み
  require_once('../Model/DeliveryModel.php');
  // Deliveryクラスを呼び出す
  $pdo = new DeliveryModel();
  // inputメソッドを呼び出す
  $delivery = $pdo->input();
  // エラーメッセージを$messageに格納
  $message = $delivery;
}
$message = htmlspecialchars($message);

?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center mt-5 mb-5">配送先新規登録</h1>
    <div class="col-md-10">
    <?= $message; ?>
      <form method="POST">
      <input type="hidden" name="customer_id" value="1">
        <table class="table table-borderless">
          <tbody>
            <tr>
              <th scope="row" class="col-md-4 text-right">宛名</th>
              <td class="col-md-8">
                <input type="text_field" name="name" placeholder="藤浪翔平">
              </td>
            </tr>
            <tr>
              <th scope="row" class="col-md-4 text-right">郵便番号</th>
              <td class="col-md-8">
                <input type="text_field" name="postal_code" placeholder="000-1111">
              </td>
            </tr>
            <tr>
              <th scope="row" class="col-md-4 text-right">住所</th>
              <td class="col-md-8">
                <input type="text_field" name="address" class="col-md-8 p-0" placeholder="東京都豊島区池袋0-0-0">
              </td>
            </tr>
          </tbody>
        </table>
        <div class="d-flex align-items-center justify-content-center">
          <button type="submit" name="input_delivery" class="btn btn-outline-primary btn-lg">新規登録</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once '../view_common/footer.php'; ?>