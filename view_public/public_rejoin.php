<?php
// セッションの宣言
session_start();

// ログイン画面から遷移してきた場合、メースアドレス以外のloginセッションの値をクリア
$_SESSION['login']['name_last'] = $_SESSION['login']['name_first'] = $_SESSION['login']['password'] = "";

// サインアップ画面から遷移してきた場合
if (isset($_SESSION['signup'])) {
  // メースアドレス以外のセッションの値をクリア
  $_SESSION['login']['email'] = $_SESSION['signup']['email'];
}
// エラーメッセージ無し
$message = "";

// ボタンが押された場合
if (isset($_POST['rejoin'])) {
  require_once('../Model/CustomerModel.php');
  $pdo = new CustomerModel();
  // CustomerModelのloginメソッドを呼び出す
  $pdo = $pdo->rejoin();
  $message = $pdo;
}

$message = htmlspecialchars($message);

?>

<?php require_once('../view_common/header.php'); ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 style="text-align:center" class="mt-5">再登録ログイン</h1>
    <h6 class="text-center mb-5">
      会員履歴がございます。<br>
      <div class="mt-1">
        以前ご登録頂いた情報を入力してください。
      </div>
    </h6>
    <div class="col-sm-8">
      <?php if ($message) { ?>
        <div class="alert alert-danger text-center" role="alert"><?= $message; ?></div>
      <?php } ?>
      <form method="post" action="">
        <div style="text-align:center">
          <div class="row">
            <strong class="col-sm-3"><label>姓</label></strong>
            <div class="col-md-9">
              <input type="text" name="name_last" class="form-control" placeholder="例) 藤浪" value="<?= $_SESSION['login']['name_last'] ?>" autofocus><br>
            </div>
            <strong class="col-sm-3"><label>名</label></strong>
            <div class="col-sm-9">
              <input type="text" name="name_first" class="form-control" placeholder="例) 翔平" value="<?= $_SESSION['login']['name_first'] ?>"><br>
            </div>
          </div>
          <div class="row">
            <strong class="col-sm-3"><label for="email">メールアドレス</label></strong>
            <div class="col-sm-9">
              <input id="email" type="email" name="email" class="form-control" placeholder="例) abc123@ddd.com" value="<?= $_SESSION['login']['email'] ?>"><br>
            </div>
          </div>
          <div class="row">
            <strong class="col-sm-3"><label for="password">パスワード</label></strong>
            <div class="col-sm-9">
              <input id="password" type="password" name="password" class="form-control" placeholder="例) AbC12345678" value="<?= $_SESSION['login']['password'] ?>">
              <p class="mt-2 ms-1">※パスワードは半角英数字をそれぞれ1文字以上含んだ、8文字以上24字以内で入力してください。</p></br>
            </div>
          </div>
        </div>
        <div class="d-flex align-items-center flex-row-reverse justify-content-evenly my-5">
          <button type="submit" name="rejoin" class="btn btn-outline-primary btn-lg">再登録</button>
          <button type="submit" formaction="public_signup.php" name="signup" class="btn btn-outline-success btn-lg">別のメールアドレスで新規登録する</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once('../view_common/footer.php'); ?>