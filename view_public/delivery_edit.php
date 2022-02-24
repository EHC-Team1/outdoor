<?php
// セッションを宣言
session_start();

// DeliveryModelファイルを呼び出し
require_once('../Model/DeliveryModel.php');
// Deliveryクラスを呼び出し
$pdo = new DeliveryModel();
// editメソッドを呼び出し
$delivery = $pdo->edit();
$delivery = $delivery->fetch(PDO::FETCH_ASSOC);

// 「更新」ボタンが押された場合
if (isset($_POST['update_delivery'])) {
  // Deliveryクラスを呼び出し
  $pdo = new DeliveryModel();
  // updateメソッドを呼び出し
  $delivery = $pdo->update($delivery);
  header('Location: mypage.php');
}
?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center mt-5 mb-5">配送先編集</h1>
    <div class="col-md-10">
      <form method="post">
        <input type="hidden" name="id" value="<?= $delivery['id'] ?>">
        <table class="table table-borderless">
          <tbody>
            <tr>
              <th scope="row" class="col-md-4 text-right">宛名</th>
              <td>
                <input type="text" name="name" class="form-control" id="delivery_name" value="<?= $delivery['name'] ?>">
              </td>
            </tr>
            <tr>
              <th scope="row" class="col-md-4 text-right">郵便番号</th>
              <td>
                <input type="text" name="postal_code" class="form-control" id="delivery_postal_code" value="<?= $delivery['postal_code'] ?>">
              </td>
            </tr>
            <tr>
              <th scope="row" class="col-md-4 text-right">住所</th>
              <td>
                <input type="text" name="address" class="form-control" id="delivery_address" value="<?= $delivery['address'] ?>">
              </td>
            </tr>
          </tbody>
        </table>
        <div class="d-flex align-items-center justify-content-center">
          <button type="submit" name="update_delivery" class="btn btn-outline-success btn-lg" id="delivery_edit_btn">更新</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="../js/delivery_edit.js"></script>
<?php require_once '../view_common/footer.php'; ?>