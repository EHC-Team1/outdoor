<?php
// セッションを宣言
session_start();

require_once('../Model/AdminModel.php');

// 「サインアップ」ボタンが押された場合
if (isset($_POST['signup'])) {
  // AdminModelクラスを呼び出し
  $pdo = new AdminModel();
  // loginメソッドを呼び出し
  $pdo = $pdo->signup();
  $message = $pdo;
} else {
  $message = "";
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- jQuery読み込み -->
  <script src='https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.5.0.js'></script>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!-- スライド用slick -->
  <link rel="stylesheet" href="../css/slick-theme.css" type="text/css">
  <link rel="stylesheet" href="../css/slick.css" type="text/css">
  <script src="../js/slick.js" type="text/javascript"></script>
  <title>Outdoor</title>
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand mb-0 h1 ms-5" href="../view_admin/admin_signup.php">OUTDOOR</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          </ul>
          <button class="btn btn-outline-secondary ms-5 me-5" onclick="location.href='admin_login.php'">管理者ログイン</button>
          <button class="btn btn-outline-secondary me-5" onclick="location.href='../view_public/public_login.php'">ユーザーログイン</button>
          <button class="btn btn-outline-secondary me-5" onclick="location.href='../view_public/top.php'">ユーザートップ</button>
        </div>
      </div>
    </nav>
  </header>

  <div class="container">
    <h1 class="my-5 text-center">管理者アカウント作成</h1>
    <div class="row d-flex justify-content-center mb-3">
      <?= $message ?>
    </div>
    <form method="post">
      <div class="row d-flex justify-content-center g-3 mb-3">
        <div class="col-sm-4">
          <h4 class="text-center">管理者名</h4>
        </div>
        <div class="col-sm-4">
          <input type="text" name="admin_name" class="form-control" id="admin_name">
        </div>
      </div>
      <div class="row d-flex justify-content-center g-3 mb-5">
        <div class="col-sm-4">
          <h4 class="text-center">パスワード</h4>
        </div>
        <div class="col-sm-4">
          <input type="password" name="password" class="form-control" id="password">
        </div>
      </div>
      <div class="row d-flex justify-content-center mb-3">
        <div class="col-sm-8  d-flex justify-content-evenly">
          <button type="submit" name="signup" class="btn btn-outline-primary btn-lg" id="admin_signup_btn">サインアップ</button>
        </div>
      </div>
    </form>
    <div class="row d-flex justify-content-center mb-5">
      <div class="col-sm-8  d-flex justify-content-end">
        <button class="btn btn-outline-secondary btn-lg" onclick="location.href='admin_login.php'">管理者ログインへ</button>
      </div>
    </div>
  </div>

  <!-- アラート用jsファイル -->
  <script src="../js/admin_signup.js"></script>
  <?php require_once '../view_common/footer.php'; ?>