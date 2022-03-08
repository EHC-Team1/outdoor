<?php
// セッションの宣言
session_start();

// 入力確認画面で「戻る」ボタンが押されて、リダイレクトしてきた場合
if (isset($_SESSION['signup']) || (isset($_GET['back']))) {
  // ボタンが押されてない場合、セッションの値を初期化
} else {
  $_SESSION['signup']['name_last'] = $_SESSION['signup']['name_first'] = $_SESSION['signup']['email'] = $_SESSION['signup']['postal_code'] = $_SESSION['signup']['address'] = $_SESSION['signup']['house_num'] = $_SESSION['signup']['telephone_num'] = $_SESSION['signup']['password'] = "";
}
// エラーメッセージ無し
$message = "";

//  ボタンが押された場合
if (isset($_POST['check'])) {
  require_once('../Model/CustomerModel.php');
  $pdo = new CustomerModel();
  // CustomerModelのcheckメソッドを呼び出す
  $pdo = $pdo->check();
  $message = $pdo;
}
$message = htmlspecialchars($message);
?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
<h1 style="text-align:center" class="mt-5">アカウント新規作成</h1>
    <h6 class="text-center mb-5">全ての項目を入力して頂き、「確認する」ボタンを押してください</h6>
  <div class="row d-flex align-items-center justify-content-center">
    <div class="col-sm-8">
      <form method="post">
        <div class="form-group">
          <?php if ($message) { ?>
            <div class="alert alert-danger text-center" role="alert">
              <?= $message; ?>
            </div>
          <?php } ?>
          <div class="row mb-3">
            <div class="col-sm-6">
              <strong><label class="mb-1">姓</label></strong>
              <input type="text" name="name_last" class="form-control" placeholder="例) 藤浪" value="<?= $_SESSION['signup']['name_last'] ?>" autofocus>
            </div>
            <div class="col-sm-6">
              <strong><label class="mb-1">名</label></strong>
              <input type="text" name="name_first" class="form-control" placeholder="例) 翔平" value="<?= $_SESSION['signup']['name_first'] ?>">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
              <strong><label class="mb-1">メールアドレス</label></strong>
              <input type="email" name="email" class="form-control" placeholder="例) abc123@ddd.com" value="<?= $_SESSION['signup']['email']  ?>">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-sm-6">
              <strong><label class="mb-1">郵便番号</label></strong>
              <input type="number" name="postal_code" id="postal_code" class="form-control" onKeyUp="AjaxZip3.zip2addr(this,'','address','address');" placeholder="例) 1700014" value="<?= $_SESSION['signup']['postal_code'] ?>">
            </div>
            <div class="col mt-auto">
              郵便番号入力後、市区町村が自動的に表示されます。<br>
              ご不明の方は、<a href="https://www.post.japanpost.jp/zipcode/index.html" target="_blank" rel="noopener noreferrer">郵便番号検索</a> をご利用ください。
            </div>
          </div>
          <div class="row mb-3">
            <strong><label class="mb-1">市区町村</label></strong>
            <div class="col">
              <input type="text" name="address" class="form-control" placeholder="例) 東京都豊島区池袋" value="<?= $_SESSION['signup']['address'] ?>">
            </div>
          </div>
          <div class="row mb-3">
            <strong><label class="mb-1">番地・建物名</label></strong>
            <div class="col">
              <input type="text" name="house_num" class="form-control" placeholder="例) 〇丁目△番地 □□マンション 101号室" value="<?= $_SESSION['signup']['house_num'] ?>">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
              <strong><label class="mb-1">電話番号</label></strong>
              <input type="number" name="telephone_num" class="form-control" placeholder="例) 12345678912" value="<?= $_SESSION['signup']['telephone_num'] ?>">
            </div>
          </div>
          <div class="row">
            <div class="col">
              <strong><label class="mb-1">パスワード</label></strong>
              <input type="password" name="password" class="form-control" placeholder="例) AbC12345678" value="<?= $_SESSION['signup']['password'] ?>">
            </div>
          </div>
          <p class="mt-1 ms-3">※パスワードは半角英数字をそれぞれ1文字以上含んだ、8文字以上24字以内で設定してください。</p></br>
        </div>
        <div class="d-flex align-items-center justify-content-evenly my-5">
          <button type="submit" name="back" formaction="./public_login.php" class="btn btn-outline-secondary btn-lg">ログイン画面へ</button>
          <button type="submit" formaction="public_signup.php" name="check" class="btn btn-outline-primary btn-lg">確認する</button>
        </div>
    </div>
    </form>
  </div>
</div>
</div>

<!-- 住所自動入力用jsファイル -->
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
<?php require_once '../view_common/footer.php'; ?>