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
// admin_indexメソッドを呼び出し
$orders = $pdo->admin_index();
$orders = $orders->fetchAll(PDO::FETCH_ASSOC);

?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center my-5">注文履歴一覧</h1>
    <div class="col-md-9">
      <table class="table table-bordered border-dark">
        <thead class="table-active">
          <tr>
            <th scope="col" class="col-2">注文日</th>
            <th scope="col" class="col-2">購入者</th>
            <th scope="col" class="col-1">請求金額</th>
            <th scope="col" class="col-1">支払方法</th>
            <th scope="col" class="col-1">注文詳細</th>
          </tr>
        </thead>
        <!-- 注文履歴の表示 -->
        <?php
        foreach ($orders as $order) { ?>
          <form action="admin_order_detail.php" method="POST">
            <tbody>
              <tr>
                <td class="align-middle"><?= $order['created_at'] ?></td>
                <td class="align-middle"><?= $order['name_last'] . $order['name_first'] ?></td>
                <input type="hidden" name="customer_id" value="<?= $order['customer_id'] ?>">
                <td class="align-middle"><?= number_format($order['total_payment']) . '円' ?></td>
                <?php if ($order['payment_way'] === 0) : ?>
                  <td class="align-middle">銀行振込</td>
                <?php else : ?>
                  <td class="align-middle">クレジットカード</td>
                <?php endif ?>
                <td class="align-middle"><input type="submit" class="btn btn-primary" value="注文詳細へ"></td>
                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
              </tr>
            </tbody>
          </form>
        <?php } ?>
      </table>
    </div>
  </div>
</div>

<?php require_once '../view_common/footer.php'; ?>