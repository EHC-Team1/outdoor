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

// Itemクラスを呼び出し
$pdo = new ItemModel();

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

// indexメソッドを呼び出し
$items = $pdo->index($start);
// モデルからreturnしてきた情報をitemsに格納
$items = $items->fetchAll(PDO::FETCH_ASSOC);

$message = htmlspecialchars($message);
?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex justify-content-center">
    <div class="col-md-11 d-flex flex-row-reverse">
      <button onclick="location.href='customer_index.php'" class="btn btn-outline-secondary btn-lg mt-5">ユーザー一覧</button>
    </div>
  </div>
  <h1 style="text-align:center" class="mt-2 mb-5">管理者トップ</h1>
  <div class="row d-flex justify-content-center">
    <div class="col-md-11 d-flex justify-content-around">
      <button onclick="location.href='item_input.php'" class="btn btn-outline-primary btn-lg">商品追加</button>
      <button onclick="location.href='article_index.php'" class="btn btn-outline-info btn-lg">記事一覧</button>
      <button onclick="location.href='genre_index.php'" class="btn btn-outline-info btn-lg">ジャンル一覧</button>
    </div>
  </div>
  <h1 style="text-align:center" class="mt-5 mb-5">商品一覧</h1>
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
                <?php
                if ($item["extension"] == "jpeg" || $item["extension"] == "png" || $item["extension"] == "gif") {
                  echo ("<img src='../view_common/item_image.php?target=$target'width=200 height=200>");
                }
                ?>
              </td>
              <td class="co-sm-6 align-middle">
                <a href=" ../view_admin/item_edit.php?item_id=<?= $item['id'] ?>" style="text-decoration:none">
                  <h4 style="color:black"><?= $item['item_name'] ?> / <?= $item['genre_name'] ?></h4>
                </a>
              </td>
            </tr>
            <tr>
              <td class="col-sm-6 align-middle">
                <?php
                echo "<h4>￥";
                echo ($item['price']);
                echo "円</h4>"
                ?>
              </td>
            </tr>
          <?php }
          // itemsテーブルのデータ件数を取得
          $pdo = new ItemModel();
          $pages = $pdo->page_count();
          $page_num = $pages->fetchColumn();
          // ページネーションの数を取得
          $pagination = ceil($page_num / 15);
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="row d-flex align-items-center justify-content-center mt-3 mb-5">
    <div class="col-sm-10 d-flex align-items-center justify-content-center">
      <nav aria-label="Page navigation example">
        <ul class='pagination pagination-lg'>
          <?php for ($x = 1; $x <= $pagination; $x++) { ?>
            <li class='page-item'>
              <a class="page-link" href="?page=<?= $x ?>">
                <?= $x; ?>
              </a>
            </li>
          <?php } ?>
        </ul>
      </nav>
    </div>
  </div>
</div>

<!-- バリデーション・アラート用jsファイル -->
<script src="../js/admin_item_index.js"></script>
<?php require_once '../view_common/footer.php'; ?>