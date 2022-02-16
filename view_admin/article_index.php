<?php
// セッションを宣言
session_start();

// // 管理者としてログインしているかチェック
// if (isset($_SESSION['admin'])) {
// } else {
//   header("Location: admin_login.php");
//   die();
// }

// ------------------ 表示件数制限 MOdelへ移動予定 ---------------
if (isset($_POTS['limit'])) {
  // 「10件」選択されたら場合
  if ($_POTS['limit'] === '5') {
    $limit = 5;
    // 「30件」選択されたら場合
  } elseif ($_POTS['limit'] === '10') {
    $limit = 10;
  }
}
// ------------------------------ 2022.02.16 ---------------------------------

// ArticleModelファイルを読み込み
require_once('../Model/ArticleModel.php');

// Customerクラスを呼び出し
$pdo = new ArticleModel();
// indexメソッドを呼び出し
$articles = $pdo->index();
// $message = "";

// $message = htmlspecialchars($message);
//
?>

<!-- ------------------------------ 表示画面 --------------------------------- -->

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <form method="post">
    <div class="row d-flex align-items-center justify-content-center mt-5">
    </div>
  </form>
  <div class="row d-flex justify-content-center">
    <div class="col-md-10 d-flex flex-row-reverse">
      <button onclick="location.href='admin_item_index.php'" class="btn btn-outline-secondary btn-lg mt-3">戻る</button>
    </div>
  </div>
  <h1 class="text-center mt-5 mb-5">記事一覧</h1>
  <div class="row d-flex align-items-center justify-content-center">
    <div class="col-md-10">

      <!-- 表示件数の制限 -->
      <form method="post">
        <select name="limit">
          <option value="">全件</option>
          <option value="5">5件</option>
          <option value="10">10件</option>
        </select>
      </form>

      <table class="table">
        <tbody>
          <tr bgcolor='#BCCDCF'>
            <th>タイトル</th>
            <th>投稿日時</th>
            <th>更新日時</th>
            <th></th>
            <th></th>
          </tr>
          <?php
          // 既存記事タイトルの出力処理を繰り返す
          foreach ($articles as $article) { ?>
            <tr>
              <?php echo "<h4>"; ?>
              <td><?= $article['title']; ?></td>
              <td><?= date('Y/m/d H:i:s', strtotime($article['created_at'])); ?></td>
              <td><?= date('Y/m/d H:i:s', strtotime($article['updated_at'])); ?></td>
              <?php echo "</h4>"; ?>
              <td>
                <form action="article_edit.php" method="post" class="d-flex align-items-center justify-content-center">
                  <input type="hidden" name="id" value="<?php echo $article['id'] ?>">
                  <button type="submit" name="edit" class="btn btn-outline-success">編集</button>
                </form>
              </td>
              <td>
                <form method="post" class="d-flex align-items-center justify-content-center">
                  <input type="hidden" name="id" value="<?php echo $article['id'] ?>">
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