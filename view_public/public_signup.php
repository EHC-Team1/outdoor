<?php
// セッションの宣言
session_start();
$name_last = $name_first = $email = $postal_code = $address = $house_num = $telephone_num = $password = '';

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
    $house_num = $_SESSION['signup']['house_num'];
    $telephone_num = $_SESSION['signup']['telephone_num'];
    $password = $_SESSION['signup']['password'];
  }
  // エラーメッセージ無し
  $message = "";
}
// メッセージをサニタイズ
$message = htmlspecialchars($message);
?>


<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <h1 style="text-align:center" class="my-5">ユーザー登録</h1>
  <div class="row d-flex align-items-center justify-content-center">
    <div class="col-sm-8">
      <form method="post">
        <div class="form-group">
          <?= $message; ?>
          <div class="row">
            <div class="col-md-6">
              <strong><label class="mb-1">姓</label></strong>
              <input type="text" name="name_last" class="form-control" placeholder="例) 藤浪" value="<?= $name_last ?>" autofocus>
            </div>
            <div class="col-md-6">
              <strong><label class="mb-1">名</label></strong>
              <input type="text" name="name_first" class="form-control" placeholder="例) 翔平" value="<?= $name_first ?>">
            </div>
          </div>
          <p class="mt-1 ms-3">※氏名は20字以内で設定してください。</p>
          <div class="row mb-3">
            <div class="col">
              <strong><label class="mb-1">メールアドレス</label></strong>
              <input type="email" name="email" class="form-control" placeholder="例) abc123@ddd.com" value="<?= $email ?>">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <strong><label class="mb-1">郵便番号</label></strong>
              <input type="text" name="postal_code" class="form-control" onKeyUp="AjaxZip3.zip2addr(this,'','address','address');" placeholder="例) 1700014" value="<?= $postal_code ?>">
            </div>
            <div class="col mt-auto">
              郵便番号入力後、市区町村が自動的に表示されます。<br>
              ご不明の方は、<a href="https://www.post.japanpost.jp/zipcode/index.html" target="_blank" rel="noopener noreferrer">郵便番号検索</a> をご利用ください。
            </div>
          </div>
          <div class="row mb-3">
            <strong><label class="mb-1">市区町村</label></strong>
            <div class="col">
              <input type="text" name="address" class="form-control" placeholder="例) 東京都豊島区池袋" value="<?= $address ?>">
            </div>
          </div>
          <div class="row mb-3">
            <strong><label class="mb-1">番地・建物名</label></strong>
            <div class="col">
              <input type="text" name="house_num" class="form-control" placeholder="例) 〇丁目△番地 □□マンション 101号室" value="<?= $house_num ?>">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
              <strong><label class="mb-1">電話番号</label></strong>
              <input type="text" name="telephone_num" class="form-control" placeholder="例) 12345678912" value="<?= $telephone_num ?>">
            </div>
          </div>
          <div class="row">
            <div class="col">
              <strong><label class="mb-1">パスワード</label></strong>
              <input type="password" name="password" class="form-control" placeholder="例) AbC12345678" value="<?= $password ?>">
            </div>
          </div>
          <p class="mt-1 ms-3">※パスワードは半角英数字をそれぞれ1文字以上含んだ、8文字以上24字以内で設定してください。</p></br>
        </div>
        <!-- <div class="form-group">
          <?= $message; ?>
          <input type="text" name="name_last" class="form-control" placeholder="姓" value="<?= $name_last ?>" autofocus>
          <input type="text" name="name_first" class="form-control" placeholder="名" value="<?= $name_first ?>">
          <p>※氏名は20字以内で設定してください。</p>
          <input type="email" name="email" class="form-control" placeholder="メールアドレス" value="<?= $email ?>">
          <input type="text" name="postal_code" class="form-control" onKeyUp="AjaxZip3.zip2addr(this,'','address','address');" placeholder="郵便番号" value="<?= $postal_code ?>"> 郵便番号入力後、住所が自動的に入力されます。
          <input type="text" name="address" class="form-control" placeholder="住所" value="<?= $address ?>">
          <input type="text" name="telephone_num" class="form-control" placeholder="電話番号" value="<?= $telephone_num ?>">
          <input type="password" name="password" class="form-control" placeholder="パスワード" value="<?= $password ?>">
          <p>※パスワードは半角英数字をそれぞれ1文字以上含んだ、8文字以上24字以内で設定してください。</p></br>
        </div> -->
        <div class="d-flex align-items-center justify-content-evenly my-5">
          <button type="submit" name="back" formaction="./public_login.php" class="btn btn-outline-secondary btn-lg">ログイン画面へ戻る</button>
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