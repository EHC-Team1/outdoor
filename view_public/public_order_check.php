<?php
// セッションを宣言
session_start();

// OrderModelファイルを読み込み
require_once('../Model/OrderModel.php');
// Orderクラスを呼び出し
$pdo = new OrderModel();

// CartItemModelファイル読み込み
require_once('../Model/CartItemModel.php');
// CartItemクラス呼び出し
$pdo = new CartItemModel();
// indexメソッド呼び出し
$cart_items = $pdo->index();

?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center mt-5 mb-5">注文情報の確認</h1>


    <div class="col-md-9">
      <table class="table table-bordered border-dark">
        <thead class="table-active">
          <tr>
            <th scope="col" class="col-6">商品名</th>
            <th scope="col" class="col-2">単価(税込み)</th>
            <th scope="col" class="col-2">数量</th>
            <th scope="col" class="col-2">小計</th>
          </tr>
        </thead>
        <!-- 購入商品の表示 -->
        <?php $cart_items = $cart_items->fetchAll(PDO::FETCH_ASSOC);
        // 合計の初期値は0
        $total = 0;
        foreach ($cart_items as $cart_item) {
          // 各商品の小計を取得
          $subtotal = (int)$cart_item['price'] * (int)$cart_item['quantity'];
          // 各商品の小計を$totalに足す
          $total += $subtotal;
          $target = $cart_item["item_image"]; ?>
          <tbody>
            <tr>
              <form method="post" id="cart_item_index">
                <input type="hidden" name="id" value="<?php echo $cart_item['id'] ?>">
                <td>
                  <?php
                  if ($cart_item["extension"] == "jpeg" || $cart_item["extension"] == "png" || $cart_item["extension"] == "gif") {
                    echo ("<img src='../view_common/item_image.php?target=$target'width=60 height=60>");
                  }
                  ?>
                  <?= $cart_item['name'] ?>
                </td>
                <td class="align-middle"><?= number_format($cart_item['price']); ?></td>
                <td class="align-middle"><?= number_format($cart_item['quantity']); ?></td>
                <td class="align-middle"><?= number_format($subtotal); ?></td>
              </form>
            <?php } ?>
            </tr>
          </tbody>
      </table>
      <div class="row">
        <div class="col-md-4">
          <table class="table table-bordered border-dark">
            <tbody>
              <tr>
                <th scope="col" class="table-active">送料</th>
                <td>500</td>
              </tr>
              <tr>
                <th scope="col" class="table-active">商品合計</th>
                <td><?= number_format($total); ?></td>
              </tr>
              <tr>
                <th scope="col" class="table-active">請求額</th>
                <td><?= number_format($total + 500); ?></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-md-8">
          <h5><label class="row">支払方法</label></h5>
          <ul>
            <li class="list-unstyled">
              <?= (htmlspecialchars($_POST['payment-way'], ENT_QUOTES)); ?>
            </li>
          </ul>
          <h5><label class="row">お届け先</label></h5>
          <ul>
            <li class="list-unstyled">
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="text-center mb-5">
      <form action="public_order_complete.php" method="POST">
        <input type="submit" name="check_order" class="btn btn-outline-primary btn-lg" value="注文を確定する">
      </form>
    </div>
  </div>
</div>

<?php require_once '../view_common/footer.php'; ?>