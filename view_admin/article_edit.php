<?php
// セッションを宣言
session_start();

// // 管理者としてログインしているかチェック
// if (isset($_SESSION['admin'])) {
// } else {
//   header("Location: admin_login.php");
//   die();
// }

// ArticleModelファイルを読み込み
require_once('../Model/ArticleModel.php');

//  Articleクラスを呼び出し
$pdo = new ArticleModel();
// editメソッドを呼び出し
$articles = $pdo->edit();
// 取得データを配列に格納
$articles = $articles->fetch(PDO::FETCH_ASSOC);

// ItemModelファイルを読み込み
require_once('../Model/ItemModel.php');
// Itemクラスを呼び出し
$pdo = new ItemModel();
// indexメソッド呼び出し
$items = $pdo->index();

// 「記事を更新する」ボタンが押された場合
if (isset($_POST['edit_article'])) {
  // Articleクラスを呼び出し
  $pdo = new ArticleModel();
  // updateメソッド呼び出し
  $articles = $pdo->update();
  // エラーメッセージを$messageに格納
  // $message = $articles;
}

?>
<!-- ------------------------------ 表示画面 --------------------------------- -->
<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center mt-5 mb-5">記事編集フォーム</h1>
    <div class="col-md-10">
      <!-- <?= $message; ?> -->
      <form method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label>タイトル</label>
          <input type="text" name="title" class="form-control" value="<?= ($articles['title']) ?>">
          <!-- <select name="article_id" class="form-select">
            <option selected value="">関連商品</option>
            <?php foreach ($items as $item) { ?>
              <option value="<?php echo ($item['id']) ?>">
                <?php echo ($item['name']) ?>
              </option>
            <?php } ?>
          </select> -->
          <label>本文</label>
          <textarea name="body" class="form-control" rows="7"><?= ($articles['body']) ?></textarea>
          <label>公開ステータス</label>
          <label><input type="radio" class="btn-check" name="is_status" value="disclosure">
            <div class="btn btn-outline-success">公開</div>
          </label>
          <label>
            <input type="radio" class="btn-check" name="is_status" value="private" checked>
            <div class="btn btn-outline-danger">非公開</div>
          </label>
          <div class="input-group mt-3 mb-3">
            <input type="file" name="article_image" class="form-control-file" value="<?= ($articles['article_image']) ?>">
            <p>※容量の大きい画像はエラーになることがあります。</p>
          </div>
          <div class="d-flex align-items-center justify-content-center">
            <input type="hidden" name="id" value="<?= ($articles['id']) ?>">
            <button type="submit" name="edit_article" class="btn btn-outline-success btn-lg">記事を更新する</button>
          </div>
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