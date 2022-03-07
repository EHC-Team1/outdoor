<?php
// セッションの宣言
session_start();

// 管理者としてログインしているかチェック
if (isset($_SESSION['admin'])) {
} else {
  header("Location: admin_login.php");
  die();
}

if (isset($_GET["genre_id"]) && $_GET["genre_id"] !== "") {
  $genre_id = $_GET["genre_id"];
} else {
  return false;
}

// 該当ジャンル商品一覧表示
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
  $start = ($page * 16) - 16;
} else {
  $start = 0;
}

// itemsテーブルから該当ジャンルのデータ件数を取得
$pdo = new ItemModel();
$pages = $pdo->page_count_admin_genre_index($genre_id);
$page_num = $pages->fetchColumn();
// ページネーションの数を取得
$pagination = ceil($page_num / 16);

// Itemクラスを呼び出し
$pdo = new ItemModel();
// genre_indexメソッドを呼び出し
$items = $pdo->admin_genre_index($genre_id, $start);
// returnしてきた$itemsを$itemsに格納
$items = $items->fetchAll(PDO::FETCH_ASSOC);

// ジャンル名の参照
// GenreModelファイルを読み込み
require_once('../Model/GenreModel.php');
// Genreクラスを呼び出し
$pdo = new GenreModel();
// showメソッドを呼び出し
$selected_genre = $pdo->show($genre_id);
// モデルからreturnしてきた情報をselected_genreに格納
$selected_genre = $selected_genre->fetch(PDO::FETCH_ASSOC);

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
  <a href="../view_admin/admin_item_index.php" style="text-decoration:none">
    <h1 style="color:black" class="text-center mt-3 mb-5">管理者トップ</h1>
  </a>
  <div class="row d-flex justify-content-center">
    <div class="col-md-11 d-flex justify-content-around">
      <button onclick="location.href='item_input.php'" class="btn btn-outline-primary btn-lg">商品追加</button>
      <button onclick="location.href='article_index.php'" class="btn btn-outline-info btn-lg">記事一覧</button>
      <button onclick="location.href='genre_index.php'" class="btn btn-outline-info btn-lg">ジャンル一覧</button>
    </div>
  </div>
  <h2 class="text-center my-5">商品一覧 / <?= $selected_genre['name'] ?></h2>
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
                  <h4 style="color:black"><?= $item['name'] ?></h4>
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

<?php require_once '../view_common/footer.php'; ?>