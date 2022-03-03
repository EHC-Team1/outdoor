<?php
// セッションの宣言
session_start();

require_once '../view_common/header.php'; ?>

<div class="container">
  <h1 class="text-center my-5">
    Welcome！</br>アカウントが作成されました
  </h1>
  <div class="d-flex align-items-center justify-content-evenly my-5">
    <button onclick="location.href='top.php'" class="btn btn-outline-info btn-lg">TOP画面へ</button>
  </div>
</div>

<?php require_once('../view_common/footer.php'); ?>