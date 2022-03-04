<?php
// セッションの宣言
session_start();

require_once '../view_common/header.php'; ?>

<div class="container">
  <!-- 新規登録に成功した場合に表示 -->
  <?php if (isset($_GET['admission'])) { ?>
    <h1 class="text-center my-5">
      Welcome！</br>アカウントが作成されました
    </h1>

    <!-- 再入会処理に成功した場合に表示 -->
  <?php } elseif (isset($_GET['rejoin'])) { ?>
    <div class="text-center my-5">
      <h1>Welcome back！</br>アカウントが再作成されました</h1><br>
      <h5>会員情報は、マイページよりご確認ください</h5>
    </div>

  <?php } ?>
  <div class="d-flex align-items-center justify-content-evenly my-5">
    <button onclick="location.href='top.php'" class="btn btn-outline-info btn-lg">TOP画面へ</button>
  </div>
</div>


<?php require_once('../view_common/footer.php'); ?>