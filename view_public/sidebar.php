<?php
// セッションを宣言
session_start();

// 「検索」ボタンが押された場合
if (isset($_POST['search'])) {
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
      // Articleクラスを呼び出し
      $pdo = new ArticleModel();
      // search_indexメソッドを呼び出し
      $search_articles = $pdo->search_index();
    }

    // ArticleModelファイルを読み込み
    require_once('../Model/ArticleModel.php');
    // Articleクラスを呼び出し
    $pdo = new ArticleModel();
    // indexメソッドを呼び出し
    $articles = $pdo->index();
    // モデルからreturnしてきた情報をarticlesに格納
    $articles = $articles->fetchAll(PDO::FETCH_ASSOC);

    // GenreModelファイルを読み込み
    require_once('../Model/GenreModel.php');
    // Genreクラスを呼び出し
    $pdo = new GenreModel();
    // indexメソッドを呼び出し
    $genres = $pdo->index();
    // モデルからreturnしてきた情報をgenresに格納
    $genres = $genres->fetchAll(PDO::FETCH_ASSOC);

    // 検索ワードが入力されていない場合
  } else {
    header('Location: ../view_public/top.php');
  }

  // 押されていない状態
} else {
  // ArticleModelファイルを読み込み
  require_once('../Model/ArticleModel.php');
  // Articleクラスを呼び出し
  $pdo = new ArticleModel();
  // indexメソッドを呼び出し
  $articles = $pdo->index();
  // モデルからreturnしてきた情報をarticlesに格納
  $articles = $articles->fetchAll(PDO::FETCH_ASSOC);

  // GenreModelファイルを読み込み
  require_once('../Model/GenreModel.php');
  // Genreクラスを呼び出し
  $pdo = new GenreModel();
  // indexメソッドを呼び出し
  $genres = $pdo->index();
  // モデルからreturnしてきた情報をgenresに格納
  $genres = $genres->fetchAll(PDO::FETCH_ASSOC);
  // セッションを初期化
  $_SESSION['search'] = "";
}
?>

<form action="public_item_index.php" method="POST">
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value=1 checked>
    <label class="form-check-label" for="flexRadioDefault1">
      商品検索
    </label>
  </div>
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value=2>
    <label class="form-check-label" for="flexRadioDefault2">
      記事検索
    </label>
  </div>
  <div class="row g-3">
    <div class=" col-auto">
      <input type="text" name="keyword" class="form-control" placeholder="キーワード" value="<?= $_SESSION['search'] ?>">
    </div>
    <div class="col-auto">
      <button type="submit" name="search" class="btn btn-outline-primary">検索</button>
    </div>
  </div>
</form>

<div class="row d-flex align-items-center justify-content-center mt-3">
  <table class="table">
    <thead class="table-secondary">
      <tr>
        <th>
          <h5 class="text-center">コラム一覧</h5>
        </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($articles as $article) { ?>
        <tr>
          <td class="text-center">
            <h6><?= $article['title'] ?></h6>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<div class="row d-flex align-items-center justify-content-center mt-3">
  <table class="table">
    <thead class="table-secondary">
      <tr>
        <th>
          <h5 class="text-center">商品ジャンル</h5>
        </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($genres as $genre) { ?>
        <tr>
          <td class="text-center">
            <h5><?= $genre['name'] ?></h5>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>