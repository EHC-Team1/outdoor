<?php
// セッションを宣言
session_start();

// ログインしているかチェック
if (isset($_SESSION['customer'])) {
} else {
  // ログインしていなければトップ画面に遷移
  header("Location: ../view_public/top.php");
}

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

/// 削除ボタンが押下された時
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

// ------------ editへ移動 -------------
// 退会ボタンが押下された時
// if (isset($_POST['is_customer_flag'])) {
// $id = $_POST['id'];
// Customerクラスを呼び出し
// $pdo = new CustomerModel();
// public_switch_statusメソッドを呼び出し
// $customer_status = $pdo->public_switch_status($id);
// }
// --------- 20220307----------------

?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center my-5">お客様情報</h1>
    <div class="col-sm-8">
      <?php $customer = $customers->fetch(PDO::FETCH_ASSOC); ?>
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-borderless mb-0">
              <tbody>
                <tr>
                  <th scope="row">
                    氏名
          </div>
          </th>
          <td><?= $customer['name_last'] ?> <?= $customer['name_first'] ?>
          </td>
          </tr>
          <tr>
            <th scope="row">
              メールアドレス
        </div>
        </th>
        <td><?= $customer['email'] ?>
        </td>
        </tr>
        <tr>
          <th scope="row">
            郵便番号
          </th>
          <td><?= '〒' . substr_replace($customer['postal_code'], '-', 3, 0) ?></td>
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
  <div class="d-flex align-items-center justify-content-evenly mt-3 mb-5">
    <form action="public_order_index.php" method="POST">
      <input type="submit" class="btn btn-outline-primary btn-lg" value="注文履歴一覧">
    </form>
    <form action="customer_edit.php" method="POST">
      <input type="submit" class="btn btn-outline-success btn-lg" value="編集">
    </form>
  </div>
  <!-- <div class="row d-flex align-items-center justify-content-evenly mt-3">
        <div class="col-sm-3">
          <form action="public_order_index.php" method="POST">
            <input type="submit" class="btn btn-outline-secondary btn-lg" value="注文履歴一覧">
          </form>
        </div>
        <div class="col-sm-3">
          <form action="customer_edit.php" method="POST">
            <input type="submit" class="btn btn-outline-success btn-lg" value="編集">
          </form>
        </div> -->
  <!-- <div class="col-sm-3 text-center">
          <form method="post">
            <input type="hidden" name="id" value="<?= $customer['id'] ?>">
            <button type="submit" name="is_customer_flag" class="btn btn-outline-secondary btn-sm" id="is_customer_flag_btn">退会</button>
          </form>
        </div> -->

  <h1 class="text-center my-5">配送先一覧</h1>
  <!-- 配送先を繰り返しで表示 -->
  <?php $customer = $customers->fetch(PDO::FETCH_ASSOC); ?>
  <table class="table table-borderless mb-0">
    <tbody>
      <?php $i = 0;
      $deliveries = $deliveries->fetchAll(PDO::FETCH_ASSOC);
      foreach ($deliveries as $delivery) {
        $i++ ?>
        <tr>
          <td rowspan="3" class="align-middle col-sm-auto px-4">
            <h5 class="text-muted">
              <?= $i ?>
            </h5>
        </tr>
        <tr>
          <th scope="row" class="col-sm-1 pt-3 pb-0 h6">
            <?= $delivery['name'] ?> 様
          </th>
        </tr>
        <tr class="border-bottom pb-5">
          <td class="col-sm-8 align-middle pt-2 pb-3">
            <?= '〒' . substr_replace($delivery['postal_code'], '-', 3, 0) ?><br>
            <div class="col-auto">
              <?= $delivery['address'] . $delivery['house_num'] ?>
            </div>
          </td>
          <td class="col-sm-2 align-middle pt-0 pb-3">
            <form action="delivery_edit.php" method="post" class="d-flex align-items-center justify-content-center">
              <input type="hidden" name="id" value="<?php echo $delivery['id'] ?>">
              <button type="submit" name="edit" class="btn btn-outline-success">編集</button>
            </form>
          </td>
          <td class="col-sm-2 align-middle pt-0 pb-3">
            <form method="post" class="d-flex align-items-center justify-content-center">
              <input type="hidden" name="id" value="<?php echo $delivery['id'] ?>">
              <button type="submit" name="delete" class="btn btn-outline-danger">削除</button>
            </form>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  <form action="delivery_input.php" method="POST" class="text-center">
    <input type="submit" name="" class="btn btn-outline-primary btn-lg mt-3 mb-5" value="配送先追加">
  </form>
</div>
</div>
</div>


<!-- <div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center my-5">お客様情報</h1>
    <div class="col-sm-8">
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
            <button type="submit" name="is_customer_flag" class="btn btn-outline-secondary btn-sm" id="is_customer_flag_btn">退会</button>
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
                <td><?= '〒' . substr_replace($customer['postal_code'], '-', 3, 0) ?></td>
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
    <h1 class="text-center my-5">配送先一覧</h1>
    <div class="col-sm-8">
      <form action="delivery_input.php" method="POST">
        <input type="submit" name="" class="btn btn-outline-primary btn-sm mb-2" value="配送先追加">
      </form> -->
<!-- 配送先を繰り返しで表示 -->
<!-- <div class="card mb-5">
        <div class="card-body">
          <table class="table table-borderless">
            <tbody>
              <php $deliveries = $deliveries->fetchAll(PDO::FETCH_ASSOC);
              foreach ($deliveries as $delivery) { ?>
                <tr>
                  <td><?= $delivery['name'] ?>
                    様
                  </td>
                  <td><?= '〒' . substr_replace($delivery['postal_code'], '-', 3, 0) ?>
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
              <php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div> -->

<!-- バリデーション用jsファイル -->
<script src="../js/mypage.js"></script>
<?php require_once '../view_common/footer.php' ?>