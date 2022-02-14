<?php
session_start();

// 「登録」ボタンが押された場合
if (isset($_POST['input'])) {
  require_once('../Model/CustomerModel.php');
  $pdo = new CustomerModel();

  // CustomerModelのinputメソッドを呼び出す
  $pdo = $pdo->input();
  $message = $customer;


  // エラーメッセージなければ、表示なし
} else {
  $message = "";
}

// メッセージをサニタイズ
$message = htmlspecialchars($message);

?>

<!-- ------------------------------ 表示画面 --------------------------------- -->

<?php require_once '../view_common/header.php'; ?>

<h1>入力情報確認</h1>
<h4>下記の内容に、問題なければ確定ボタンを押して下さい。</h4>

<form method="post">

  <!-- 名前入力確認 -->
  <label for="name">Name</label>
  <input id="name" type="text" name="name_last" value="<?= $_SESSION['customer']['name_last']; ?>" disabled>
  <input id="name" type="text" name="name_first" value="<?= $_SESSION['customer']['name_first']; ?>" disabled><br><br>

  <!-- メールアドレス入力確認 -->
  <label for="email">E-mail</label>
  <input id="email" type="text" name="email" value="<?= $_SESSION['customer']['email'] ?>" disabled><br><br>


  <!-- 郵便番号入力確認 -->
  <label for="postal_code">Postal Code</label>
  <input id="postal_code" type="text" name="postal_code" value="<?= $_SESSION['customer']['postal_code'] ?>" disabled><br><br>


  <!-- 住所入力確認 -->
  <label for="address">Address</label>
  <input id="address" type="text" name="address" value="<?= $_SESSION['customer']['address'] ?>" disabled><br><br>

  <!-- 電話番号入力確認 -->
  <label for="telephone_num">Password</label>
  <input id="telephone_num" type="text" name="telephone_num" value="<?= $_SESSION['customer']['telephone_num'] ?>" disabled><br><br>

  <!-- パスワード入力確認 -->
  <label for="password">Password</label>
  <input id="password" type="password" name="password" value="<?= $_SESSION['customer']['password'] ?>" disabled><br><br>


  <!-- キャンセルボタン → 入力画面へ-->
  <a href="public_signup.php">入力変更</a>

  <!-- DBへ登録 → 画面へ　-->
  <input type="submit" name="input" value="登録">


</form>
<?php require_once('../view_common/footer.php'); ?>