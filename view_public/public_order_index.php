<?php
// セッションを宣言
session_start();

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

// ordersテーブルから該当ジャンルのデータ件数を取得
$pdo = new OrderModel();
$pages = $pdo->page_count_public_index();
$page_num = $pages->fetchColumn();
// ページネーションの数を取得
$pagination = ceil($page_num / 10);

// Orderクラスを呼び出し
$pdo = new OrderModel();
// indexメソッドを呼び出し
$orders = $pdo->index($start);
$orders = $orders->fetchAll(PDO::FETCH_ASSOC);

?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center mt-5 mb-3">注文履歴一覧</h1>
    <div class="col-md-9">
      <form method="POST">
        <div class="d-flex justify-content-end">
          <button type="submit" name="back" formaction="./mypage.php" class="btn btn-outline-secondary mb-3">マイページへ戻る</button>
        </div>
      </form>
      <input type="hidden" name="customer_id" value="<?= $_SESSION['customer']['id'] ?>">
      <table class="table table-bordered border-dark">
        <thead class="table-active">
          <tr>
            <th scope="col" class="col-2">注文日</th>
            <th scope="col" class="col-4">配送先</th>
            <th scope="col" class="col-1">支払金額</th>
            <th scope="col" class="col-1">注文詳細</th>
          </tr>
        </thead>
        <!-- 注文履歴の表示 -->
        <?php
        foreach ($orders as $order) { ?>
          <form action="public_order_show.php" method="POST">
            <tbody>
              <tr>
                <td class="align-middle"><?= $order['created_at'] ?></td>
                <td class="align-middle"><?= '〒' . substr_replace($order['postal_code'], '-', 3, 0) . '<br>' . $order['address'] . '&nbsp' . $order['house_num'] . '<br>' . $order['orderer_name'] ?></td>
                <td class="align-middle"><?= number_format($order['total_payment']) . '円' ?></td>
                <td class="align-middle"><input type="submit" class="btn btn-primary" value="注文詳細へ"></td>
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