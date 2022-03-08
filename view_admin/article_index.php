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
  $article = $pdo->input();
  // エラーメッセージを$messageに格納
  $message = $article;

  // 「削除」ボタンが押された場合
} elseif (isset($_POST['delete'])) {
  // ArticleModelファイルを読み込み
  $pdo = new ArticleModel();
  // deleteメソッドを呼び出し
  $article = $pdo->delete();
  // サクセスメッセージを$messageに格納
  $message = $article;

  // 押されていない状態
} else {
  // SESSIONの値をクリア
  $_SESSION['article']['title'] = $_SESSION['article']['body'] = $_SESSION['article']['article_image'] = '';
  // エラーメッセージは空
  $message = "";
}

// 現在のページ数を取得
if (isset($_GET['page'])) {
  $page = (int)$_GET['page'];
} else {
  $page = 1;
}
// スタートのページを計算
if ($page > 1) {
  $start = ($page * 15) - 15;
} else {
  $start = 0;
}

// articlesテーブルから全データ件数を取得
$pdo = new ArticleModel();
$pages = $pdo->page_count_admin_index();
$page_num = $pages->fetchColumn();
// ページネーションの数を取得
$pagination = ceil($page_num / 15);

//  Articleクラスを呼び出し
$pdo = new ArticleModel();
// indexメソッドを呼び出し
$articles = $pdo->admin_index($start);
// モデルからreturnしてきた情報をarticlesに格納
$articles = $articles->fetchAll(PDO::FETCH_ASSOC);

$message = htmlspecialchars($message);
?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center my-5">記事作成フォーム</h1>
    <div class="col-sm-10">
      <?php if ($message) { ?>
        <div class="alert alert-danger text-center" role="alert">
          <?= $message; ?>
        </div>
      <?php } ?>
      <form method="post" enctype="multipart/form-data">
        <div class="row mb-2">
          <label class="col-sm-2 col-form-label text-center">タイトル</label>
          <div class="col-sm-10">
            <input type="text" name="title" class="form-control" value="<?= ($_SESSION['article']['title']) ?>" autofocus>
          </div>
        </div>
        <div class="row mb-1">
          <label class="col-sm-2 col-form-label text-center">本文</label>
        </div>
        <div class="row mb-3">
          <div class="col">
            <textarea name="body" class="form-control" rows="7"><?= ($_SESSION['article']['body']) ?></textarea>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-sm-6">
            <input type="file" name="article_image" class="form-control" id="formFile" value="<?= ($_SESSION['article']['article_image']) ?>">
          </div>
          <label class="col-sm-6 col-form-label">※容量の大きい画像はエラーになることがあります。</label>
        </div>
        <div class="row mb-3 d-flex justify-content-evenly">
          <div class="col-sm-6 text-center">
            <input type="radio" class="btn-check" name="is_status" id="success-outlined" value="disclosure" autocomplete="off">
            <label class="btn btn-outline-success" for="success-outlined">公開記事に設定する</label>
          </div>
          <div class="col-sm-6 text-center">
            <input type="radio" class="btn-check" id="danger-outlined" name="is_status" value="private" autocomplete="off" checked>
            <label class="btn btn-outline-danger" for="danger-outlined">非公開記事に設定する</label>
          </div>
        </div>
        <div class="d-flex align-items-center justify-content-center">
          <button type="submit" name="input_article" class="btn btn-outline-primary btn-lg">記事を追加する</button>
        </div>
      </form>
    </div>
    <div class="row d-flex justify-content-center">
      <div class="col-sm-10 d-flex flex-row-reverse">
        <button onclick="location.href='admin_item_index.php'" class="btn btn-outline-secondary btn-lg mt-3">戻る</button>
      </div>
    </div>
  </div>
  <h1 class="text-center my-4">記事一覧</h1>
  <div class="row d-flex justify-content-center">
    <div class="col-sm-10">
      <table class="table">
        <tbody>
          <?php
          foreach ($articles as $article) {
            $target = $article["article_image"]; ?>
            <tr>
              <td rowspan="2" class="align-middle col-sm-2 h-100">
                <form class="d-flex align-items-center justify-content-center mb-4">
                  <?php if ($article['is_status'] == 1) { ?>
                    <button type='button' class='btn btn-success' disabled>公開中</button>
                  <?php } else { ?>
                    <button type='button' class='btn btn-danger' disabled>非公開</button>
                  <?php } ?>
                </form>
                <form method="post" class="d-flex align-items-center justify-content-center">
                  <input type="hidden" name="id" value="<?= $article['id'] ?>">
                  <button type="submit" name="delete" class="btn btn-outline-danger">削除</button>
                </form>
              </td>
              <td class="col-sm-4 text-center" rowspan="2">
                <a href=" ../view_admin/article_edit.php?article_id=<?= $article['id'] ?>" style="text-decoration:none">
                  <?php if ($article["extension"] == "jpeg" || $article["extension"] == "png" || $article["extension"] == "gif") { ?>
                    <img src="../view_common/article_image.php?target=<?= $target ?>" alt="article_image" class="img-fluid" >
                    <!-- <img src="../view_common/article_image.php?target=<?= $target ?>" alt="article_image" class="ime-responsive" > -->
                    <?php } ?>
                </a>
              </td>
              <td class="co-sm-6 align-middle">
                <a href=" ../view_admin/article_edit.php?article_id=<?= $article['id'] ?>" style="text-decoration:none">
                  <h4 style="color:black"><?= $article['title'] ?></h4>
                </a>
              </td>
            </tr>
            <tr>
              <td class="co-sm-6 align-middle">
                <a href=" ../view_admin/article_edit.php?article_id=<?= $article['id'] ?>" style="text-decoration:none">
                  <?php
                  $body_start = mb_substr($article['body'], 0, 40);
                  if (mb_strlen($article['body']) > 40) { ?>
                    <p style="color:black">
                      <?= $body_start ?>・・・・
                    </p>
                  <?php } else { ?>
                    <p style="color:black">
                      <?= $article['body'] ?>
                    </p>
                  <?php } ?>
                  <p class="text-end" style="color:black">更新日：<?= date('Y/m/d H:i:s', strtotime($article['updated_at'])); ?></p>
                </a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php require_once '../view_common/paging.php'; ?>
</div>

<!-- 削除ボタンバリデーション用jsファイル -->
<script src="../js/article_index.js"></script>
<?php require_once '../view_common/footer.php'; ?>
