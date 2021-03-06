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

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 style="text-align:center" class="mt-5">アカウント新規作成</h1>
    <h6 class="text-center mb-5">下記の内容でよろしければ、「登録する」ボタンを押して下さい。</h6>
    <div class="col-sm-8">
      <div style="text-align:center">
        <div class="row pt-4 border-bottom">
          <div class="col-sm-6 h6">ユーザー名</div>
          <div class="col-sm-6"><?= $_SESSION['signup']['name_last'] ?>&nbsp;<?= $_SESSION['signup']['name_first']; ?></div>
        </div>
        <div class="row pt-4 border-bottom">
          <div class="col-sm-6 h6">メールアドレス</div>
          <div class="col-sm-6"><?= $_SESSION['signup']['email'] ?></div>
        </div>
        <div class="row pt-4 border-bottom">
          <div class="col-sm-6 h6">郵便番号</div>
          <div class="col-sm-6">〒<?= substr_replace($_SESSION['signup']['postal_code'], '-', 3, 0) ?></div>
        </div>
        <div class="row pt-4 border-bottom">
          <div class="col-sm-6 h6">市区町村</div>
          <div class="col-sm-6"><?= $_SESSION['signup']['address'] ?></div>
        </div>
        <div class="row pt-4 border-bottom">
          <div class="col-sm-6 h6">番地・建物名</div>
          <div class="col-sm-6"><?= $_SESSION['signup']['house_num'] ?></div>
        </div>
        <div class="row pt-4 border-bottom">
          <div class="col-sm-6 h6">電話番号</div>
          <div class="col-sm-6"><?= $_SESSION['signup']['telephone_num'] ?></div>
        </div>
        <div class="row pt-4 border-bottom">
          <div class="col-sm-6 h6">パスワード</div>
          <div class="col-sm-6"><?= $_SESSION['signup']['password'] ?></div>
        </div>
      </div>
      <div class="d-flex align-items-center justify-content-evenly my-5">
        <button onclick="location.href='public_signup.php?back'" class="btn btn-outline-secondary btn-lg">戻る</button>
        <form method="post">
          <button type="submit" name="input" class="btn btn-outline-primary btn-lg">登録する</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require_once('../view_common/footer.php'); ?>