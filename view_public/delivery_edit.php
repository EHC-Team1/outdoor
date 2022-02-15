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
  $delivery = $pdo->update();
}

?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <form method="post">
    <input type="hidden" name="id" value="<?php echo ($delivery['id']); ?>">
    <div class="row d-flex align-items-center justify-content-center mt-5">
      <div class="col-md-5">
        <h1 class="text-center">配送先編集</h1>
      </div>
      <div class=" col-md-4">
        <input type="text" name="name" class="form-control" value="<?php echo ($delivery['name']); ?>" id="delivery_edit_input">
        <input type="text" name="postal_code" class="form-control" value="<?php echo ($delivery['postal_code']); ?>" id="delivery_edit_input">
        <input type="text" name="address" class="form-control" value="<?php echo ($delivery['address']); ?>" id="delivery_edit_input">
      </div>
      <div class="col-md-2">
        <button type="submit" name="update_delivery" class="btn btn-outline-success btn-lg" id="delivery_edit_btn">更新</button>
      </div>
    </div>
  </form>
</div>

<!-- バリデーション用jsファイル -->
<script src="../js/delivery_edit.js"></script>
<?php require_once '../view_common/footer.php'; ?>