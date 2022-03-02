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

// 「名前」クリックで退会処理
if (isset($_GET['id']) ) {
  $id = $_GET["id"];
  // Customerクラスを呼び出し
  $pdo = new CustomerModel();
  // admin_is_customer_flagメソッドを呼び出し
  $customer_status = $pdo->admin_is_customer_flag($id);
}

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
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active bg-secondary text-white h5" aria-current="page" href="#">会員</a>
        </li>
        <li class="nav-item">
          <a class="nav-link h6" href="" name="secession_member" style="color:black">退会済み</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled">&emsp;名前をクリックすると退会処理を実行します</a>
        </li>
        <!-- <div class="row d-flex align-items-center justify-content-center">
          <div class="col-md-10">
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <a class="nav-link" href="#" style="color:black">登録中</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">退会済み</a>
              </li> -->
        <!-- <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">退会済み</a>
    <ul class="dropdown-menu">
      <li><a class="dropdown-item" href="#">2022年</a></li>
      <li><a class="dropdown-item" href="#">2021年</a></li>
      <li><a class="dropdown-item" href="#">2020年</a></li>
    </ul>
  </li> -->
      </ul>
      <div class="card-body pt-0 px-0">
        <div class="row h5 py-4 mx-0 bg-secondary text-white">
          <div class="d-flex align-items-center">
            <div class="col-md-2">
              名前
            </div>
            <div class="col-md-3">
              メールアドレス
            </div>
            <div class="col-md-5">
              住所
            </div>
            <div class="col-md-2">
              電話番号
            </div>
          </div>
        </div>
        <?php
        foreach ($customers as $customer) { ?>
          <!-- <div class="table table-bordered table-striped table-hover">  ホバーで色変える、隔行で色変えたい-->
          <tbody>
            <div class="row d-flex align-items-center px-4 py-3 border-bottom">
              <div class="col-md-2 p-0 h5">
                <!-- 出来たらアラートに苗字だけ表示したい -->
                <!-- <a href="#?id=<?= $customer["id"], $customer["name_last"] ?>" name="secession" class="secession_btn" style="text-decoration:none"> -->
                <a href="customer_index.php?id=<?= $customer["id"] ?>" class="secession_btn" style="text-decoration:none">
                  <div class="text-dark">
                    <?= $customer['name_last'] . '&nbsp;' . $customer['name_first'] ?>
                  </div>
                </a>
              </div>
              <div class="col-md-3 p-0">
                <td><?= $customer['email'] ?>
              </div>
              <div class="col-md-5 p-0">
                <div class="mb-1">
                  <?= '〒' . substr_replace($customer['postal_code'], '-', 3, 0) . '<br>' ?>
                </div>
                <?= '&emsp;' . $customer['address'] . '<br>' . '&emsp;' . $customer['house_num'] ?>
              </div>
              <div class="col-md-2 p-0">
                <td><?= $customer['telephone_num'] ?>
              </div>
            </div>
          </tbody>
        <?php } ?>
        </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- 退会・再入会処理用jsファイル -->
<script src="../js/customer_index.js"></script>
<?php require_once '../view_common/footer.php'; ?>