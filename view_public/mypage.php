<?php
// セッションを宣言
session_start();

// CustomerModelファイルを読み込み
require_once('../Model/CustomerModel.php');
// Customerクラスを呼び出し
$pdo = new CustomerModel();
// showメソッドを呼び出し
$customers = $pdo->show();

// DeliveryModelファイルを読み込み
require_once('../Model/DeliveryModel.php');
// Deliveryクラスを呼び出し
$pdo = new DeliveryModel();
// indexメソッドを呼び出し
$deliveries = $pdo->index();

// 削除ボタンが押下された時
if (isset($_POST['delete'])) {
  // Deliveryクラスを呼び出し
  $pdo = new DeliveryModel();
  // deleteメソッドを呼び出し
  $delivery = $pdo->delete();
  // サクセスメッセージを$messageに格納
  $message = $delivery;

  // Deliveryクラスを呼び出し
  $pdo = new DeliveryModel();
  // indexメソッドを呼び出し
  $deliveries = $pdo->index();
}

// 退会ボタンが押下された時
if (isset($_POST['is_customer_flag'])) {
  // Customerクラスを呼び出し
  $pdo = new CustomerModel();
  // is_customer_flagメソッドを呼び出し
  $customer_status = $pdo->is_customer_flag();
}


?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center mt-5 mb-5">お客様情報</h1>
    <div class="col-md-8">
      <?php $customer = $customers->fetch(PDO::FETCH_ASSOC); ?>
      <div class="btn-toolbar mb-2">
        <div class="btn-group">
          <form action="public_order_index.php" method="POST">
            <input type="submit" class="btn btn-outline-primary btn-sm" value="注文履歴一覧">
          </form>
          <form action="customer_edit.php" method="POST">
            <input type="submit" class="btn btn-outline-success btn-sm" value="編集">
          </form>
          <form method="post">
            <input type="hidden" name="id" value="<?= $customer['id'] ?>">
            <button type="submit" name="is_customer_flag" class="btn btn-outline-danger btn-sm" id="is_customer_flag_btn">退会</button>
          </form>
        </div>
      </div>
      <div class="card">
        <div class="card-body col-md-12">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <th scope="row">
                  氏名
                </th>
                <td><?= $customer['name_last'] ?> <?= $customer['name_first'] ?>
                </td>
              </tr>
              <tr>
                <th scope="row">
                  メールアドレス
                </th>
                <td><?= $customer['email'] ?>
                </td>
              </tr>
              <tr>
                <th scope="row">
                  郵便番号
                </th>
                <td><?= $customer['postal_code'] ?></td>
              </tr>
              <tr>
                <th scope="row">
                  住所
                </th>
                <td><?= $customer['address'] . $customer['house_num'] ?>
                </td>
              </tr>
              <tr>
                <th scope="row">
                  電話番号
                </th>
                <td><?= $customer['telephone_num'] ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <h1 class="text-center mt-5 mb-5">配送先一覧</h1>
    <div class="col-md-8">
      <form action="delivery_input.php" method="POST">
        <input type="submit" name="" class="btn btn-outline-primary btn-sm mb-2" value="配送先追加">
      </form>
      <!-- 配送先を繰り返しで表示 -->
      <div class="card mb-3">
        <div class="card-body">
          <table class="table table-borderless">
            <tbody>
              <?php $deliveries = $deliveries->fetchAll(PDO::FETCH_ASSOC);
              foreach ($deliveries as $delivery) { ?>
                <tr>
                  <td><?= $delivery['name'] ?>
                    様
                  </td>
                  <td><?= $delivery['postal_code'] ?>
                  </td>
                  <td><?= $delivery['address'] . $delivery['house_num'] ?>
                  </td>
                  <td>
                    <form action="delivery_edit.php" method="post" class="d-flex align-items-center justify-content-center">
                      <input type="hidden" name="id" value="<?php echo $delivery['id'] ?>">
                      <button type="submit" name="edit" class="btn btn-outline-success">編集</button>
                    </form>
                  </td>
                  <td>
                    <form method="post" class="d-flex align-items-center justify-content-center">
                      <input type="hidden" name="id" value="<?php echo $delivery['id'] ?>">
                      <button type="submit" name="delete" class="btn btn-outline-danger">削除</button>
                    </form>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- バリデーション用jsファイル -->
<script src="../js/mypage.js"></script>
<?php require_once '../view_common/footer.php'; ?>