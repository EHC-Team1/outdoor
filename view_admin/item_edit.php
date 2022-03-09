<?php
// セッションを宣言
session_start();

// 管理者としてログインしているかチェック
if (isset($_SESSION['admin'])) {
} else {
  header("Location: admin_login.php");
  die();
}

if (isset($_GET["item_id"]) && $_GET["item_id"] !== "") {
  $item_id = $_GET["item_id"];
} else {
  return false;
}

// ItemModelファイルを呼び出し
require_once('../Model/ItemModel.php');

// Itemクラスを呼び出し
$pdo = new ItemModel();
// editメソッドを呼び出し
$item = $pdo->edit($item_id);
// returnしてきた$itemを$itemに格納
$item = $item->fetch(PDO::FETCH_ASSOC);

// 「更新」ボタンが押された場合
if (isset($_POST['update_item'])) {
  // Itemクラスを呼び出し
  $pdo = new ItemModel();
  // updateメソッドを呼び出し
  $item = $pdo->update($item);

  // 「削除」ボタンが押された場合
} elseif (isset($_POST['delete_item'])) {
  // Itemクラスを呼び出し
  $pdo = new ItemModel();
  // deleteメソッドを呼び出し
  $item = $pdo->delete();
  // 管理者トップに遷移
  header('Location: ../view_admin/admin_item_index.php');
}

// Genre / Article選択肢用
// GenreModelファイルを読み込み
require_once('../Model/GenreModel.php');
// Genreクラスを呼び出し
$pdo = new GenreModel();
// indexメソッドを呼び出し
$genres = $pdo->index();
// ArticleModelファイルを読み込み
require_once('../Model/ArticleModel.php');
// Articleクラスを呼び出し
$pdo = new ArticleModel();
// indexメソッドを呼び出し
$articles = $pdo->admin_index();

?>

<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center mt-5">商品編集フォーム</h1>
    <div class="col-sm-10">
      <form method="post" enctype="multipart/form-data">
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label text-center">商品名</label>
          <div class="col-sm-10">
            <input type="text" name="name" class="form-control" value="<?= $item['item_name'] ?>" id="item_name">
          </div>
        </div>
        <div class="row g-3 mb-3">
          <div class="col">
            <select name="genre_id" class="form-select">
              <option selected value="<?= $item['genre_id'] ?>"><?= $item['genre_name'] ?></option>
              <?php foreach ($genres as $genre) { ?>
                <option value="<?= $genre['id'] ?>">
                  <?= $genre['name'] ?>
                </option>
              <?php } ?>
            </select>
          </div>
          <div class="col">
            <select name="article_id" class="form-select">
              <option selected value="<?= $item['article_id'] ?>"><?= $item['article_title'] ?></option>
              <?php foreach ($articles as $article) { ?>
                <option value="<?= $article['id'] ?>">
                  <?= $article['title'] ?>
                </option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="row mb-1">
          <label class="col-sm-2 col-form-label text-center">商品説明</label>
        </div>
        <div class="row mb-3">
          <div class="col">
            <textarea name="introduction" class="form-control" rows="7" id="item_introduction"><?= $item['introduction'] ?></textarea>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col text-center">
            <?php $target = $item["item_image"];
            if ($item["extension"] == "jpeg" || $item["extension"] == "png" || $item["extension"] == "gif") { ?>
              <img src="../view_common/item_image.php?target=<?= $target ?>" alt="item_image" class="img-fluid">
            <?php } ?>
          </div>
        </div>
        <div class="row mb-3 d-flex justify-content-center">
          <div class="col-sm-6 text-center">
            <input type="checkbox" class="btn-check" id="btncheck" name="delete_image" value="delete_image" autocomplete="off">
            <label class="btn btn-outline-secondary" for="btncheck">画像を削除</label>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <input class="form-control" type="file" id="formFile" name="item_image">
          </div>
          <label class="col-sm-2 col-form-label text-end">税込価格</label>
          <div class="col-sm-3">
            <input type="number" min="0" name="price" class="form-control" value="<?= $item['price'] ?>" id="item_price">
          </div>
          <label class="col-sm-1 col-form-label">円</label>
        </div>
        <div class="row mb-3">
          <label class="col-sm-6 col-form-label text-center">※容量の大きい画像はエラーになることがあります。</label>
        </div>
        <div class="row mb-3 d-flex justify-content-evenly">
          <!-- 販売可能状態に設定中 -->
          <?php if ($item['is_status'] == 1) { ?>
            <div class="col-sm-3 text-center">
              <input type="radio" class="btn-check" name="is_status" id="success-outlined" value="buy_able" autocomplete="off" checked>
              <label class="btn btn-outline-success" for="success-outlined">購入可能状態に設定中</label>
            </div>
            <div class="col-sm-3 text-center">
              <input type="radio" class="btn-check" name="is_status" id="danger-outlined" value="buy_unable" autocomplete="off">
              <label class="btn btn-outline-danger" for="danger-outlined">販売停止状態にする</label>
            </div>
            <!-- 販売停止状態に設定中 -->
          <?php } else { ?>
            <div class="col-sm-3 text-center">
              <input type="radio" class="btn-check" name="is_status" id="success-outlined" value="buy_able" autocomplete="off">
              <label class="btn btn-outline-success" for="success-outlined">購入可能状態にする</label>
            </div>
            <div class="col-sm-3 text-center">
              <input type="radio" class="btn-check" name="is_status" id="danger-outlined" value="buy_unable" autocomplete="off" checked>
              <label class="btn btn-outline-danger" for="danger-outlined">販売停止状態に設定中</label>
            </div>
          <?php } ?>
        </div>
        <div class="d-flex align-items-center justify-content-center">
          <button type="submit" name="update_item" class="btn btn-outline-success btn-lg" id="item_update_btn">商品を更新する</button>
        </div>
      </form>
    </div>
  </div>
  <div class="row d-flex justify-content-center mt-3 mb-5">
    <div class="col-sm-10 d-flex justify-content-evenly">
      <form method="POST">
        <input type="hidden" name="id" value="<?= $item['item_id'] ?>">
        <button type="submit" name="delete_item" class="btn btn-outline-danger btn-lg" id="delete_btn">削除する</button>
      </form>
      <button onclick="location.href='admin_item_index.php'" class="btn btn-outline-secondary btn-lg">戻る</button>
    </div>
  </div>
</div>

<!-- バリデーション・アラート用jsファイル -->
<script src="../js/item_edit.js"></script>
<?php require_once '../view_common/footer.php'; ?>
