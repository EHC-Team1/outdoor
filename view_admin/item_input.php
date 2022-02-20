<?php
// セッションを宣言
session_start();

// // 管理者としてログインしているかチェック
// if (isset($_SESSION['admin'])) {
// } else {
//   header("Location: admin_login.php");
//   die();
// }

// 「商品追加」ボタンが押された場合
if (isset($_POST['input_item'])) {
  // POSTデータをSESSIONに格納
  $_SESSION['item'] = [
    'name' => htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8'), 'introduction' => htmlspecialchars($_POST['introduction'], ENT_QUOTES, 'UTF-8'), 'item_image' => $_FILES['item_image'], 'price' => $_POST['price']
  ];
  // ItemModelファイルを読み込み
  require_once('../Model/ItemModel.php');
  // Itemクラスを呼び出し
  $pdo = new ItemModel();
  // inputメソッドを呼び出し
  $item = $pdo->input();
  // エラーメッセージを$messageに格納
  $message = $item;

  // 押されていない状態
} else {
  // セッションの値をクリア
  $_SESSION['item']['name'] = $_SESSION['item']['introduction'] = $_SESSION['item']['item_image'] = $_SESSION['item']['price'] = "";
  // エラーメッセージは空
  $message = "";
}

// GenreModelファイルを読み込み
require_once('../Model/GenreModel.php');
// Genreクラスを呼び出し
$pdo = new GenreModel();
// indexメソッドを呼び出し
$genres = $pdo->index();

// ArticleModelファイルを読み込み
require_once('../Model/ArticleModel.php');
// Articleクラスを呼び出し
$pdo = new ArticleModel();
// indexメソッドを呼び出し
$articles = $pdo->index();

$message = htmlspecialchars($message);
?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center mt-5 mb-5">商品作成フォーム</h1>
    <div class="col-md-10">
      <?= $message; ?>
      <form action="item_input.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label>商品名</label>
          <input type="text" name="name" class="form-control" value="<?= ($_SESSION['item']['name']) ?>">
          <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">商品名</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="staticEmail" value="<?= ($_SESSION['item']['name']) ?>">
            </div>
          </div>

          <select name="genre_id" class="form-select">
            <option selected value="">ジャンルを選択</option>
            <?php foreach ($genres as $genre) { ?>
              <option value="<?php echo ($genre['id']) ?>">
                <?php echo ($genre['name']) ?>
              </option>
            <?php } ?>
          </select>

          <select name="article_id" class="form-select">
            <option selected value="">関連記事</option>
            <?php foreach ($articles as $article) { ?>
              <option value="<?php echo ($article['id']) ?>">
                <?php echo ($article['title']) ?>
              </option>
            <?php } ?>
          </select>

          <label>商品説明</label>
          <textarea name="introduction" class="form-control" rows="7"><?= ($_SESSION['item']['introduction']) ?></textarea>
          <label>税込価格</label>
          <input type="text" name="price" class="form-control" value="<?= ($_SESSION['item']['price']) ?>">
          <label>販売ステータス</label>
          <input type="radio" class="btn-check" name="is_status" value="buy_able">
          <label class="btn btn-outline-success">購入可能</label>
          <input type="radio" class="btn-check" name="is_status" value="buy_unable">
          <label class="btn btn-outline-danger">販売停止</label>
          <div class="mt-3 mb-3">
            <label for="formFile" class="form-label">※容量の大きい画像はエラーになることがあります。</label>
            <input class="form-control" type="file" id="formFile" name="item_image" value="<?= ($_SESSION['item']['item_image']) ?>">
          </div>
          <div class="d-flex align-items-center justify-content-center">
            <button type="submit" name="input_item" class="btn btn-outline-success btn-lg">商品を追加する</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="row d-flex justify-content-center">
    <div class="col-md-10 d-flex flex-row-reverse">
      <button onclick="location.href='admin_item_index.php'" class="btn btn-outline-secondary btn-lg mt-3">戻る</button>
    </div>
  </div>
</div>

<?php require_once '../view_common/footer.php'; ?>