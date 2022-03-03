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

<?php
// 「ログアウト」ボタンが押された時
if (isset($_POST['customer_logout'])) {
  // CustomerModelファイルを呼び出し
  require_once('../Model/CustomerModel.php');
  // Customerクラスを呼び出し
  $pdo = new CustomerModel();
  // logoutメソッドを呼び出し
  $pdo = $pdo->logout();
}
?>

<body>
  <header>
    <!-- ログイン状態か判別 -->
    <?php if (isset($_SESSION['admin'])) { ?>
      <!-- 管理者ログイン状態 -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand mb-0 h1 ms-5" href="../view_admin/admin_item_index.php">OUTDOOR</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            </ul>
            <button class="btn btn-outline-secondary ms-5 me-5" onclick="location.href='../view_admin/admin_login.php'">ログアウト</button>
            <button class="btn btn-outline-secondary me-5" onclick="location.href='../view_public/public_login.php'">ユーザーログインへ</button>
            <button class="btn btn-outline-secondary me-5" onclick="location.href='../view_public/top.php'">ユーザートップへ</button>
          </div>
        </div>
      </nav>
    <?php } elseif (isset($_SESSION['customer'])) { ?>
      <!-- ログイン状態 -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand mb-0 h1 ms-5" href="../view_public/top.php">OUTDOOR</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-lg-0">
            </ul>
            <h5 class="navbar-brand mb-0 ms-5"><?= $_SESSION['customer']['name_last'] ?>さん</h5>
            <button class="btn btn-outline-success ms-5 me-5" onclick="location.href='mypage.php'">マイページ</button>
            <button class="btn btn-outline-secondary me-5" onclick="location.href='public_logout.php'" type="submit" name="customer_logout" value="1">ログアウト</button>
            <button class="btn btn-outline-info me-5" onclick="location.href='cart_item_index.php'">カートを見る</button>
          </div>
        </div>
      </nav>
    <?php } else { ?>
      <!-- ゲスト状態 -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand mb-0 h1 ms-5" href="../view_public/top.php">OUTDOOR</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            </ul>
            <button class="btn btn-outline-primary ms-5 me-5" onclick="location.href='public_login.php'">ログイン</button>
            <button class="btn btn-outline-info me-5" onclick="location.href='public_signup.php'">カートを見る</button>
          </div>
        </div>
      </nav>
    <?php } ?>
  </header>
  <main>