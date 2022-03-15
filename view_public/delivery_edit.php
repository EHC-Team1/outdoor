<?php
// セッションを宣言
session_start();

// DeliveryModelファイルを呼び出し
require_once('../Model/DeliveryModel.php');
// Deliveryクラスを呼び出し
$pdo = new DeliveryModel();
// editメソッドを呼び出し
$delivery = $pdo->edit();
$delivery = $delivery->fetch(PDO::FETCH_ASSOC);

// 「更新」ボタンが押された場合
if (isset($_POST['update_delivery'])) {
  // Deliveryクラスを呼び出し
  $pdo = new DeliveryModel();
  // updateメソッドを呼び出し
  $delivery = $pdo->update($delivery);
  header('Location: mypage.php');
}

?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center my-5">配送先編集</h1>
    <div class="col-sm-8">
      <form method="POST">
        <div class="form-group">
          <input type="hidden" name="id" value="<?= $delivery['id'] ?>">
          <table class="table table-borderless">
            <div class="row mb-3">
              <div class="col">
                <strong><label class="mb-1">宛名</label></strong>
                <input type="text" name="name" class="form-control" class="form-control" id="delivery_name" placeholder="例) 藤浪翔平" value="<?= $delivery['name'] ?>">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-6">
                <strong><label class="mb-1">郵便番号</label></strong>
                <input type="number" min="0" name="postal_code" onKeyUp="AjaxZip3.zip2addr(this,'','address','address');" class="form-control" id="delivery_postal_code" placeholder="例) 1700014" value="<?= $delivery['postal_code'] ?>">
              </div>
              <div class="col mt-auto">
                郵便番号入力後、市区町村が自動的に表示されます。<br>
                ご不明の方は、<a href="https://www.post.japanpost.jp/zipcode/index.html" target="_blank" rel="noopener noreferrer">郵便番号検索</a> をご利用ください。
              </div>
            </div>
            <div class="row mb-3">
              <strong><label class="mb-1">市区町村</label></strong>
              <div class="col">
                <input type="text" name="address" class="form-control" id="delivery_address" placeholder="例) 東京都豊島区池袋" value="<?= $delivery['address'] ?>">
              </div>
            </div>
            <div class="row mb-3">
              <strong><label class="mb-1">番地・建物名</label></strong>
              <div class="col">
                <input type="text" name="house_num" class="form-control" id="delivery_house_num" placeholder="例) 〇丁目△番地 □□マンション 101号室" value="<?= $delivery['house_num'] ?>">
              </div>
            </div>
          </table>
        </div>
        <div class="d-flex align-items-center flex-row-reverse justify-content-evenly my-5">
          <button type="submit" name="update_delivery" class="btn btn-outline-success btn-lg" id="delivery_edit_btn">更新</button>
          <button type="submit" name="back" formaction="./mypage.php" class="btn btn-outline-secondary btn-lg">マイページへ戻る</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- 住所自動入力用jsファイル -->
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
<script src="../js/delivery_edit.js"></script>

<?php require_once '../view_common/footer.php'; ?>