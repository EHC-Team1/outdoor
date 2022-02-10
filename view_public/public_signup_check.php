<?php

require_once('../Model/CustomerModel');
$pdo = new CustomerModel;

// inputメソッドを呼び出し
$customer = $pdo->input();

?>

<!-- ------------------------------ 表示画面 --------------------------------- -->

<?php require_once '../view_common/header.php'; ?>

<h1>入力情報確認</h1>
<h4>下記の内容に、問題なければ確定ボタンを押して下さい。</h4>

<form method="post" action="public_signup_complete.php">

  <!-- 名前入力 -->
  <label for="name">Name</label>
  <input id="name" type="text" placeholder="姓" disabled>
  <input id="name" type="text" placeholder="名" disabled><br><br>

  <!-- メールアドレス入力 -->
  <label for="mall">E-mall</label>
  <input id="mall" type="text" disabled><br><br>

  <!-- 郵便番号入力 -->
  <label for="postal">Postal Code</label>
  <input id="postal" type="number" disabled><br><br>

  <!-- 住所入力 -->
  <label for="address">Address</label>
  <input id="address" type="text" disabled><br><br>

  <!-- 電話番号入力 -->
  <label for="tell">Tell</label>
  <input id="tell" type="number" disabled><br><br>

  <!-- パスワード入力 -->
  <label for="password">Password</label>
  <input id="password" type="password" disabled><br><br>

  <!-- キャンセルボタン → ログイン画面へ-->
  <a href="public_signup.php">入力変更</a>

  <!-- 確定ボタン → 登録完了画面へ -->
  <input type="submit" name="btn_submit" value="確定">


</form>
<?php require_once('../view_common/footer.php'); ?>