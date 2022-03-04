<?php
// セッションを宣言
session_start();

// OrderDetailModelファイルを読み込み
require_once('../Model/OrderDetailModel.php');
// OrderDetailクラスを呼び出し
$pdo = new OrderDetailModel();
// showメソッドを呼び出し
$orders = $pdo->show();

?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center mt-5 mb-5">注文履歴詳細</h1>
    <!-- <?#php $order_detail = $order_details->fetch(PDO::FETCH_ASSOC); ?> -->
    <div class="col-md-9">
      <form method="POST">
        <div class="row">
          <div class="col-md-4">
            <h5>注文情報</h5>
            <table class="table table-bordered border-dark">
              <tbody>
                <tr>
                  <th scope="col" class="table-active">注文日</th>
                  <!-- <td><?#= $order_detail['created_at'] ?></td> -->
                </tr>
                <tr>
                  <th scope="col" class="table-active">配送先</th>
                  <!-- <td class="align-middle"><?#= '〒' . substr_replace($order_detail['postal_code'], '-', 3, 0) . '<br>' . $order_detail['address'] . '&nbsp' . $order_detail['house_num'] . '<br>' . $order_detail['orderer_name'] ?></td> -->
                </tr>
                <tr>
                  <th scope="col" class="table-active">支払方法</th>
                  <!-- <td><?#= $order_detail['payment_way'] ?></td> -->
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-md-8">
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once '../view_common/footer.php'; ?>