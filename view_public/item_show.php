<?php
// セッションの宣言
session_start();

if (isset($_GET["item_id"]) && $_GET["item_id"] !== "") {
  $item_id = $_GET["item_id"];
} else {
  return false;
}

// ItemModelファイルを読み込み
require_once('../Model/ItemModel.php');
// Itemクラスを呼び出し
$pdo = new ItemModel();
// search_indexメソッドを呼び出し
$item = $pdo->show($item_id);
// returnしてきた$itemを$itemに格納
$item = $item->fetch(PDO::FETCH_ASSOC);

// 関連記事が公開状態であれば呼び出し
if ($item['article_is_status'] == 1) {
  $article_id = $item['article_id'];
  // ArticleModelファイルを読み込み
  require_once('../Model/ArticleModel.php');
  // Articleクラスを呼び出し
  $pdo = new ArticleModel();
  // item_articleメソッドを呼び出し
  $article_show = $pdo->item_article($article_id);
  // returnしてきた$articleを$articleに格納
  $article_show = $article_show->fetch(PDO::FETCH_ASSOC);

  // 非公開状態であれば記事なし
} else {
  $article_show['title'] = "";
  $article_show['body'] = "";
  $article_show['article_image'] = "";
  $article_show['extension'] = "";
  $article_show['updated_at'] = "";
}

// 「購入」ボタンが押された場合
if (isset($_POST['buy'])) {
  // // ログインしているかチェック
  if (isset($_SESSION['customer'])) {
    // ログインしている場合
    // CartItemModelファイルを読み込み
    require_once('../Model/CartItemModel.php');
    // CartItemクラスを呼び出し
    $pdo = new CartItemModel();
    // inputメソッドを呼び出し
    $cart_items = $pdo->input();
    // エラーメッセージを$messageに格納
    $message = $cart_items;

    // ログインしていない場合
  } else {
    // ログイン画面に遷移
    header("Location: ../view_public/public_login.php");
    die();
  }

  // 押されていない状態
} else {
  $message = '';
}
?>

<?php require_once '../view_common/header.php'; ?>
<div class="container">
  <div class="row d-flex justify-content-center align-items-start my-5">
    <div class="col-auto">
      <?php require_once '../view_public/sidebar.php'; ?>
    </div>
    <div class="col-sm-8 ms-3">
      <div class="row">
        <?php $target = $item["item_image"]; ?>
        <?php if ($item["item_extension"] == "jpeg" || $item["item_extension"] == "png" || $item["item_extension"] == "gif") { ?>
          <img src="../view_common/item_image.php?target=<?= $target ?>" alt="item_image" class="img-fluid">
        <?php } ?>
      </div>
      <div class="row mt-3">
        <h3 class="ms-3"><?= $item['item_name'] ?> / <?= $item['genre_name'] ?></h3>
      </div>
      <form method="POST" class="my-3">
        <input type="hidden" name="item_id" value="<?= $item['item_id'] ?>">
        <div class="row d-flex justify-content-center">
          <?= $message ?>
          <div class="col-sm-4 me-auto d-flex align-items-center">
            <h2 class="ms-3">￥<?= $item['price'] ?></h2>
          </div>
          <div class="col-sm-5">
            <select class="form-select form-select-lg" name="quantity">
              <option selected value="">数量</option>
              <?php for ($quantity = 1; $quantity <= 50; $quantity++) { ?>
                <option value="<?= $quantity ?>"><?= $quantity ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="col-auto d-flex flex-row-reverse">
            <button type="submit" name="buy" class="btn btn-outline-primary btn-lg">購入</button>
          </div>
        </div>
      </form>
      <div class="row my-5">
        <h6 class="text-center"><?= $item['introduction'] ?></h6>
      </div>
      <div class="row-cols-1 row-cols-md-1 g-3">
        <!-- 関連記事が公開状態の時に表示 -->
        <?php if ($item['article_is_status'] == 1) { ?>
          <h3>関連記事</h3>
          <div class='card' style='max-width: auto;'>
            <a href="../view_public/article_show.php?article_id=<?= $article_show["id"] ?>" class="text-dark" style="text-decoration:none">
              <div class="row g-0">
                <div class="col-lg-5 d-flex align-items-center">
                  <div class="card-body">
                    <?php $target = $article_show["article_image"]; ?>
                    <?php if ($article_show["extension"] == "jpeg" || $article_show["extension"] == "png" || $article_show["extension"] == "gif") { ?>
                      <img src="../view_common/article_image.php?target=<?= $target ?>" alt="article_image" class="img-fluid">
                    <?php } ?>
                  </div>
                </div>
                <div class="col-lg-7 d-flex align-items-center">
                  <div class="card-body">
                    <h5 class="card-title"><?= $article_show['title'] ?></h5>
                    <p class="card-text">
                      <?php
                      $article_show['body'];
                      if (mb_strlen($article_show['body']) > 100) {
                        $body_start = mb_substr($article_show['body'], 0, 100);
                        echo ($body_start . "・・・・");
                      } else {
                        echo ($article_show['body']);
                      }
                      ?>
                    </p>
                    <p class="card-text">
                      <small class="text-muted">
                        <?= $article_show['updated_at'] ?>
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
  </div>
</div>

<?php require_once '../view_common/footer.php'; ?>