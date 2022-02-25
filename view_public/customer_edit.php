<?php
// セッションを宣言
session_start();

// CustomerModelファイルを読み込み
require_once('../Model/CustomerModel.php');
// Customerクラスを呼び出す
$pdo = new CustomerModel();
// editメソッドを呼び出し
$customer = $pdo->edit();
$customer = $customer->fetch(PDO::FETCH_ASSOC);

// 「更新」ボタンが押された場合
if (isset($_POST['update_customer'])) {
  // Customerクラスを呼び出し
  $pdo = new CustomerModel();
  // updateメソッドを呼び出し
  $customer = $pdo->update($customer);
  header('Location: mypage.php');
}
?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center mt-5 mb-5">会員情報編集</h1>
    <div class="col-md-8">
      <form method="POST">
        <input type="hidden" name="id" value="<?= $customer['id'] ?>">
        <table class="table table-borderless">
          <thead>
            <tr>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">氏名</th>
              <td><input type="text" name="name_last" class="form-control" id="customer_name_last" value="<?= $customer['name_last'] ?>"></td>
              <td><input type="text" name="name_first" class="form-control" id="customer_name_first" value="<?= $customer['name_first'] ?>"></td>
            </tr>
            <tr>
              <th scope="row">メールアドレス</th>
              <td colspan="2"><input type="text" name="email" class="form-control" id="customer_email" value="<?= $customer['email'] ?>"></td>
            </tr>
            <tr>
              <th scope="row">郵便番号</th>
              <td colspan="2"><input type="text" name="postal_code" class="form-control" id="customer_postal_code" value="<?= $customer['postal_code'] ?>"></td>
            </tr>
            <tr>
              <th scope="row">住所</th>
              <td colspan="2"><input type="text" name="address" class="form-control" id="customer_address" value="<?= $customer['address'] ?>"></td>
            </tr>
            <tr>
              <th scope="row">電話番号</th>
              <td colspan="2"><input type="text" name="telephone_num" class="form-control" id="customer_telephone_num" value="<?= $customer['telephone_num'] ?>"></td>
            </tr>
          </tbody>
        </table>
        <div class="d-flex align-items-center justify-content-center">
          <button type="submit" name="update_customer" class="btn btn-outline-primary btn-lg" id="customer_update_btn">編集内容を保存</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="../js/customer_edit.js"></script>
<?php require_once '../view_common/footer.php'; ?>