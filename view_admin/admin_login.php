<?php
// セッションを宣言
session_start();

$name = $password = "";

require_once('../Model/AdminModel.php');

// // ログアウト処理
// if (isset($_POST['logout'])) {
//   // Adminクラスを呼び出し
//   $pdo = new AdminModel();
//   // logoutメソッドを呼び出し
//   $pdo = $pdo->logout();
// }

// 「ログイン」ボタンが押された場合
if (isset($_POST['login'])) {
  // AdminModelクラスを呼び出し
  $pdo = new AdminModel();
  // loginメソッドを呼び出し
  $pdo = $pdo->login();
  $message = $pdo;

  // ボタンが押されていない状態
} else {
  if (isset($_SESSION['admin_login'])) {
    $name = $_SESSION['admin_login']['name'];
    $password = $_SESSION['admin_login']['password'];
  }
  $message = "";
}

$message = htmlspecialchars($message);
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
        <a class="navbar-brand mb-0 h1 ms-5" href="../view_admin/admin_login.php">OUTDOOR</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          </ul>
          <button class="btn btn-outline-secondary ms-5 me-5" onclick="location.href='../view_public/public_login.php'">ユーザーログインへ</button>
          <button class="btn btn-outline-secondary me-5" onclick="location.href='../view_public/top.php'">ユーザートップへ</button>
        </div>
      </div>
    </nav>
  </header>

  <div class="container">
    <h1 class="my-5 text-center">管理者ログイン</h1>
    <div class="row d-flex justify-content-center mb-3">
      <div class="col-sm-8 text-center">
        <?= $message; ?>
      </div>
    </div>
    <form method="post">
      <div class="row d-flex justify-content-center g-3 mb-3">
        <div class="col-sm-4">
          <h4 class="text-center">管理者名</h4>
        </div>
        <div class="col-sm-4">
          <input type="text" name="admin_name" class="form-control" value="<?= $name ?>">
        </div>
      </div>
      <div class="row d-flex justify-content-center g-3 mb-5">
        <div class="col-sm-4">
          <h4 class="text-center">パスワード</h4>
        </div>
        <div class="col-sm-4">
          <input type="password" name="password" class="form-control" value="<?= $password ?>">
        </div>
      </div>
      <div class="row d-flex justify-content-center mb-5">
        <div class="col-sm-8  d-flex justify-content-evenly">
          <button type="submit" name="login" class="btn btn-outline-primary btn-lg">ログイン</button>
        </div>
      </div>
    </form>
  </div>

  <?php require_once '../view_common/footer.php'; ?>