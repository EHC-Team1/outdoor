<?php
// セッションを宣言
session_start();

// CartItemModelファイル読み込み
require_once('../Model/CartItemModel.php');
// CartItemクラス呼び出し
$pdo = new CartItemModel();
// indexメソッド呼び出し
$cart_items = $pdo->index();

// 削除ボタンが押下された時
if (isset($_POST['delete'])) {
  // CartItemクラスを呼び出し
  $pdo = new CartItemModel();
  // deleteメソッドを呼び出し
  $cart_item = $pdo->delete();
  // サクセスメッセージを$messageに格納
  $message = $cart_item;

  // CartItemクラスを呼び出し
  $pdo = new CartItemModel();
  // indexメソッドを呼び出し
  $cart_items = $pdo->index();
}

?>

<?php require_once('../view_common/header.php') ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center mt-5 mb-5">ショッピングカート</h1>
    <div class="col-md-8">
      <!-- カート内商品の表示 -->
      <?php $cart_items = $cart_items->fetchAll(PDO::FETCH_ASSOC);
      foreach ($cart_items as $cart_item) { ?>
        <div class="card mb-4">
          <div class="row">
            <div class="col">
              <img src="../image/item_サンダル.jpg" width="80%" height="80%" class="px-3 mt-3 mb-3" alt="サンダル">
            </div>
            <div class="col">
              <div class="card m-3">
                <div class="card-body">
                  <form method="post">
                    <input type="hidden" name="id" value="<?php echo $cart_item['id'] ?>">
                    <button type="submit" name="delete" class="btn-close text-right" aria-label="Close"></button>
                  </form>
                  <?= $cart_item['name'] ?><br>
                  ¥<?= $cart_item['price'] ?>(税込)
                  <div class="field">
                    <button class="button down">-</button>
                    <input type="text" value='<?= $cart_item['quantity'] ?>' class="inputtext textbox">
                    <button class="button up">+</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
      <table class="table table-borderless">
        <tbody>
          <tr>
            <td class="text-center">商品合計(税込み)</td>
            <td>¥<?#= $cart_item['price'] ?></td><br>
          </tr>
          <tr>
            <td class="text-center">送料</td>
            <td>¥500</td>
          </tr>
        </tbody>
      </table>
      <div class="card">
        <div class="card-body">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td class="text-center">
                  <h5>注文合計(税込)</h5>
                </td>
                <td>¥<?#= $cart_item['price'] ?></td><br>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="../js/cart_item_index.js"></script>
<?php require_once('../view_common/footer.php') ?>