<?php
// セッションの宣言
session_start();

// 検索が実行されていなけばトップへリダイレクト
if ($_POST['flexRadioDefault']) {

  // 検索ワードが入力されているかチェック
  if ($_POST['keyword']) {
    // セッションに値を挿入
    $_SESSION['search'] = $_POST['keyword'];

    // Itemが選択された場合
    if ($_POST['flexRadioDefault'] == 1) {
      // ItemModelファイルを読み込み
      require_once('../Model/ItemModel.php');
      // Itemクラスを呼び出し
      $pdo = new ItemModel();
      // search_indexメソッドを呼び出し
      $search_items = $pdo->search_index();
    }

    // Articleが選択された場合
    if ($_POST['flexRadioDefault'] == 2) {
      // ArticleModelファイルを読み込み
      require_once('../Model/ArticleModel.php');
      // Articleクラスを呼び出し
      $pdo = new ArticleModel();
      // search_indexメソッドを呼び出し
      $search_articles = $pdo->search_index();
    }

    // 検索ワードが入力されていない場合
  } else {
    header('Location: ../view_public/top.php');
  }
} else {
  header('Location: ../view_public/top.php');
}
?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex justify-content-center align-items-start mt-5">
    <div class="col-auto">
      <?php require_once '../view_public/sidebar.php'; ?>
    </div>

    <!-- itemが検索された場合 -->
    <?php if ($_POST['flexRadioDefault'] == 1) { ?>
      <div class="col-sm-8 ms-3">
        <h3>TOP/<?= $_SESSION['search'] ?></h3>
        <div class="row">
          <?php foreach ($search_items as $item) {
            $target = $item["item_image"]; ?>
            <div class="col-lg-6">
              <div class="card text-white bg-dark mb-3">
                <a href="../view_public/item_show.php?item_id=<?= $item["item_id"] ?>" class="text-white" style="text-decoration:none">
                  <?php if ($item["extension"] == "jpeg" || $item["extension"] == "png" || $item["extension"] == "gif") { ?>
                    <img src="../view_common/item_image.php?target=<?= $target ?>" alt="search_item_image" class="card-img-top img-fluid">
                  <?php } ?>
                  <div class="card-body">
                    <h4 class="card-title"><?= $item['item_name'] ?> / <?= $item['genre_name'] ?></h4>
                    <h4 class="card-title">￥<?= $item['price'] ?></h4>
                  </div>
                </a>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    <?php } ?>

    <!-- articleが検索された場合 -->
    <?php if ($_POST['flexRadioDefault'] == 2) { ?>
      <div class="col-sm-8 ms-3">
        <h3>TOP/<?= $_SESSION['search'] ?></h3>
        <div class="row-cols-1 row-cols-md-1 g-3">
          <?php foreach ($search_articles as $article) {
            $target = $article["article_image"]; ?>
            <div class="card mb-2" style="max-width: auto;">
              <a href="../view_public/article_show.php?article_id=<?= $article["id"] ?>" class="text-dark" style="text-decoration:none">
                <div class="row g-0">
                  <div class="col-lg-5 d-flex align-items-center">
                    <div class="card-body">
                      <?php if ($article["extension"] == "jpeg" || $article["extension"] == "png" || $article["extension"] == "gif") { ?>
                        <img src="../view_common/article_image.php?target=<?= $target ?>" alt="article_image" class="img-fluid">
                      <?php } ?>
                    </div>
                  </div>
                  <div class="col-lg-7 d-flex align-items-center">
                    <div class="card-body">
                      <h5 class="card-title"><?= $article['title'] ?></h5>
                      <p class="card-text">
                        <?php
                        $article['body'];
                        if (mb_strlen($article['body']) > 100) {
                          $body_start = mb_substr($article['body'], 0, 100);
                          echo ($body_start . "・・・・");
                        } else {
                          echo ($article['body']);
                        }
                        ?>
                      </p>
                      <p class="card-text">
                        <small class="text-muted">
                          <?= $article['updated_at'] ?>
                        </small>
                      </p>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          <?php } ?>
        </div>
      </div>
    <?php } ?>
  </div>
</div>

<?php require_once '../view_common/footer.php'; ?>