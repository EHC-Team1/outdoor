<?php
// セッションを宣言
session_start();

// // 管理者としてログインしているかチェック
// if (isset($_SESSION['admin'])) {
// } else {
//   header("Location: admin_login.php");
//   die();
// }

// ItemModelファイルを読み込み
require_once('../Model/ItemModel.php');
// Itemクラスを呼び出し
$pdo = new ItemModel();
// indexメソッドを呼び出し
$items = $pdo->index();
// モデルからreturnしてきた情報をitemsに格納
$items = $items->fetchAll(PDO::FETCH_ASSOC);
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
  <div class="row">
    <div class="col-md-11">
      <table class="table">
        <tbody>
          <?php
          foreach ($items as $item) {
            $target = $item["item_image"]; ?>
            <tr>
              <td rowspan="2">
                <?php
                if ($item["extension"] == "jpeg" || $item["extension"] == "png" || $item["extension"] == "gif") {
                  echo ("<img src='../view_common/item_image.php?target=$target'width=200 height=200>");
                }
                ?>
              </td>
              <td>
                <?php
                echo "<h3><strong>";
                echo ($item['name']);
                echo "</strong></h3>"
                ?>
              </td>
              <td rowspan="2" class="align-middle">
                <form action="item_edit.php" method="post" class="d-flex align-items-center justify-content-center mb-4">
                  <input type="hidden" name="id" value="<?= $item['id'] ?>">
                  <button type="submit" name="edit" class="btn btn-outline-success">編集</button>
                </form>
                <form method="post" class="d-flex align-items-center justify-content-center">
                  <input type="hidden" name="id" value="<?= $item['id'] ?>">
                  <button type="submit" name="delete" class="btn btn-outline-danger">削除</button>
                </form>
              </td>
            </tr>
            <tr>
              <td>
                <?php
                echo "<h4>￥";
                echo ($item['price']);
                echo "円</h4>"
                ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>


<?php require_once '../view_common/footer.php'; ?>