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

// 現在のページ数を取得
if (isset($_GET['page'])) {
  $page = (int)$_GET['page'];
} else {
  $page = 1;
}
// スタートのページを計算
if ($page > 1) {
  $start = ($page * 10) - 10;
} else {
  $start = 0;
}

// ordersテーブルから全データ件数を取得
$pdo = new OrderModel();
$pages = $pdo->page_count_admin_index();
$page_num = $pages->fetchColumn();
// ページネーションの数を取得
$pagination = ceil($page_num / 10);

// Orderクラスを呼び出し
$pdo = new OrderModel();
// admin_indexメソッドを呼び出し
$orders = $pdo->admin_index($start);
// モデルからreturnしてきた情報をordersに格納
$orders = $orders->fetchAll(PDO::FETCH_ASSOC);

?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center mt-5 mb-3">注文履歴一覧</h1>
    <div class="col-md-9">
      <form method="POST">
        <div class="d-flex justify-content-end">
          <button type="submit" name="back" formaction="./admin_item_index.php" class="btn btn-outline-secondary mb-3">戻る</button>
        </div>
      </form>
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
                <td class="align-middle"><input type="submit" class="btn btn-secondary" value="注文詳細へ"></td>
                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
              </tr>
            </tbody>
          </form>
        <?php } ?>
      </table>
    </div>
  </div>
  <?php require_once '../view_common/paging.php'; ?>
</div>

<?php require_once '../view_common/footer.php'; ?>