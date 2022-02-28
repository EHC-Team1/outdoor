<?php
// セッションの宣言
session_start();
$name_last = $name_first = $email = $postal_code = $address = $telephone_num = $password = '';
// $house_number = '';

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
    // $house_number = $_SESSION['signup']['house_number'];
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
<!-- 住所自動入力用jsファイル -->
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
<div class="container">
  <h1 style="text-align:center" class="mt-5 mb-5">ユーザー登録</h1>
  <div class="row d-flex align-items-center justify-content-center">
    <div class="col-md-8">
      <form method="post">
        <div class="form-group">
          <?= $message; ?>
          <div class="row">
            <div class="col-md-6">
              <label class="mb-1">姓</label>
              <input type="text" name="name_last" class="form-control" placeholder="例) 田中" value="<?= $name_last ?>" autofocus>
            </div>
            <div class="col-md-6">
              <label class="mb-1">名</label>
              <input type="text" name="name_first" class="form-control" placeholder="例) まりこ" value="<?= $name_first ?>">
            </div>
          </div>
          <p class="mt-1 ms-3">※氏名は20字以内で設定してください。</p>
          <div class="row mb-3">
            <div class="col">
              <label class="mb-1">メールアドレス</label>
              <input type="email" name="email" class="form-control" placeholder="例) abc123@ddd.com" value="<?= $email ?>">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="mb-1">郵便番号</label>
              <input type="text" name="postal_code" class="form-control" onKeyUp="AjaxZip3.zip2addr(this,'','address','address');" placeholder="例) 1000000" value="<?= $postal_code ?>">
            </div>
            <div class="col mt-auto">
              郵便番号入力後、住所が自動的に表示されます。<br>
              ご不明の方は、<a href="https://www.post.japanpost.jp/zipcode/index.html" target="_blank" rel="noopener noreferrer">郵便番号検索</a> をご利用ください。
            </div>
          </div>
          <div class="row mb-3">
            <label class="mb-1">住所</label>
            <div class="col">
              <input type="text" name="address" class="form-control" placeholder="例) 東京都千代田区〇丁目△番地 □□マンション 101号室" value="<?= $address ?>">
            </div>
          </div>
          <!-- 住所を市区町村と番地で入力項目分けた場合
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="mb-1">郵便番号</label>
              <input type="text" name="postal_code" class="form-control" onKeyUp="AjaxZip3.zip2addr(this,'','address','address');" placeholder="例) 1000000" value="<?= $postal_code ?>">
            </div>
            <div class="col mt-auto">
              郵便番号入力後、市区町村が自動的に表示されます。<br>
              ご不明の方は、<a href="https://www.post.japanpost.jp/zipcode/index.html" target="_blank" rel="noopener noreferrer">郵便番号検索</a> をご利用ください。
            </div>
          </div>
          <div class="row mb-3">
            <label class="mb-1">市区町村</label>
            <div class="col">
              <input type="text" name="address" class="form-control" placeholder="例) 東京都千代田区" value="<?= $address ?>">
            </div>
          </div>
          <div class="row mb-3">
            <label class="mb-1">番地・建物名</label>
            <div class="col">
              <input type="text" name="address_2" class="form-control" placeholder="例) 〇丁目△番地 □□マンション 101号室" value="<?= $house_number ?>">
            </div>
          </div> -->
          <div class="row mb-3">
            <div class="col">
              <label class="mb-1">電話番号</label>
              <input type="text" name="telephone_num" class="form-control" placeholder="例) 12345678912" value="<?= $telephone_num ?>">
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label class="mb-1">パスワード</label>
              <input type="password" name="password" class="form-control" placeholder="例) AbC12345678" value="<?= $password ?>">
            </div>
          </div>
          <p class="mt-1 mb-3 ms-3">※パスワードは半角英数字をそれぞれ1文字以上含んだ、8文字以上24字以内で設定してください。</p></br>
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