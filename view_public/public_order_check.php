<?php
// セッションを宣言
session_start();

require_once('../Model/OrderModel.php');
$pdo = new OrderModel();

?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="d-flex align-items-center justify-content-center">
    <h1 class="text-center mt-5 mb-5">注文情報の確認</h1>
    <!-- 戻るボタンは仮置き -->
    <button onclick="history.back();" class="btn btn-outline-secondary">戻る</button>
  </div>
  <div class="row">
    <div class="col-md-9">
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
    </div>
    <div class="col-md-3">
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
  </div>
  <div class="row">
    <div class="col-md-10">
      <table>
        <tbody>
          <tr>
            <th>支払方法</th>
            <td><?php echo(htmlspecialchars($_POST['payment-way'], ENT_QUOTES)); ?></td>
          </tr>
          <tr>
            <th>お届け先</th>
            <td>〒<? ?> <? ?> <br><? ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="text-center mb-5">
    <form action="public_order_complete.php" method="POST">
      <input type="submit" name="check_order" class="btn btn-outline-primary btn-lg" value="注文を確定する">
    </form>
  </div>
</div>
</div>

</div>












<?php require_once '../view_common/footer.php'; ?>