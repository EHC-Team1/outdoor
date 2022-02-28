<?php
// セッションを宣言
session_start();

// 管理者としてログインしているかチェック
if (isset($_SESSION['admin'])) {
} else {
  header("Location: admin_login.php");
  die();
}

// ArticleModelファイルを読み込み
require_once('../Model/ArticleModel.php');

// 「記事追加」ボタンが押された場合
if (isset($_POST['input_article'])) {

  // POSTデータをSESSIONに格納
  $_SESSION['article'] = [
    'title' => htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8'),
    'body' => htmlspecialchars($_POST['body'], ENT_QUOTES, 'UTF-8'),
    'article_image' => $_FILES['article_image']
  ];
  // Articleクラスを呼び出し
  $pdo = new ArticleModel();
  // inputメソッド呼び出し
  $articles = $pdo->input();
  // エラーメッセージを$messageに格納
  $message = $articles;

  // 「削除」ボタンが押された場合
} elseif (isset($_POST['delete'])) {
  // ArticleModelファイルを読み込み
  $pdo = new ArticleModel();
  // deleteメソッドを呼び出し
  $articles = $pdo->delete();
  // サクセスメッセージを$messageに格納
  $message = $articles;

  //  Articleクラスを呼び出し
  $pdo = new ArticleModel();
  // indexメソッドを呼び出し 記事一覧を再取得
  $articles = $pdo->index();

  // 押されていない状態
} else {
  // SESSIONの値をクリア
  $_SESSION['article']['title'] = $_SESSION['article']['body'] = $_SESSION['article']['article_image'] = '';
  // エラーメッセージは空
  $message = "";
}

//  Articleクラスを呼び出し
$pdo = new ArticleModel();
// indexメソッドを呼び出し
$articles = $pdo->admin_index();

$message = htmlspecialchars($message);
?>
<!-- ------------------------------ 表示画面 --------------------------------- -->
<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center mt-5 mb-5">記事作成フォーム</h1>
    <div class="col-md-10">
      <?= $message; ?>
      <form method="post" enctype="multipart/form-data">
        <div class="form-group">
          <div class="row">
            <div class="col mb-2 ms-3">
              <label>タイトル</label>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
              <input type="text" name="title" class="form-control" value="<?= ($_SESSION['article']['title']) ?>" autofocus>
            </div>
          </div>
          <div class="row">
            <div class="col mb-2 ms-4">
              <label>本文</label>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
              <textarea name="body" class="form-control" rows="7"><?= ($_SESSION['article']['body']) ?></textarea>
            </div>
          </div>
          <div class="row">
            <div class="col mb-2">
              <!-- <div class="row mb-2 ms-auto"> -->
              <input type="file" name="article_image" class="form-control" value="<?= ($_SESSION['article']['article_image']) ?>">
            </div>
          </div>
          <div class="row mb-3 ms-auto">
            <p> ※容量の大きい画像はエラーになることがあります。</p>
          </div>
        </div>
        <div class="mb-3 d-flex align-items-center justify-content-evenly text-center">
          <label><input type="radio" class="btn-check" name="is_status" value="disclosure">
            <div class="btn btn-outline-success">公開記事に設定する</div>
          </label>
          <label>
            <input type="radio" class="btn-check" name="is_status" value="private" checked>
            <div class="btn btn-outline-danger">非公開記事に設定する</div>
        </div>
        <div class="d-flex align-items-center justify-content-center">
          <button type="submit" name="input_article" class="btn btn-outline-success btn-lg">記事を追加する</button>
        </div>
      </form>
      <div class="row d-flex justify-content-center">
        <div class="col-md-12 d-flex flex-row-reverse">
          <button onclick="location.href='admin_item_index.php'" class="btn btn-outline-secondary btn-lg mt-3">戻る</button>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container">
  <form method="post">
    <div class="row d-flex align-items-center justify-content-center mt-5">
    </div>
  </form>
  <h1 class="text-center mt-5 mb-5">記事一覧</h1>
  <div class="row d-flex align-items-center justify-content-center">
    <div class="col-md-10">
      <table class="table">
        <tbody>
          <tr bgcolor='#BCCDCF'>
            <th>タイトル</th>
            <th>本文</th>
            <th>画像</th>
            <th>更新日時</th>
            <th>公開ステータス</th>
            <th></th>
            <th></th>
          </tr>
          <?php
          foreach ($articles as $article) {
            $target = $article["article_image"];
          ?>
            <tr>
              <?php echo "<h4>"; ?>
              <td><?= $article['title']; ?></td>
              <td class="col-2"><?= nl2br($article['body']); ?></td>
              <td>
                <?php
                if ($article["extension"] == "jpeg" || $article["extension"] == "png" || $article["extension"] == "gif") {
                  echo ("<img src='../view_common/article_image.php?target=$target'width=200 height=200>");
                }
                ?>
              </td>
              <td><?= date('Y/m/d H:i:s', strtotime($article['updated_at'])); ?></td>
              <td><?php if ($article['is_status'] == 0) {
                    echo '非公開';
                  } else {
                    echo '' ?><?php } ?></td>
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
                  <button type="submit" name="delete" class="btn btn-outline-danger" id="article_delete_btn">削除</button>
                </form>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- 削除ボタンバリデーション用jsファイル -->
<script src="../js/article_index.js"></script>
<?php require_once '../view_common/footer.php'; ?>