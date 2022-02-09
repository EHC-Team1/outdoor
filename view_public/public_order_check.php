<?php
// セッションを宣言
session_start();

require_once('../Model/OrderModel.php');
$pdo = new OrderModel();

?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <h1>注文情報の確認</h1>
  <div class="row">
    <form action="public_order_complete.php" method="POST">
      <div class="form-group">
        <table border="1">
          <tr>
            <th>商品名</th>
            <th>単価(税込み)</th>
            <th>数量</th>
            <th>小計</th>
          </tr>
          <tr>
            <!-- 購入商品の表示 -->
            <?php ?>
              <td><? ?></td>
              <td><? ?></td>
              <td><? ?></td>
              <td><? ?></td>
            <?php ?>
          </tr>
        </table>
        <table border="1">
          <tbody>
            <tr>
              <th>送料</th>
              <td></td>
            </tr>
            <tr>
              <th>商品合計</th>
              <td></td>
            </tr>
            <tr>
              <th>請求額</th>
            </tr>
          </tbody>
        </table>
      </div>
    </form>
  </div>
</div>












<?php require_once '../view_common/footer.php'; ?>