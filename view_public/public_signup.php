<?php
session_start();

// セッションの中身を初期化
$_SESSION['customer']['name_last'] = $_SESSION['customer']['name_first'] = $_SESSION['customer']['email']
  = $_SESSION['customer']['postal_code'] = $_SESSION['customer']['address'] = $_SESSION['customer']['telephone_num']
  = $_SESSION['customer']['password'] = '';

// 確認ボタンが押された場合
if (isset($_POST['check'])) {
  require_once('../Model/CustomerModel.php');
  $pdo = new CustomerModel();

  // CustomerModelのcheckメソッドを呼び出す
  $pdo = $pdo->check();
  $message = $pdo;

  // エラーメッセージなければ、表示なし
} else {
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


<!-- 出来たら、エラーメッセージは一括で出したいなぁ -->
<!-- <?php
      if (!empty($message)) : ?>
  <?php foreach ($message as $value) : ?>
    <li>・<?php echo $value; ?></li>
  <?php endforeach; ?>
<?php endif; ?> -->



<form method="post">


  <!-- 名前入力 -->
  <label for="name">Name</label>
  <input id="name" type="text" name="name_last" placeholder="姓" value="<?= $_SESSION['customer']['name_last'] ?>">
  <input id="name" type="text" name="name_first" placeholder="名" value="<?= $_SESSION['customer']['name_first'] ?>"><br><br>
  <?= $_SESSION['customer']['name_last']; ?>

  <!-- メールアドレス入力 -->
  <label for="email">E-mail</label>
  <input id="email" type="text" name="email" value="<?= $_SESSION['customer']['email'] ?>"><br><br>

  <!-- 郵便番号入力 -->
  <label for="postal_code">Postal Code</label>
  <input id="postal_code" type="text" name="postal_code" value="<?= $_SESSION['customer']['postal_code'] ?>"><br><br>

  <!-- 住所入力 -->
  <label for="address">Address</label>
  <input id="address" type="text" name="address" value="<?= $_SESSION['customer']['address'] ?>"><br><br>

  <!-- 電話番号入力 -->
  <label for="telephone_num">Tell</label>
  <input id="telephone_num" type="text" name="telephone_num" value="<?= $_SESSION['customer']['telephone_num'] ?>"><br><br>

  <!-- パスワード入力 -->
  <label for="password">Password</label>
  <input id="password" type="password" name="password" value="<?= $_SESSION['customer']['password'] ?>"><br><br>



  <!-- キャンセルボタン → ログイン画面へ-->
  <a href="public_login.php">キャンセル</a>

  <!-- 入力チェックへ-->
  <input type="submit" name="check" value="確認">


</form>

<?php require_once('../view_common/footer.php'); ?>