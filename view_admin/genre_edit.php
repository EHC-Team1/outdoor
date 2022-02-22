<?php
// セッションを宣言
session_start();

// // 管理者としてログインしているかチェック
// if (isset($_SESSION['admin'])) {
// } else {
//   header("Location: admin_login.php");
//   die();
// }

// 「更新」ボタンが押された場合
if (isset($_POST['update_genre'])) {
  // Genreクラスを呼び出し
  $pdo = new GenreModel();
  // updateメソッドを呼び出し
  $genre = $pdo->update();

  // 「削除」ボタンが押された場合
} elseif (isset($_POST['delete'])) {
  // Genreクラスを呼び出し
  $pdo = new GenreModel();
  // deleteメソッドを呼び出し
  $genre = $pdo->delete();
  // サクセスメッセージを$messageに格納
  $message = $genre;

  // 押されていない状態
} else {
  $message = "";
}

// GenreModelファイルを呼び出し
require_once('../Model/GenreModel.php');
// Genreクラスを呼び出し
$pdo = new GenreModel();
// editメソッドを呼び出し
$genre = $pdo->edit();
// returnしてきた$genreを$genreに格納
$genre = $genre->fetch(PDO::FETCH_ASSOC);

// Genreクラスを呼び出し
$pdo = new GenreModel();
// indexメソッドを呼び出し
$genres = $pdo->index();

$message = htmlspecialchars($message);
?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <form method="post">
    <input type="hidden" name="id" value="<?php echo ($genre['id']); ?>">
    <div class="row d-flex align-items-center justify-content-center mt-5">
      <div class="col-sm-4">
        <h4 class="text-center">ジャンル名を編集</h4>
      </div>
      <div class=" col-sm-4">
        <input type="text" name="name" class="form-control" value="<?php echo ($genre['name']); ?>" id="genre_edit_input">
      </div>
      <div class="col-sm-3">
        <button type="submit" name="update_genre" class="btn btn-outline-success" id="genre_edit_btn">更新</button>
      </div>
    </div>
  </form>
  <h1 class="text-center mt-5 mb-5">ジャンル一覧</h1>
  <div class="row d-flex align-items-center justify-content-center">
    <div class="col-md-10">
      <?= $message; ?>
      <table class="table">
        <tbody>
          <?php
          foreach ($genres as $genre) { ?>
            <tr>
              <td>
                <?php
                echo "<h4>";
                echo ($genre['name']);
                echo "</h4>";
                ?>
              </td>
              <td>
                <form action="genre_edit.php" method="post" class="d-flex align-items-center justify-content-center">
                  <input type="hidden" name="id" value="<?php echo $genre['id'] ?>">
                  <button type="submit" name="edit" class="btn btn-outline-success">編集</button>
                </form>
              </td>
              <td>
                <form method="post" class="d-flex align-items-center justify-content-center">
                  <input type="hidden" name="id" value="<?php echo $genre['id'] ?>">
                  <button type="submit" name="delete" class="btn btn-outline-danger">削除</button>
                </form>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="row d-flex justify-content-center">
    <div class="col-md-10 d-flex flex-row-reverse">
      <button onclick="location.href='genre_index.php'" class="btn btn-outline-secondary btn-lg mt-3">戻る</button>
    </div>
  </div>

</div>

<!-- バリデーション用jsファイル -->
<script src="../js/genre_edit.js"></script>
<?php require_once '../view_common/footer.php'; ?>