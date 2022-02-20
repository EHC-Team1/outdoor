<?php
// セッションの宣言
session_start();

// ログイン状態であればトップにリダイレクト
// if ($_SESSION['customer']) {
//   header("Location: ./top.php");
// }

$email = $password = "";

// 「ログイン」ボタンが押された場合
if (isset($_POST['login'])) {
  require_once('../Model/CustomerModel.php');
  $pdo = new CustomerModel();

  // CustomerModelのcheckメソッドを呼び出す
  $pdo = $pdo->login();
  $message = $pdo;

  // ボタンが押されていない状態
} else {
  if (isset($_SESSION['login'])) {
    $email = $_SESSION['login']['email'];
    $password = $_SESSION['login']['password'];
  }
  $message = "";
}

// メッセージをサニタイズ
$message = htmlspecialchars($message);

?>
<!-- ------------------------------ 表示画面 --------------------------------- -->
<?php require_once('../view_common/header.php'); ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 style="text-align:center" class="mt-5">会員ログイン</h1>
    <h6 class="text-center mb-5">商品のご購入には、ログインが必要です。</h6>
    <div class="col-md-8">
      <?= $message; ?>
      <form method="post" action="">
        <div style="text-align:center">
          <div class="row">
            <div class="col-md-3"><label for="email">メールアドレス</label></div>
            <div class="col-md-9">
              <input id="email" type="text" name="email" class="form-control" value="<?= $email ?>" autofocus><br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3"><label for="password">パスワード</label></div>
            <div class="col-md-9">
              <input id="password" type="password" name="password" class="form-control" placeholder="半角英数字8文字以上24文字以下" value="<?= $password ?>">
            </div>
          </div>
        </div>
        <div class="d-flex align-items-center justify-content-evenly mt-5 md-5">
          <button type="submit" formaction="public_signup.php" name="signup" class="btn btn-outline-success btn-lg">新規登録</button>
          <button type="submit" name="login" class="btn btn-outline-primary btn-lg">ログイン</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once('../view_common/footer.php'); ?>
