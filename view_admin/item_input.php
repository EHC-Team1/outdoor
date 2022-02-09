<?php
// セッションを宣言
session_start();

// // 管理者としてログインしているかチェック
// if (isset($_SESSION['admin'])) {
// } else {
//   header("Location: admin_login.php");
//   die();
// }

// Genreクラスを呼び出し
require_once('../Model/GenreModel.php');
$pdo = new GenreModel();
// indexメソッドを呼び出し
$genres = $pdo->index();

// Articleクラスを呼び出し
require_once('../Model/ArticleModel.php');
$pdo = new ArticleModel();
// indexメソッドを呼び出し
$articles = $pdo->index();

// 商品追加ボタンが押された場合
if (isset($_POST['input_item'])) {
  // Itemクラスを呼び出し
  require_once('../Model/ItemModel.php');
  $pdo = new ItemModel();
  // inputクラスを呼び出し
  $pdo = $pdo->input();
  // エラーメッセージを$messageに格納
  $message = $pdo;
}
$message = "";
?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center mt-5 mb-5">商品作成フォーム</h1>
    <div class="col-md-10">
      <?php $message = htmlspecialchars($message); ?>
      <form action="item_input.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label>商品名</label>
          <input type="text" name="name" class="form-control">
          <select name="genre_id" class="form-select">
            <option selected>ジャンルを選択</option>
            <?php foreach ($genres as $genre) { ?>
              <option value="<?php echo ($genre['id']) ?>">
                <?php echo ($genre['name']) ?>
              </option>
            <?php } ?>
          </select>
          <select name="article_id" class="form-select">
            <option selected>関連記事</option>
            <?php foreach ($articles as $article) { ?>
              <option value="<?php echo ($article['id']) ?>">
                <?php echo ($article['title']) ?>
              </option>
            <?php } ?>
          </select>
          <label>商品説明</label>
          <textarea name="introduction" class="form-control" rows="7"></textarea>
          <label>税込価格</label>
          <input type="text" name="price" class="form-control">
          <label>販売ステータス</label>
          <input type="radio" class="btn-check" name="is_status" value="buy_able" checked>
          <label class="btn btn-outline-success">購入可能</label>
          <input type="radio" class="btn-check" name="is_status" value="buy_unable">
          <label class="btn btn-outline-danger">販売停止</label>
          <div class="input-group mt-3 mb-3">
            <input type="file" name="image" class="form-control-file">
            <p>※容量の大きい画像はエラーになることがあります。</p>
          </div>
          <div class="d-flex align-items-center justify-content-center">
            <button type="submit" name="input_item" class="btn btn-outline-success btn-lg">商品を追加する</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once '../view_common/footer.php'; ?>