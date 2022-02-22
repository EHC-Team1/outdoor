<?php
// セッションを宣言
session_start();

require_once('../Model/AdminModel.php');

// ログアウト処理
if (isset($_POST['logout'])) {
  // Adminクラスを呼び出し
  $pdo = new AdminModel();
  // logoutメソッドを呼び出し
  $pdo = $pdo->logout();
}

// 「ログイン」ボタンが押された場合
if (isset($_POST['signup'])) {
  // AdminModelクラスを呼び出し
  $pdo = new AdminModel();
  // loginメソッドを呼び出し
  $pdo = $pdo->signup();
  $message = $pdo;
}

?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <h1 class="my-5 text-center">管理者アカウント作成</h1>
  <form method="post">
    <div class="row d-flex justify-content-center g-3 mb-3">
      <div class="col-sm-4">
        <h4 class="text-center">管理者名</h4>
      </div>
      <div class="col-sm-4">
        <input type="text" name="admin_name" class="form-control">
      </div>
    </div>
    <div class="row d-flex justify-content-center g-3 mb-5">
      <div class="col-sm-4">
        <h4 class="text-center">パスワード</h4>
      </div>
      <div class="col-sm-4">
        <input type="password" name="password" class="form-control">
      </div>
    </div>
    <div class="row d-flex justify-content-center mb-5">
      <div class="col-sm-8  d-flex justify-content-evenly">
        <button type="submit" name="signup" class="btn btn-outline-primary btn-lg">サインアップ</button>
      </div>
    </div>
  </form>
  <div class="row d-flex justify-content-center mb-5">
    <div class="col-sm-8  d-flex justify-content-end">
      <button class="btn btn-outline-secondary ms-5 me-5" onclick="location.href='public_login.php'">ログイン</button>
    </div>
  </div>
</div>

<?php require_once '../view_common/footer.php'; ?>