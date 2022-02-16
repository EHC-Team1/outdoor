<?php
// セッションの宣言
session_start();


  // public_signup.phpで「再編集」ボタンが押された場合
if (isset($_POST['edit'])) {
  // エラーメッセージ無し
  $message = "";

  // 「確認」ボタンが押された場合
} elseif (isset($_POST['check'])) {
  require_once('../Model/CustomerModel.php');
  $pdo = new CustomerModel();

  // CustomerModelのcheckメソッドを呼び出す
  $pdo = $pdo->check();
  $message = $pdo;

  // エラーメッセージなければ、表示なし
} elseif (empty($message)) {
  $message = "";

  // ボタンが押されていない場合(初期画面)
} else {
  // セッションの中身を初期化
  $_SESSION['customer']['name_last'] = $_SESSION['customer']['name_first'] = $_SESSION['customer']['email']
    = $_SESSION['customer']['postal_code'] = $_SESSION['customer']['address'] = $_SESSION['customer']['telephone_num']
    = $_SESSION['customer']['password'] = '';
  // エラーメッセージ無し
  $message = "";
}

// メッセージをサニタイズ
$message = htmlspecialchars($message);

?>


<!-- ------------------------------ 表示画面 --------------------------------- -->

<?php require_once '../view_common/header.php'; ?>

<h1>新規会員登録</h1>
<h4>下記項目を入力して、確認ボタンを押して下さい。</h4>

<?= $message; ?>

<form method="post">


  <!-- 名前入力 -->
  <label for="name">Name</label>
  <input id="name" type="text" name="name_last" placeholder="姓" value="<?= $_SESSION['customer']['name_last'] ?>">
  <input id="name" type="text" name="name_first" placeholder="名" value="<?= $_SESSION['customer']['name_first'] ?>"><br><br>

  <!-- メールアドレス入力 -->
  <label for="email">E-mail</label>
  <input id="email" type="text" name="email" value="<?= $_SESSION['customer']['email'] ?>"><br><br>

  <!-- 郵便番号入力 -->
  <label for="postal_code">Postal Code</label>
  <input id="postal_code" type="text" name="postal_code" placeholder="ハイフン無し" value="<?= $_SESSION['customer']['postal_code'] ?>"><br><br>

  <!-- 住所入力 -->
  <label for="address">Address</label>
  <input id="address" type="text" name="address" value="<?= $_SESSION['customer']['address'] ?>"><br><br>

  <!-- 電話番号入力 -->
  <label for="telephone_num">Tell</label>
  <input id="telephone_num" type="text" name="telephone_num" placeholder="ハイフン無し" value="<?= $_SESSION['customer']['telephone_num'] ?>"><br><br>

  <!-- パスワード入力 -->
  <label for="password">Password</label>
  <input id="password" type="password" name="password" placeholder="半角英数字8文字以上24文字以下" value="<?= $_SESSION['customer']['password'] ?>"><br><br>

  <!-- パスワード(確認)入力 時間あれば-->
  <!-- <label for="password2">Password(確認用)</label>
  <input id="password2" type="password" name="password2" placeholder="半角英数字8文字以上24文字以下" value="<?= $_SESSION['customer']['password2'] ?>"><br><br> -->


  <!-- キャンセルボタン → ログイン画面へ-->
  <a href="public_login.php">キャンセル</a>

  <!-- 入力チェックへ-->
  <button type="submit" name="check" class="btn btn-outline-success btn-lg">確認</button>


</form>

<?php require_once('../view_common/footer.php'); ?>