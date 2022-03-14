<?php
// セッションを宣言
session_start();

// 管理者としてログインしているかチェック
if (isset($_SESSION['admin'])) {
} else {
  header("Location: admin_login.php");
  die();
}

// CustomerModelファイルを読み込み
require_once('../Model/CustomerModel.php');

// 現在のページ数を取得
if (isset($_GET['page'])) {
  $page = (int)$_GET['page'];
} else {
  $page = 1;
}
// スタートのページを計算
if ($page > 1) {
  $start = ($page * 15) - 15;
} else {
  $start = 0;
}

// customerテーブルから、「会員」の全データ件数を取得
$pdo = new CustomerModel();
$pages = $pdo->page_count_admin_index();
$page_num = $pages->fetchColumn();
// ページネーションの数を取得
$pagination = ceil($page_num / 15);

// Customerクラスを呼び出し
$pdo = new CustomerModel();
// indexメソッドを呼び出し
$customers = $pdo->index($start);
// モデルからreturnしてきた情報を変数に格納
$customers = $customers->fetchAll(PDO::FETCH_ASSOC);

// 「会員」タグ選択時、「名前」クリックで退会処理
if (isset($_GET['id'])) {
  $id = $_GET["id"];
  // Customerクラスを呼び出し
  $pdo = new CustomerModel();
  // admin_switch_statusメソッドを呼び出し
  $customer_status = $pdo->admin_switch_status($id, $secession_member_id);
}

// 「退会済み」タグ クリックでユーザー一覧切り替え
if (isset($_GET['secession_members'])) {
  // Customerクラスを呼び出し
  $pdo = new CustomerModel();

  // customerテーブルから、「退会済み」会員の全データ件数を取得
  $pages = $pdo->page_count_admin_index();
  $page_num = $pages->fetchColumn();
  // ページネーションの数を取得
  $pagination = ceil($page_num / 15);

  // indexメソッドを呼び出し
  $customers = $pdo->index($start);
  // モデルからreturnしてきた情報を変数に格納
  $customers = $customers->fetchAll(PDO::FETCH_ASSOC);
}

// 「退会済み」タグ選択時、「名前」クリックで再入会処理
if (isset($_GET['secession_member_id'])) {
  $secession_member_id = $_GET["secession_member_id"];
  // Customerクラスを呼び出し
  $pdo = new CustomerModel();
  // admin_switch_statusメソッドを呼び出し
  $switch_status = $pdo->admin_switch_status($id, $secession_member_id);
}
?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex justify-content-center bg-white sticky-sm-top">
    <div class="row d-flex justify-content-center mt-5">
      <div class="col-sm-12 d-flex flex-row-reverse">
        <button onclick="location.href='admin_item_index.php'" class="btn btn-outline-secondary btn-lg">戻る</button>
      </div>
    </div>
    <div class="row d-flex justify-content-center">
      <div class="col-sm-12 p-0">
        <h1 class="text-center">ユーザー一覧</h1>
        <p class="text-center">氏名をクリックすると、「退会」処理を実行します</p>

        <!-- 退会済みタブ選択時 部分テンプレート使用 -->
        <?php if (isset($_GET['secession_members'])) { ?>
          <?php require_once 'customer_index_secession.php'; ?>
          <!-- 会員タブ選択時 -->
        <?php } else { ?>
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link bg-secondary text-white h5" href="#">会員</a>
            </li>
            <li class="nav-item">
              <a class="nav-link h5" href="customer_index.php?secession_members" style="color:black">退会済み</a>
            </li>
          </ul>
          <table class="table table-borderless mb-1">
            <thead class="bg-secondary text-white">
              <tr>
                <th rowspan="3" class="align-middle col-sm-1 text-center"></th>
                <th rowspan="2" class="align-middle col-sm-4 text-center">
                  <h5>氏名</h5>
                </th>
                <th class="col-sm-7 text-center">メールアドレス</th>
              </tr>
              <tr>
                <th class="col-sm-7 text-center">住所</th>
              </tr>
              <tr>
                <th class="col-sm-4 text-center">入会日</th>
                <th class="col-sm-7 text-center">電話番号</th>
              </tr>
            </thead>
          </table>
      </div>
    </div>
  </div>
  <div class="row d-flex justify-content-center mx-1">
    <div class="col-sm-12 p-0">
      <table class="table table-borderless m-0">
        <?php $i = 0;
          foreach ($customers as $customer) {
            $i++ ?>
          <tbody class="bg-secondary text-white border-bottom">
            <tr>
              <td rowspan="3" class="align-middle col-sm-1 text-center">
                <h5 class="text-white">
                  <?= $i ?>
                </h5>
              </td>
              <td rowspan="2" class="align-middle col-sm-4 text-center">
                <a href="customer_index.php?id=<?= $customer["id"] ?>" name="secession" class="secession_btn p-0" style="text-decoration:none">
                  <h5 class="text-white">
                    <?= $customer['name_last'] . '&nbsp;' . $customer['name_first'] ?>
                  </h5>
                </a>
              </td>
              <td class="col-sm-7 text-center">
                <?= $customer['email'] ?>
              </td>
            </tr>
            <tr>
              <td class="col-sm-7 text-center">
                <?= '〒' . substr_replace($customer['postal_code'], '-', 3, 0) . $customer['address'] . $customer['house_num'] ?>
              </td>
            </tr>
            <tr>
              <td class="col-sm-4 text-center">
                <?= date('Y-m-d', strtotime($customer['created_at'])) ?>
              </td>
              <td class="col-sm-7 text-center">
                <?= $customer['telephone_num'] ?>
              </td>
            </tr>
          </tbody>
        <?php } ?>
      </table>
    </div>
  </div>
  <?php require_once '../view_common/paging.php'; ?>
<?php } ?>


</div>

<!-- 退会・再入会処理用jsファイル -->
<script src="../js/customer_index.js"></script>
<?php require_once '../view_common/footer.php'; ?>