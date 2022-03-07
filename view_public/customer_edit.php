<?php
// セッションを宣言
session_start();

// CustomerModelファイルを読み込み
require_once('../Model/CustomerModel.php');
// Customerクラスを呼び出す
$pdo = new CustomerModel();
// editメソッドを呼び出し
$customer = $pdo->edit();
$customer = $customer->fetch(PDO::FETCH_ASSOC);

// 「更新」ボタンが押された場合
if (isset($_POST['update_customer'])) {
  // Customerクラスを呼び出し
  $pdo = new CustomerModel();
  // updateメソッドを呼び出し
  $customer = $pdo->update($customer);
  header('Location: mypage.php');
}

// 退会ボタンが押下された時
if (isset($_POST['public_switch_status'])) {
  $id = $_POST['id'];
  // Customerクラスを呼び出し
  $pdo = new CustomerModel();
  // public_switch_statusメソッドを呼び出し
  $customer_status = $pdo->public_switch_status($id);
}
?>

<?php require_once '../view_common/header.php'; ?>
<!-- 住所自動入力用jsファイル -->
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center mt-5 mb-5">会員情報編集</h1>
    <div class="col-sm-8">
      <form method="POST">
        <input type="hidden" name="id" value="<?= $customer['id'] ?>">
        <div class="form-group">
          <div class="row mb-3">
            <div class="col-sm-6">
              <strong><label class="mb-1">姓</label></strong>
              <input type="text" name="name_last" class="form-control" id="customer_name_last" placeholder="例) 藤浪" value="<?= $customer['name_last'] ?>">
            </div>
            <div class="col-sm-6">
              <strong><label class="mb-1">名</label></strong>
              <input type="text" name="name_first" class="form-control" id="customer_name_first" placeholder="例) 翔平" value="<?= $customer['name_first'] ?>">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
              <strong><label class="mb-1">メールアドレス</label></strong>
              <input type="email" name="email" class="form-control" id="customer_email" placeholder="例) abc123@ddd.com" value="<?= $customer['email'] ?>"></td>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-sm-6">
              <strong><label class="mb-1">郵便番号</label></strong>
              <input type="number" name="postal_code" class="form-control" onKeyUp="AjaxZip3.zip2addr(this,'','address','address');" id="customer_postal_code" placeholder="例) 1700014" value="<?= $customer['postal_code'] ?>">
            </div>
            <div class="col mt-auto">
              郵便番号入力後、市区町村が自動的に表示されます。<br>
              ご不明の方は、<a href="https://www.post.japanpost.jp/zipcode/index.html" target="_blank" rel="noopener noreferrer">郵便番号検索</a> をご利用ください。
            </div>
          </div>
          <div class="row mb-3">
            <strong><label class="mb-1">市区町村</label></strong>
            <div class="col">
              <input type="text" name="address" class="form-control" id="customer_address" placeholder="例) 東京都豊島区池袋" value="<?= $customer['address'] ?>">
            </div>
          </div>
          <div class="row mb-3">
            <strong><label class="mb-1">番地・建物名</label></strong>
            <div class="col">
              <input type="text" name="house_num" class="form-control" id="customer_house_num" placeholder="例) 〇丁目△番地 □□マンション 101号室" value="<?= $customer['house_num'] ?>"></td>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
              <strong><label class="mb-1">電話番号</label></strong>
              <input type="number" name="telephone_num" class="form-control" id="customer_telephone_num" placeholder="例) 12345678912" value="<?= $customer['telephone_num'] ?>"></td>
            </div>
          </div>
          <div class="d-flex align-items-center justify-content-evenly mt-5 mb-3">
            <button type="submit" name="back" formaction="./mypage.php" class="btn btn-outline-secondary btn-lg">マイページへ戻る</button>
            <button type="submit" name="update_customer" class="btn btn-outline-primary btn-lg" id="customer_update_btn">編集内容を保存</button>
          </div>
          <div class="d-flex align-items-center justify-content-end mb-5">
            <button type="submit" name="public_switch_status" class="btn btn-outline-danger" id="public_switch_status_btn">退会</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="../js/customer_edit.js"></script>
<?php require_once '../view_common/footer.php'; ?>