<?php
// セッションを宣言
session_start();

// 管理者としてログインしているかチェック
if (isset($_SESSION['admin'])) {
} else {
  header("Location: admin_login.php");
  die();
}

// OrderModelファイルを読み込み
require_once('../Model/OrderModel.php');
// Orderクラスを呼び出し
$pdo = new OrderModel();
// showメソッドを呼び出し
$customer_id = $_POST['customer_id'];
$order_id = $_POST['order_id'];
$orders = $pdo->admin_show($customer_id, $order_id);
$orders = $orders->fetch(PDO::FETCH_ASSOC);

// OrderDetailファイルを読み込み
require_once('../Model/OrderDetailModel.php');
// OrderDetailクラスを呼び出し
$pdo = new OrderDetailModel();
// showメソッドを呼び出し
$order_details = $pdo->show($order_id);

?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center mt-5 mb-3">注文履歴詳細</h1>
    <div class="col-md-8">
      <form method="POST">
        <div class="d-flex justify-content-end">
          <button type="submit" name="back" formaction="./admin_order_index.php" class="btn btn-outline-secondary mb-3">注文履歴一覧へ戻る</button>
        </div>
        <div class="row">
          <h5>注文内容</h5>
          <table class="table table-bordered border-dark">
            <thead>
              <tr>
                <th scope="col" class="col-6 table-active">商品</th>
                <th scope="col" class="col-2 table-active">単価（税込）</th>
                <th scope="col" class="col-1 table-active">個数</th>
                <th scope="col" class="col-1 table-active">小計</th>
              </tr>
            </thead>
            <?php $total = 0;
            foreach ($order_details as $order_detail) { ?>
              <tbody>
                <tr>
                  <td class="align-middle"><?= $order_detail['name'] ?></td>
                  <td class="align-middle"><?= number_format($order_detail['price']) ?></td>
                  <td class="align-middle"><?= number_format($order_detail['quantity']) ?></td>
                  <td class="align-middle"><?= number_format((int)$order_detail['price'] * (int)$order_detail['quantity']) ?></td>
                  <?php
                  $subtotal = (int)$order_detail['price'] * (int)$order_detail['quantity'];
                  $total += $subtotal;
                  ?>
                </tr>
              </tbody>
            <?php } ?>
          </table>
          <h5>注文情報</h5>
          <table class="table table-bordered border-dark">
            <tbody>
              <tr>
                <th scope="col" class="table-active">購入者</th>
                <td colspan="3"><?= $orders['name_last'] . $orders['name_first'] ?></td>
              </tr>
              <tr>
                <th scope="col" class="table-active">注文日</th>
                <td><?= $orders['created_at'] ?></td>
                <th scope="col" class="table-active">商品合計</th>
                <td><?= number_format($total) ?></td>
              </tr>
              <tr>
                <th scope="col" class="table-active align-middle">配送先</th>
                <td class="align-middle"><?= '〒' . substr_replace($orders['postal_code'], '-', 3, 0) . '<br>' . $orders['address'] . '&nbsp' . $orders['house_num'] . '<br>' . $orders['orderer_name'] ?></td>
                <th scope="col" class="table-active align-middle">配送料</th>
                <td class="align-middle"><?= $orders['postage'] ?></td>
              </tr>
              <tr>
                <th scope="col" class="table-active">支払方法</th>
                <?php if ($orders['payment_way'] === 0) : ?>
                  <td>銀行振込</td>
                <?php else : ?>
                  <td>クレジットカード</td>
                <?php endif ?>
                <th scope="col" class="table-active">請求額</th>
                <td><?= number_format($total + (int)$orders['postage']) ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once '../view_common/footer.php'; ?>