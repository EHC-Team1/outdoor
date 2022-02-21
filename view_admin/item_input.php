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

// Genre / Article選択肢用
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
// $articles = $pdo->admin_index();

$message = htmlspecialchars($message);
?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center mt-5 mb-5">商品登録フォーム</h1>
    <div class="col-md-10">
      <?= $message; ?>
      <form action="item_input.php" method="post" enctype="multipart/form-data">
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label text-center">商品名</label>
          <div class="col-sm-10">
            <input type="text" name="name" class="form-control" value="<?= ($_SESSION['item']['name']) ?>">
          </div>
        </div>
        <div class="row g-3 mb-3">
          <div class="col">
            <select name="genre_id" class="form-select">
              <option selected value="">ジャンルを選択</option>
              <?php foreach ($genres as $genre) { ?>
                <option value="<?php echo ($genre['id']) ?>">
                  <?php echo ($genre['name']) ?>
                </option>
              <?php } ?>
            </select>
          </div>
          <div class="col">
            <select name="article_id" class="form-select">
              <option selected value="">関連記事</option>
              <?php foreach ($articles as $article) { ?>
                <option value="<?php echo ($article['id']) ?>">
                  <?php echo ($article['title']) ?>
                </option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="row mb-1">
          <label class="col-sm-2 col-form-label text-center">商品説明</label>
        </div>
        <div class="row mb-3">
          <div class="col">
            <textarea name="introduction" class="form-control" rows="7"><?= ($_SESSION['item']['introduction']) ?></textarea>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <input class="form-control" type="file" id="formFile" name="item_image" value="<?= ($_SESSION['item']['item_image']) ?>">
          </div>
          <label class="col-sm-2 col-form-label text-end">税込価格</label>
          <div class="col-sm-3">
            <input type="text" name="price" class="form-control" value="<?= ($_SESSION['item']['price']) ?>">
          </div>
          <label class="col-sm-1 col-form-label">円</label>
        </div>
        <div class="row mb-3">
          <label class="col-sm-6 col-form-label text-center">※容量の大きい画像はエラーになることがあります。</label>
        </div>
        <div class="row mb-3 d-flex justify-content-evenly">
          <div class="col-sm-2 text-center">
            <input type="radio" class="btn-check" name="is_status" id="success-outlined" value="buy_able" autocomplete="off" checked>
            <label class="btn btn-outline-success" for="success-outlined">購入可能状態</label>
          </div>
          <div class="col-sm-2 text-center">
            <input type="radio" class="btn-check" name="is_status" id="danger-outlined" value="buy_unable" autocomplete="off">
            <label class="btn btn-outline-danger" for="danger-outlined">販売停止状態</label>
          </div>
        </div>
        <div class="d-flex align-items-center justify-content-center">
          <button type="submit" name="input_item" class="btn btn-outline-success btn-lg">商品を追加する</button>
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