<?php
// セッションを宣言
session_start();

// 管理者としてログインしているかチェック
if (isset($_SESSION['admin'])) {
} else {
  header("Location: admin_login.php");
  die();
}

if (isset($_GET["article_id"]) && $_GET["article_id"] !== "") {
  $article_id = $_GET["article_id"];
} else {
  return false;
}

// ArticleModelファイルを読み込み
require_once('../Model/ArticleModel.php');

//  Articleクラスを呼び出し
$pdo = new ArticleModel();
// editメソッドを呼び出し
$article = $pdo->edit($article_id);
// 取得データを配列に格納
$article = $article->fetch(PDO::FETCH_ASSOC);

// 「記事を更新する」ボタンが押された場合
if (isset($_POST['article_update'])) {
  // Articleクラスを呼び出し
  $pdo = new ArticleModel();
  // updateメソッド呼び出し
  $articles = $pdo->update();
  // エラーメッセージを$messageに格納
  $message = $articles;

  // 「削除」ボタンが押された場合
} elseif (isset($_POST['delete_article'])) {
  // Articleクラスを呼び出し
  $pdo = new ArticleModel();
  // deleteメソッドを呼び出し
  $item = $pdo->delete();
  // 管理者トップに遷移
  header('Location: ../view_admin/admin_item_index.php');
}

?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center my-5">記事編集フォーム</h1>
    <div class="col-sm-10">
      <form method="post" enctype="multipart/form-data">
        <div class="row mb-2">
          <label class="col-sm-2 col-form-label text-center">タイトル</label>
          <div class="col-sm-10">
            <input type="text" name="title" id="article_update_title" class="form-control" value="<?= ($article['title']) ?>">
          </div>
        </div>
        <div class="row mb-1">
          <label class="col-sm-2 col-form-label text-center">本文</label>
        </div>
        <div class="row mb-3">
          <div class="col">
            <textarea name="body" id="article_update_body" class="form-control" rows="7"><?= ($article['body']) ?></textarea>
          </div>
        </div>

        <!-- 保存中の画像がある場合 -->
        <?php $target = $article["article_image"];
        if ($article["article_image"]) { ?>
          <div class="row mb-2">
            <div class="col text-center">
              <?php if ($article["extension"] == "jpeg" || $article["extension"] == "png" || $article["extension"] == "gif") { ?>
                <img src="../view_common/article_image.php?target=<?= $target ?>" alt="article_image" class="img-fluid">
              <?php } ?>
            </div>
          </div>
          <div class="row mb-3 d-flex justify-content-center">
            <div class="col-sm-6 text-center">
              <input type="checkbox" class="btn-check" id="btncheck" name="delete_image" value="delete_image" autocomplete="off">
              <label class="btn btn-outline-secondary" for="btncheck">登録中の画像を削除する</label>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-sm-6 d-flex align-items-center">
              <input type="file" name="article_image" class="form-control" value="<?= $article['article_image'] ?>">
            </div>
            <label class="col-sm-6 col-form-label">
              ※画像を更新する場合は、ファイルを選択してください。<br>&emsp;容量の大きい画像はエラーになることがあります。
            </label>
          </div>

          <!-- 保存中の画像がない場合 -->
        <?php } else { ?>
          <div class="row mb-3">
            <div class="col-sm-6 d-flex align-items-center">
              <input type="file" name="article_image" class="form-control">
            </div>
            <label class="col-sm-6 col-form-label">
              ※画像を追加する場合は、ファイルを選択してください。<br>&emsp;容量の大きい画像はエラーになることがあります。
            </label>
          </div>
        <?php } ?>

        <div class="row mb-3 d-flex justify-content-evenly">
          <!-- 公開記事に設定されている場合 -->
          <?php if ($article["is_status"] == 1) { ?>
            <div class="col-sm-3 text-center">
              <input type="radio" class="btn-check" name="is_status" id="success-outlined" value="disclosure" autocomplete="off" checked>
              <label class="btn btn-outline-success" for="success-outlined">公開記事に設定中</label>
            </div>
            <div class="col-sm-3 text-center">
              <input type="radio" class="btn-check" name="is_status" id="danger-outlined" value="private" autocomplete="off">
              <label class="btn btn-outline-danger" for="danger-outlined">非公開に設定する</label>
            </div>
          <?php } ?>
          <!-- 非公開記事に設定されている場合 -->
          <?php if ($article["is_status"] == 0) { ?>
            <div class="col-sm-3 text-center">
              <input type="radio" class="btn-check" name="is_status" id="success-outlined" value="disclosure" autocomplete="off">
              <label class="btn btn-outline-success" for="success-outlined">公開記事に設定する</label>
            </div>
            <div class="col-sm-3 text-center">
              <input type="radio" class="btn-check" name="is_status" id="danger-outlined" value="private" autocomplete="off" checked>
              <label class="btn btn-outline-danger" for="danger-outlined">非公開記事に設定中</label>
            </div>
          <?php } ?>
        </div>
        <div class="d-flex align-items-center justify-content-center">
          <input type="hidden" name="id" value="<?= $article['id'] ?>">
          <button type="submit" name="article_update" class="btn btn-outline-success btn-lg" id="article_update_btn">記事を更新する</button>
        </div>
      </form>
    </div>
  </div>
  <div class="row d-flex justify-content-center mt-3 mb-5">
    <div class="col-sm-10 d-flex justify-content-evenly">
      <form method="POST">
        <input type="hidden" name="id" value="<?= $article['id'] ?>">
        <button type="submit" name="delete_article" class="btn btn-outline-danger btn-lg" id="delete_btn">削除する</button>
      </form>
      <button onclick="location.href='article_index.php'" class="btn btn-outline-secondary btn-lg">戻る</button>
    </div>
  </div>
</div>

<!-- 更新ボタンバリデーション用jsファイル -->
<script src="../js/article_edit.js"></script>
<?php require_once '../view_common/footer.php'; ?>