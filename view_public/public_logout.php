<?php
session_start();

// ログインされていない場合topページにリダイレクト
if (!isset($_SESSION['customer'])) {
  header("Location: ./top.php");
  die();
}

// CustomerModelファイルを呼び出し
require_once('../Model/CustomerModel.php');
// Customerクラスを呼び出し
$pdo = new CustomerModel();
// logoutメソッドを呼び出し
$pdo = $pdo->logout();
?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <h1 style="text-align:center" class="my-5">
    ログアウトしました。
  </h1>
  <div class="d-flex align-items-center justify-content-evenly my-5">
    <button onclick="location.href='top.php'" class="btn btn-outline-info btn-lg">TOP画面へ</button>
  </div>
</div>

<?php require_once '../view_common/footer.php'; ?>