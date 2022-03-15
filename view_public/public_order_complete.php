<?php
// セッションを宣言
session_start();

?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center my-5">ご注文ありがとうございました</h1>
    <div class="col-sm-10 d-flex justify-content-center">
      <button type="submit" class="btn btn-outline-info btn-lg" onclick="location.href='top.php'">トップへ</button>
    </div>
  </div>
</div>

<?php require_once '../view_common/footer.php'; ?>