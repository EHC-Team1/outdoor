<?php
// セッションを宣言
session_start();

// CustomerModelファイルを読み込み
require_once('../Model/CustomerModel.php');
// Customerクラスを呼び出す
$pdo = new CustomerModel();

?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center mt-5 mb-5">会員情報編集</h1>
    <div class="col-md-10">
      <form method="POST">
        <input type="hidden" name="id" value="<?php echo ($customer['id']); ?>">
        <table class="table table-borderless">
          <tbody>
            <tr>
              <th scope="row" class="col-md-4 text-right">氏名</th>
              <td class="col-md-8">
                <input type="text" name="name_last" id="" value="<? ?>"> 
                <input type="text" name="name_first" id="" value="<? ?>">
              </td>
            </tr>
            <tr>
              <th scope="row" class="col-md-4 text-right">メールアドレス</th>
              <td class="col-md-8">
                <input type="text" name="email" id="" value="<? ?>">
              </td>
            </tr>
            <tr>
              <th scope="row" class="col-md-4 text-right">郵便番号</th>
              <td class="col-md-8">
                <input type="text" name="postal_code" id="" value="<? ?>">
              </td>
            </tr>
            <tr>
              <th scope="row" class="col-md-4 text-right">住所</th>
              <td class="col-md-8">
                <input type="text" name="address" id="" value="<? ?>">
              </td>
            </tr>
            <tr>
              <th scope="row" class="col-md-4 text-right">電話番号</th>
              <td class="col-md-8">
                <input type="text" name="telephone_num" id="" value="<? ?>">
              </td>
            </tr>
          </tbody>
        </table>
        <div class="d-flex align-items-center justify-content-center">
          <button type="submit" name="update_customer" class="btn btn-outline-primary btn-lg" id="customer_update_btn">編集内容を保存</button> 
          <button onclick="history.back();" class="btn btn-outline-secondary btn-lg">保存せずに戻る</button>
        </div>
      </form>
    </div>
  </div>

</div>