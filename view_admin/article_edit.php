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

//  Articleクラスを呼び出し
$pdo = new ArticleModel();
// editメソッドを呼び出し
$articles = $pdo->edit();
// 取得データを配列に格納
$articles = $articles->fetch(PDO::FETCH_ASSOC);

// 「記事を更新する」ボタンが押された場合
if (isset($_POST['article_update'])) {
  // Articleクラスを呼び出し
  $pdo = new ArticleModel();
  // updateメソッド呼び出し
  $articles = $pdo->update();
  // エラーメッセージを$messageに格納
  $message = $articles;
}

?>


<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center mt-5 mb-5">記事編集フォーム</h1>
    <div class="col-md-10">
      <form method="post" enctype="multipart/form-data">
        <div class="form-group">
          <div class="row">
            <div class="col mb-2 ms-3">
              <label>タイトル</label>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
              <input type="text" name="title" id="article_update_title" class="form-control" value="<?= ($articles['title']) ?>">
            </div>
          </div>
          <div class="row">
            <div class="col mb-2 ms-4">
              <label>本文</label>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
              <textarea name="body" id="article_update_body" class="form-control" rows="7"><?= ($articles['body']) ?></textarea>
            </div>
          </div>
        <!-- 保存中の画像がある場合 -->
        <?php if ($articles["article_image"]) : ?>
          <div class="row mb-3">
            <?php $target = $articles["article_image"]; ?>
            <label>
              <div class="col d-flex align-items-center justify-content-center text-center">
                <div class="row g-0">
                  <label>
                    <div class="col-md-4 mb-2">
                      <?php if ($articles["extension"] == "jpeg" || $articles["extension"] == "png" || $articles["extension"] == "gif") { ?>
                        <?php echo ("<img src='../view_common/article_image.php?target=$target'width=200 height=200>"); ?>
                      <?php } ?>
                    </div>
                    <input type="checkbox" class="btn-check" name="delete_image" value="delete_image" autocomplete="off">
                    <div class="btn btn-outline-secondary">登録中の画像を削除する</div>
                  </label>
                </div>
              </div>
            </label>
          </div>
          <div class="row">
            <div class="col mb-2">
              <input type="file" name="article_image" class="form-control" value="<?= ($articles['article_image']) ?>">
            </div>
          </div>
          <div class="row mb-3 ms-auto">
            <p> ※画像を更新する場合は、ファイルを選択してください。<br>&emsp;容量の大きい画像はエラーになることがあります。</p>
          </div>
        <?php endif ?>
        <!--  保存中の画像がない場合 -->
        <?php if ($articles["article_image"] == '') : ?>
          <div class="row">
            <div class="col mb-2">
              <input type="file" name="article_image" class="form-control" value="<?= ($articles['article_image']) ?>">
            </div>
          </div>
          <div class="row mb-3 ms-auto">
            <p> ※画像を追加する場合は、ファイルを選択してください。<br>&emsp;容量の大きい画像はエラーになることがあります。</p>
          </div>
        <?php endif ?>
        </div>
        <!-- 公開記事に設定されている場合 -->
        <?php if ($articles["is_status"] == 1) : ?>
          <div class="mb-3 d-flex align-items-center justify-content-evenly text-center">
            <label><input type="radio" class="btn-check" name="is_status" value="disclosure" id="article_update_is_status" checked>
              <div class="btn btn-outline-success">公開記事に設定中</div>
            </label>
            <label>
              <input type="radio" class="btn-check" name="is_status" value="private">
              <div class="btn btn-outline-danger">非公開に設定する</div>
            </label>
          </div>
        <?php endif ?>
        <!-- 非公開記事に設定されている場合 -->
        <?php if ($articles["is_status"] == 0) : ?>
          <div class="mb-3 d-flex align-items-center justify-content-evenly text-center">
            <label><input type="radio" class="btn-check" name="is_status" value="disclosure" id="article_update_is_status">
              <div class="btn btn-outline-success">公開記事に設定する</div>
            </label>
            <label>
              <input type="radio" class="btn-check" name="is_status" value="private" checked>
              <div class="btn btn-outline-danger">非公開記事に設定中</div>
            </label>
          </div>
        <?php endif ?>
        <div class="d-flex align-items-center justify-content-center">
          <input type="hidden" name="id" value="<?= ($articles['id']) ?>">
          <button type="submit" name="article_update" class="btn btn-outline-success btn-lg" id="article_update_btn">記事を更新する</button>
        </div>
      </form>
      <div class="row d-flex justify-content-center">
        <div class="col-md-12 d-flex flex-row-reverse">
          <button onclick="location.href='article_index.php'" class="btn btn-outline-secondary btn-lg mt-3">戻る</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- 更新ボタンバリデーション用jsファイル -->
<script src="../js/article_edit.js"></script>
<?php require_once '../view_common/footer.php'; ?>