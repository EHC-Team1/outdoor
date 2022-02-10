<?php
// // 管理者としてログインしているかチェック
// if (isset($_SESSION['admin'])) {
// } else {
//   header("Location: admin_login.php");
//   die();
// }

// GenreModelファイルを呼び出し
require_once('../Model/GenreModel.php');
// Genreクラスを呼び出し
$pdo = new GenreModel();
// editメソッドを呼び出し
$genre = $pdo->edit();
$genre = $genre->fetch(PDO::FETCH_ASSOC);

// 「更新」ボタンが押された場合
if (isset($_POST['update_genre'])) {
  // Genreクラスを呼び出し
  $pdo = new GenreModel();
  // updateメソッドを呼び出し
  $genre = $pdo->update();
}
?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <form method="post">
    <input type="hidden" name="id" value="<?php echo ($genre['id']); ?>">
    <div class="row d-flex align-items-center justify-content-center mt-5">
      <div class="col-md-5">
        <h1 class="text-center">ジャンル編集フォーム</h1>
      </div>
      <div class=" col-md-4">
        <input type="text" name="name" class="form-control" value="<?php echo ($genre['name']); ?>" id="genre_edit_input">
      </div>
      <div class="col-md-2">
        <button type="submit" name="update_genre" class="btn btn-outline-success btn-lg" id="genre_edit_btn">更新</button>
      </div>
    </div>
  </form>
</div>
<!-- バリデーション用jsファイル -->
<script src="../js/genre_edit.js"></script>
<?php require_once '../view_common/footer.php'; ?>