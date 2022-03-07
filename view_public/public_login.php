<?php
// セッションの宣言
session_start();

// ログイン状態であればトップにリダイレクト
// if ($_SESSION['customer']) {
//   header("Location: ./top.php");
// }

unset($_SESSION['signup']);
$_SESSION['login']['email'] = $_SESSION['login']['password'] = "";

// 「ログイン」ボタン押されていない状態
if (isset($_SESSION['login'])) {
  // エラーメッセージ無し
  $message = "";
}

// ボタンが押された場合
if (isset($_POST['login'])) {
  require_once('../Model/CustomerModel.php');
  $pdo = new CustomerModel();
  // CustomerModelのloginメソッドを呼び出す
  $pdo = $pdo->login();
  $message = $pdo;
}

// メッセージをサニタイズ
$message = htmlspecialchars($message);

?>

<?php require_once('../view_common/header.php'); ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 style="text-align:center" class="mt-5">会員ログイン</h1>
    <h6 class="text-center mb-5">商品のご購入には、ログインが必要です。</h6>
    <div class="col-sm-8">
      <?php if (!empty($message)) { ?>
        <div class="alert alert-danger" role="alert"><?= $message; ?></div>
      <?php } ?>
      <form method="post">
        <div style="text-align:center">
          <div class="row">
            <strong class="col-md-3"><label for="email">メールアドレス</label></strong>
            <div class="col-md-9">
              <input id="email" type="text" name="email" class="form-control" placeholder="例) abc123@ddd.com" value="<?= $_SESSION['login']['email'] ?>" autofocus><br>
            </div>
          </div>
          <div class="row">
            <strong class="col-md-3"><label for="password">パスワード</label></strong>
            <div class="col-md-9">
              <input id="password" type="password" name="password" class="form-control" placeholder="例) AbC12345678" value="<?= $_SESSION['login']['password'] ?>">
              <p class="mt-2 ms-1">※パスワードは半角英数字をそれぞれ1文字以上含んだ、8文字以上24字以内で入力してください。</p></br>
            </div>
          </div>
        </div>
        <div class="d-flex align-items-center justify-content-evenly my-5">
          <button type="submit" formaction="public_signup.php" name="signup" class="btn btn-outline-success btn-lg">新規登録</button>
          <button type="submit" name="login" class="btn btn-outline-primary btn-lg">ログイン</button>
        </div>
      </form>
    </div>
  </div>
</div>


<?php require_once('../view_common/footer.php'); ?>