
入力途中 20220216 11:05


<?php
// セッションを宣言
session_start();

// // 管理者としてログインしているかチェック
// if (isset($_SESSION['admin'])) {
// } else {
//   header("Location: admin_login.php");
//   die();
// }

// CustomerModelファイルを読み込み
require_once('../Model/CustomerModel.php');

  // Genreクラスを呼び出し
  $pdo = new GenreModel();
  // indexメソッドを呼び出し
  $genres = $pdo->index();
  $message = "";

$message = htmlspecialchars($message);
?>

<?php require_once '../view_common/header.php'; ?>
<div class="container">
  <form method="post">
    <div class="row d-flex align-items-center justify-content-center mt-5">
      <div class="col-md-3">
        <h4 class="text-center">ジャンルを追加</h4>
      </div>
      <div class=" col-md-4">
        <input type="text" name="name" class="form-control" placeholder="ジャンル名">
      </div>
      <div class="col-md-3">
        <button type="submit" name="input_genre" class="btn btn-outline-primary">ジャンルを追加</button>
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
</div>


<?php require_once '../view_common/footer.php'; ?>