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
// var_dump(dirname(__FILE__));
// die();
require_once('../Model/GenreModel.php');
$pdo = new GenreModel();
// indexメソッドを呼び出し
$genres = $pdo->index();
?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row">
    <h1 class="text-center mt-5 mb-5">商品作成フォーム</h1>
    <form action="item_input.php" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label>商品名</label>
        <input type="text" name="name" class="form-control">
        <select class="form-select">
          <option selected>ジャンルを選択</option>
          <?php foreach ($genres as $genre) { ?>
            <option value="<?php echo ($genre['id']) ?>">
              <?php echo ($genre['name']) ?>
            </option>
          <?php } ?>
        </select>
        <label>商品説明</label>
        <textarea name="introduction" class="form-control" rows="7"></textarea>
        <label>税込価格</label>
        <input type="text" name="price" class="form-control">
        <label>販売ステータス</label>
        <input type="radio" class="btn-check" name="is_status" value="TRUE" checked>
        <label class="btn btn-outline-success">購入可能</label>
        <input type="radio" class="btn-check" name="is_status" value="FALSE">
        <label class="btn btn-outline-danger">販売停止</label>
        <input type="submit" class="btn btn-outline-success btn-lg" value="商品を追加する">
      </div>
    </form>
  </div>
</div>

<?php require_once '../view_common/footer.php'; ?>