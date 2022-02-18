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

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 style="text-align:center" class="mt-5">アカウント新規作成</h1>
    <h6 class="text-center mb-5">下記の内容でよろしければ、「登録」ボタンを押して下さい。</h6>
    <div class="col-md-8">
      <table style="text-align:center" class="table mt-3">
        <tbody>
          <tr>
            <th>ユーザー名</th>
            <td><?= $_SESSION['signup']['name_last'] ?>&nbsp;<?= $_SESSION['signup']['name_first']; ?></td>
          </tr>
          <tr>
            <th>メールアドレス</th>
            <td><?= $_SESSION['signup']['email'] ?></td>
          </tr>
          <tr>
            <th>郵便番号</th>
            <td>〒 <?= substr_replace($_SESSION['signup']['postal_code'],'-',3,0) ?></td>
          </tr>
          <tr>
            <th>住所</th>
            <td><?= $_SESSION['signup']['address'] ?></td>
          </tr>
          <tr>
            <th>電話番号</th>
            <td><?= $_SESSION['signup']['telephone_num'] ?></td>
          </tr>
          <tr>
            <th>パスワード</th>
            <td><?= $_SESSION['signup']['password'] ?></td>
          </tr>
        </tbody>
      </table>
      <div class="d-flex align-items-center justify-content-evenly mt-5 md-5">
        <button onclick="location.href='public_signup.php'" class="btn btn-outline-secondary btn-lg">戻る</button>
        <form method="post">
          <button type="submit" name="input" class="btn btn-outline-primary btn-lg">登録する</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require_once('../view_common/footer.php'); ?>