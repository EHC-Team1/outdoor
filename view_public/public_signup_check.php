<?php
// セッションの宣言
session_start();

// 「登録」ボタンが押された場合
if (isset($_POST['input'])) {
  require_once('../Model/CustomerModel.php');
  $pdo = new CustomerModel();

  // CustomerModelのinputメソッドを呼び出して登録処理 → 登録完了画面へ
  $customer = $pdo->input();
}
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
  <label for="telephone_num">Tell</label>
  <input id="telephone_num" type="text" name="telephone_num" value="<?= $_SESSION['customer']['telephone_num'] ?>" disabled><br><br>

  <!-- パスワード入力確認 -->
  <label for="password">Password</label>
  <input id="password" type="password" name="password" value="<?= $_SESSION['customer']['password'] ?>" disabled><br><br>


  <!-- 入力画面へ戻る-->
  <button formaction="./public_signup.php" type="submit" name="edit" class="">再編集</button>

  <!-- DBへ登録処理　-->
  <button type="submit" name="input" class="btn btn-outline-success btn-lg">登録</button>


</form>
<?php require_once('../view_common/footer.php'); ?>