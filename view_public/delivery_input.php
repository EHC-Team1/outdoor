<?php
// セッションを宣言
session_start();

// DeliveryModelファイルを読み込み
require_once('../Model/DeliveryModel.php');
// Deliveryクラスを呼び出す
$pdo = new DeliveryModel();

// 「新規登録」ボタンが押された場合
if (isset($_POST['input_delivery'])) {
  // Deliveryクラスを呼び出す
  $pdo = new DeliveryModel();
  // inputメソッドを呼び出す
  $delivery = $pdo->input();
  header('Location: mypage.php');
}
?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center my-5">配送先新規登録</h1>
    <div class="col-sm-8">
      <form method="POST">
        <div class="form-group">
          <input type="hidden" name="customer_id" value="<?= $_SESSION['customer']['id'] ?>">

          <div class="row mb-3">
            <div class="col">
              <strong><label class="mb-1">宛名</label></strong>
              <input type="text" name="name" class="form-control" id="delivery_name" placeholder="例) 藤浪翔平">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-sm-6">
              <strong><label class="mb-1">郵便番号</label></strong>
              <input type="number" name="postal_code" class="form-control" onKeyUp="AjaxZip3.zip2addr(this,'','address','address');" id="delivery_postal_code" placeholder="例) 1700014">
            </div>
            <div class="col mt-auto">
              郵便番号入力後、市区町村が自動的に表示されます。<br>
              ご不明の方は、<a href="https://www.post.japanpost.jp/zipcode/index.html" target="_blank" rel="noopener noreferrer">郵便番号検索</a> をご利用ください。
            </div>
          </div>
          <div class="row mb-3">
            <strong><label class="mb-1">市区町村</label></strong>
            <div class="col">
              <input type="text" name="address" class="form-control" id="delivery_address" class="col-md-8 p-0" placeholder="例) 東京都豊島区池袋">
            </div>
          </div>
          <div class="row mb-3">
            <strong><label class="mb-1">番地・建物名</label></strong>
            <div class="col">
              <input type="text" name="house_num" class="form-control" id="delivery_house_num" class="col-md-8 p-0" placeholder="例) 〇丁目△番地 □□マンション 101号室">
            </div>
          </div>
        </div>
        <div class="d-flex align-items-center flex-row-reverse justify-content-evenly my-5">
          <button type="submit" name="input_delivery" class="btn btn-outline-primary btn-lg" id="delivery_input_btn">新規登録</button>
          <button type="submit" name="back" formaction="./mypage.php" class="btn btn-outline-secondary btn-lg">マイページへ戻る</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- バリデーション用jsファイル -->
<script src="../js/delivery_input.js"></script>
<!-- 住所自動入力用jsファイル -->
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
<?php require_once '../view_common/footer.php'; ?>