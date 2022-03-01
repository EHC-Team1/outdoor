<?php
// セッションを宣言
session_start();

// 管理者としてログインしているかチェック
// if (isset($_SESSION['admin'])) {
// } else {
//   header("Location: admin_login.php");
//   die();
// }

// CustomerModelファイルを読み込み
require_once('../Model/CustomerModel.php');
// Customerクラスを呼び出し
$pdo = new CustomerModel();
// indexメソッドを呼び出し
$customers = $pdo->index();
?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <form method="post">
    <div class="row d-flex align-items-center justify-content-center mt-5">
    </div>
  </form>
  <div class="row d-flex justify-content-center">
    <div class="col-md-10 d-flex flex-row-reverse">
      <button onclick="location.href='admin_item_index.php'" class="btn btn-outline-secondary btn-lg mt-3">戻る</button>
    </div>
  </div>
  <h1 class="text-center mt-5 mb-5">ユーザー一覧</h1>
  <div class="row d-flex align-items-center justify-content-center">
    <div class="col-md-10">
      <table class="table">
        <tbody>
          <tr bgcolor='#BCCDCF'>
            <th>お名前</th>
            <th>メールアドレス</th>
            <th>郵便番号</th>
            <th>ご住所</th>
            <th>ご連絡先</th>
          </tr>
          <?php
          foreach ($customers as $customer) { ?>
            <tr>
              <!-- <tr :nth-child(ood) bgcolor='#DCF0F2'> -->
              <?php echo "<h4>"; ?>
              <td><?= $customer['name_last'] . '&nbsp;' . $customer['name_first'] ?> 様</td>
              <td><?= $customer['email'] ?></td>
              <td><?= '〒' . '&nbsp' . substr_replace($customer['postal_code'], '-', 3, 0) ?></td>
              <td><?= $customer['address'] .'<br>'. $customer['house_num'] ?></td>
              <td><?= $customer['telephone_num'] ?></td>
              <?php echo "<h4>"; ?>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require_once '../view_common/footer.php'; ?>