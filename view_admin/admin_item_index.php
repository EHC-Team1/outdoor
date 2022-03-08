<?php
// セッションを宣言
session_start();

// 管理者としてログインしているかチェック
if (isset($_SESSION['admin'])) {
} else {
  header("Location: admin_login.php");
  die();
}

// ItemModelファイルを読み込み
require_once('../Model/ItemModel.php');

// 「削除」ボタンが押された場合
if (isset($_POST['delete'])) {
  // Itemクラスを呼び出し
  $pdo = new ItemModel();
  // deleteメソッドを呼び出し
  $item = $pdo->delete();
  // サクセスメッセージを$messageに格納
  $message = $item;

  // 押されていない状態
} else {
  $message = "";
}

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

// itemsテーブルから全データ件数を取得
$pdo = new ItemModel();
$pages = $pdo->page_count_admin_index();
$page_num = $pages->fetchColumn();
// ページネーションの数を取得
$pagination = ceil($page_num / 15);

// Itemクラスを呼び出し
$pdo = new ItemModel();
// admin_indexメソッドを呼び出し
$items = $pdo->admin_index($start);
// モデルからreturnしてきた情報をitemsに格納
$items = $items->fetchAll(PDO::FETCH_ASSOC);

$message = htmlspecialchars($message);
?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex justify-content-center mt-5">
    <div class="col-sm-10 d-flex flex-row-reverse">
      <button onclick="location.href='admin_order_index.php'" class="btn btn-outline-secondary btn-lg ms-5">注文履歴一覧</button>
      <button onclick="location.href='customer_index.php'" class="btn btn-outline-secondary btn-lg">ユーザー一覧</button>
    </div>
  </div>
  <h1 style="text-align:center" class="mt-3 mb-5">管理者トップ</h1>
  <div class="row d-flex justify-content-center">
    <div class="col-sm-10 d-flex justify-content-around">
      <button onclick="location.href='item_input.php'" class="btn btn-outline-primary btn-lg">商品追加</button>
      <button onclick="location.href='article_index.php'" class="btn btn-outline-info btn-lg">記事一覧</button>
      <button onclick="location.href='genre_index.php'" class="btn btn-outline-info btn-lg">ジャンル一覧</button>
    </div>
  </div>
  <h2 class="text-center my-5">商品一覧</h2>
  <div class="row d-flex justify-content-center">
    <div class="col-sm-10">
      <?= $message; ?>
      <table class="table">
        <tbody>
          <?php
          foreach ($items as $item) {
            $target = $item["item_image"]; ?>
            <tr>
              <td rowspan="2" class="align-middle col-sm-1">
                <form class="d-flex align-items-center justify-content-center mb-4">
                  <?php if ($item['is_status'] == 1) { ?>
                    <button type='button' class='btn btn-success' disabled>販売中</button>
                  <?php } else { ?>
                    <button type='button' class='btn btn-danger' disabled>販売停止</button>
                  <?php } ?>
                </form>
                <form method="post" class="d-flex align-items-center justify-content-center">
                  <input type="hidden" name="id" value="<?= $item['id'] ?>">
                  <button type="submit" name="delete" class="btn btn-outline-danger">削除</button>
                </form>
              </td>
              <td class="col-sm-3 text-center" rowspan="2">
                <a href=" ../view_admin/item_edit.php?item_id=<?= $item['id'] ?>" style="text-decoration:none">
                  <?php
                  if ($item["extension"] == "jpeg" || $item["extension"] == "png" || $item["extension"] == "gif") { ?>
                    <img src="../view_common/item_image.php?target=<?= $target ?>" alt="article_image" class="img-fluid">
                  <?php } ?>
                </a>
              </td>
              <td class="col-sm-6 align-middle">
                <a href=" ../view_admin/item_edit.php?item_id=<?= $item['id'] ?>" style="text-decoration:none">
                  <h4 style="color:black"><?= $item['item_name'] ?> / <?= $item['genre_name'] ?></h4>
                </a>
              </td>
            </tr>
            <tr>
              <td class="col-sm-6 align-middle">
                <a href=" ../view_admin/item_edit.php?item_id=<?= $item['id'] ?>" style="text-decoration:none">
                  <h4 style="color:black">￥<?= $item['price'] ?>円</h4>
                </a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php require_once '../view_common/paging.php'; ?>
</div>

<!-- バリデーション・アラート用jsファイル -->
<script src="../js/admin_item_index.js"></script>
<?php require_once '../view_common/footer.php'; ?>