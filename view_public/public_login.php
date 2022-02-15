<?php
// セッションの宣言
session_start();

// セッションの中身を初期化
$_SESSION['customer']['email'] = $_SESSION['customer']['password'] = '';

// 「ログイン」ボタンが押された場合
if (isset($_POST['login'])) {
  require_once('../Model/CustomerModel.php');
  $pdo = new CustomerModel();

  // CustomerModelのcheckメソッドを呼び出す
  $pdo = $pdo->login();
  $message = $pdo;

  // エラーメッセージなければ、表示なし
} else {
  $message = "";
}

// メッセージをサニタイズ
$message = htmlspecialchars($message);

?>


<!-- ------------------------------ 表示画面 --------------------------------- -->

<?php require_once('../view_common/header.php'); ?>

<h1>会員ログイン</h1>
<h4>商品のご購入の際は、ログインが必要です。</h4>

<?= $message; ?>

<form method="post" action="">

  <!-- メールアドレス入力 -->
  <label for="email">E-mail</label>
  <input id="email" type="text" name="email" value="<?= $_SESSION['customer']['email'] ?>"><br><br>

  <!-- パスワード入力 -->
  <label for="password">Password</label>
  <input id="password" type="password" name="password" placeholder="半角英数字8文字以上24文字以下" value=""><br><br>

  <!-- サインアップ画面へ -->
  <button type="submit" formaction="public_signup.php" name="signup" class="btn btn-outline-success btn-lg">新規登録</button>

  <!-- ログインボタン -->
  <button type="submit" name="login" class="btn btn-outline-success btn-lg">ログイン</button>

</form>

<?php require_once('../view_common/footer.php'); ?>