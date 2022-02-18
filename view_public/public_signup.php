<?php
// セッションの宣言
session_start();
$name_last = $name_first = $email = $postal_code = $address = $telephone_num = $password = '';

// 「確認」ボタンが押された場合
if (isset($_POST['check'])) {
  require_once('../Model/CustomerModel.php');
  $pdo = new CustomerModel();
  // CustomerModelのcheckメソッドを呼び出す
  $pdo = $pdo->check();
  $message = $pdo;

  // ボタンが押されていない状態
} else {
  // セッションに値が入ってれば変数に格納
  if (isset($_SESSION['signup'])) {
    $name_last = $_SESSION['signup']['name_last'];
    $name_first = $_SESSION['signup']['name_first'];
    $email = $_SESSION['signup']['email'];
    $postal_code = $_SESSION['signup']['postal_code'];
    $address = $_SESSION['signup']['address'];
    $telephone_num = $_SESSION['signup']['telephone_num'];
    $password = $_SESSION['signup']['password'];
  }
  // エラーメッセージ無し
  $message = "";
}
// メッセージをサニタイズ
$message = htmlspecialchars($message);
?>
<!-- ------------------------------ 表示画面 --------------------------------- -->
<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <h1 style="text-align:center" class="mt-5 mb-5">ユーザー登録</h1>
  <div class="row d-flex align-items-center justify-content-center">
  <div class="col-md-8">
    <form method="post">
      <div class="form-group">
        <?= $message; ?>
        <input type="text" name="name_last" class="form-control" placeholder="姓" value="<?= $name_last ?>">
        <input type="text" name="name_first" class="form-control" placeholder="名" value="<?= $name_first ?>">
        <p>※氏名は20字以内で設定してください。</p>
        <input type="email" name="email" class="form-control" placeholder="メールアドレス" value="<?= $email ?>">
        <input type="text" name="postal_code" class="form-control" placeholder="郵便番号" value="<?= $postal_code ?>">
        <input type="text" name="address" class="form-control" placeholder="住所" value="<?= $address ?>">
        <input type="text" name="telephone_num" class="form-control" placeholder="電話番号" value="<?= $telephone_num ?>">
        <input type="password" name="password" class="form-control" placeholder="パスワード" value="<?= $password ?>">
        <p>※パスワードは半角英数字をそれぞれ1文字以上含んだ、8文字以上24字以内で設定してください。</p></br>
      </div>
      <div class="d-flex align-items-center justify-content-evenly mt-5 md-5">
          <button type="submit" name="back" formaction="./public_login.php" class="btn btn-outline-secondary btn-lg">ログイン画面へ戻る</button>
          <button type="submit" formaction="public_signup.php" name="check" class="btn btn-outline-primary btn-lg">確認する</button>
        </div>
      </div>
    </form>
  </div>
  </div>
</div>

<?php require_once '../view_common/footer.php'; ?>