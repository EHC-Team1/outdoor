<?php
// セッションを宣言
session_start();

require_once('../Model/OrderModel.php');
$pdo = new OrderModel();

?>

<?php require_once '../view_common/header.php'; ?>


<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center mt-5 mb-5">ご注文ありがとうございました</h1>
    <a href="public_order_input.php">情報入力画面へ</a>
  </div>
</div>










<?php require_once '../view_common/footer.php'; ?>