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
  var_dump($page);
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
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link bg-secondary text-white h5" href="#">会員</a>
          </li>
          <li class="nav-item">
            <a class="nav-link h5" href="customer_index.php?secession_members" style="color:black">退会済み</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled">&emsp;名前をクリックすると、「退会」処理を実行します</a>
          </li>
        </ul>

        <div class="card-body pt-0 px-0">
          <div class="row h5 py-4 mx-0 bg-secondary text-white">
            <div class="d-flex align-items-center">
              <div class="col-md-2">
                &nbsp;名前
                <small class="h6">(登録日)</small>
              </div>
              <div class="col-md-3">
                &nbsp;メールアドレス
              </div>
              <div class="col-md-5">
                &nbsp;住所
              </div>
              <div class="col-md-2">
                &nbsp;電話番号
              </div>
            </div>
          </div>
          <?php foreach ($customers as $customer) { ?>
            <tbody>
              <div class="row d-flex align-items-center px-4 py-3 border-bottom">
                <div class="col-md-2">
                  <div class="row mb-1 h5">
                    <a href="customer_index.php?id=<?= $customer["id"] ?>" name="secession" class="secession_btn" style="text-decoration:none">
                      <div class="text-dark">
                        <?= $customer['name_last'] . '&nbsp;' . $customer['name_first'] ?>
                      </div>
                    </a>
                  </div>
                  <div class="row text-end me-1">
                    <small class="text-muted">
                      <?= date('Y-m-d', strtotime($customer['created_at'])) ?>
                    </small>
                  </div>
                </div>
                <div class="col-md-3 ~~~" style="word-wrap:break-word;">
                  <?= $customer['email'] ?>
                </div>
                <div class="col-md-5 ~~~" style="word-wrap:break-word;">
                  <div class="mb-1">
                    <?= '〒' . substr_replace($customer['postal_code'], '-', 3, 0) . '<br>' ?>
                  </div>
                  <?= '&emsp;' . $customer['address'] . '<br>' . '&emsp;' . $customer['house_num'] ?>
                </div>
                <div class="col-md-2">
                  <?= $customer['telephone_num'] ?>
                </div>
              </div>
            </tbody>
          <?php } ?>
        </div>
        <?php require_once '../view_common/paging.php'; ?>
      <?php } ?>
    </div>
  </div>
</div>





<!-- 退会・再入会処理用jsファイル -->
<script src="../js/customer_index.js"></script>
<?php require_once '../view_common/footer.php'; ?>














<!-- 避難中 -->
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
      <li>
        <a class="dropdown-item" href="#">2022年</a>
      </li>
      <li>
        <a class="dropdown-item" href="#">2021年</a>
      </li>
      <li>
        <a class="dropdown-item" href="#">2020年</a>
      </li>
    </ul>
  </li> -->