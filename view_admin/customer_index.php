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
  <form method="post">
    <div class="row d-flex align-items-center justify-content-center mt-5">
    </div>
  </form>
  <div class="row d-flex justify-content-center">
    <div class="col-sm-10 d-flex flex-row-reverse">
      <button onclick="location.href='admin_item_index.php'" class="btn btn-outline-secondary btn-lg mt-3">戻る</button>
    </div>
  </div>
  <h1 class="text-center my-5">ユーザー一覧</h1>
  <div class="row d-flex align-items-center justify-content-center">
    <div class="col-sm-10">

      <!-- 退会済みタブ選択時 部分テンプレート使用 -->
      <?php if (isset($_GET['secession_members'])) { ?>
        <?php require_once 'customer_index_secession.php'; ?>

        <!-- 会員タブ選択時 -->
      <?php } else { ?>
        <div class="sticky-top bg-white">
          <p>氏名をクリックすると、「退会」処理を実行します</p>
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link bg-secondary text-white h5" href="#">会員</a>
            </li>
            <li class="nav-item">
              <a class="nav-link h5" href="customer_index.php?secession_members" style="color:black">退会済み</a>
            </li>
          </ul>
          <table class="table table-borderless m-0">
            <thead>
              <tr class="row h5 py-3 mx-0 mb-0 bg-secondary text-white">
                <th class="col-sm-2">&emsp;氏名
                  <small class="h6"> (入会日)</small>
                </th>
                <th class="col-sm-3">&emsp;メールアドレス</th>
                <th class="col-sm-5">&emsp;住所</th>
                <th class="col-sm-2">&emsp;電話番号</th>
              </tr>
            </thead>
          </table>
        </div>

        <table class="table table-borderless">
          <?php $i = 0;
          foreach ($customers as $customer) {
            $i++ ?>
            <tbody>
              <tr scope="col">
                <td rowspan="2" class="border-bottom align-middle ps-0 pe-1">
                  <h5 class="text-muted">
                    <?= $i ?>
                  </h5>
                </td>
              </tr>
              <tr class="row d-flex align-items-center py-3 m-0 border-bottom table table-hover">
                <td class="col-md-2">
                  <div class="row h5 mb-1">
                    <a href="customer_index.php?id=<?= $customer["id"] ?>" name="secession" class="secession_btn p-0" style="text-decoration:none">
                      <div class="text-dark ps-3">
                        <?= $customer['name_last'] . '&nbsp;' . $customer['name_first'] ?>
                      </div>
                  </div>
                  <div class="row text-end me-3">
                    <small class="text-muted">
                      <?= date('Y-m-d', strtotime($customer['created_at'])) ?>
                    </small>
                    </a>
                  </div>
                </td>
                <td class="col-md-3 ps-3 ~~~" style="word-wrap:break-word;">
                  <?= $customer['email'] ?>
                </td>
                <td class="col-md-5 ps-3 ~~~" style="word-wrap:break-word;">
                  <div class="mb-1">
                    <?= '〒' . substr_replace($customer['postal_code'], '-', 3, 0) . '<br>' ?>
                  </div>
                  <?= $customer['address'] . '<br>' . $customer['house_num'] ?>
                </td>
                <td class="col-md-2 ps-3">
                  <?= $customer['telephone_num'] ?>
                </td>
              </tr>
            </tbody>
          <?php } ?>
        </table>
        <?php require_once '../view_common/paging.php'; ?>
      <?php } ?>
    </div>
  </div>
</div>

<!-- 退会・再入会処理用jsファイル -->
<script src="../js/customer_index.js"></script>
<?php require_once '../view_common/footer.php'; ?>