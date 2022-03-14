<?php
// セッションの宣言
session_start();

// ArticleModelファイルを読み込み
require_once('../Model/ArticleModel.php');

// 現在のページ数を取得
if (isset($_GET['page'])) {
  $page = (int)$_GET['page'];
} else {
  $page = 1;
}
// スタートのページを計算
if ($page > 1) {
  $start = ($page * 16) - 16;
} else {
  $start = 0;
}

// Articlesテーブルから該当ジャンルのデータ件数を取得
$pdo = new ArticleModel();
$pages = $pdo->page_count_public_index();
$page_num = $pages->fetchColumn();
// ページネーションの数を取得
$pagination = ceil($page_num / 16);

// Articleクラスを呼び出し
$pdo = new ArticleModel();
// indexメソッドを呼び出し
$top_articles = $pdo->public_index($start);
// モデルからreturnしてきた情報をarticlesに格納
$top_articles = $top_articles->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once '../view_common/header.php'; ?>

<?php
// IEからのアクセス判定 初めてブラウザを開いた時
if (empty($_SESSION['ie_access'])) {
  require_once('../view_common/ie_block.php');
  // IEからアクセスされた場合、アラート表示
  if ($browser == 'ie_access') {
?>
    <script>
      alert('お使いのブラウザは閲覧推奨環境ではありません。\nウェブサイトが正しく表示されない、動作しない等の現象が\n起こる場合がありますので、予めご了承ください。\nchromeまたはEdgeブラウザのご利用をおすすめいたします。');
    </script>
<?php
    // セッション中は、アラートが再表示されないように処理
    $_SESSION['ie_access'] = [$browser];
  }
} ?>

<div class="main-visual">
  <div class="slide1"></div>
  <div class="slide2"></div>
  <div class="slide3"></div>
  <div class="slide4"></div>
  <div class="slide5"></div>
</div>

<div class="container">
  <div class="row d-flex justify-content-center align-items-start my-5">
    <div class="col-auto">
      <?php require_once '../view_public/sidebar.php'; ?>
    </div>
    <div class="col-sm-8 ms-3">
      <div class="row-cols-1 row-cols-md-1 g-3">
        <!-- 公開状態の記事のみ表示 -->
        <?php foreach ($top_articles as $article_top) {
          $target = $article_top["article_image"]; ?>
          <div class="card mb-2" style="max-width: auto;">
            <a href="../view_public/article_show.php?article_id=<?= $article_top["id"] ?>" class="text-dark" style="text-decoration:none">
              <div class="row g-0">
                <div class="col-lg-5 d-flex align-items-center">
                  <div class="card-body">
                    <?php if ($article_top["extension"] == "jpeg" || $article_top["extension"] == "png" || $article_top["extension"] == "gif") { ?>
                      <img src="../view_common/article_image.php?target=<?= $target ?>" alt="article_image" class="img-fluid">
                    <?php } ?>
                  </div>
                </div>
                <div class="col-lg-7 d-flex align-items-center">
                  <div class="card-body">
                    <h5 class="card-title"><?= $article_top['title'] ?></h5>
                    <p class="card-text">
                      <?php
                      if (mb_strlen($article_top['body']) > 100) {
                        $body_start = mb_substr($article_top['body'], 0, 100);
                        echo ($body_start . "・・・・");
                      } else {
                        echo ($article_top['body']);
                      }
                      ?>
                    </p>
                    <p class="card-text"><small class="text-muted"><?= $article_top['updated_at'] ?></small></p>
                  </div>
                </div>
              </div>
            </a>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <?php require_once '../view_common/paging.php'; ?>
</div>

<?php require_once '../view_common/footer.php'; ?>