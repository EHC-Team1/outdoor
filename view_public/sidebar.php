<?php

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

  // 押されていない状態
} else {
  // セッションを初期化
  $_SESSION['search'] = "";
}

// ArticleModelファイルを読み込み
require_once('../Model/ArticleModel.php');
// Articleクラスを呼び出し
$pdo = new ArticleModel();
// indexメソッドを呼び出し
$articles = $pdo->sidebar_index();
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
?>

<form action="public_search_index.php" method="POST">
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
      <?php $i = 0;
      foreach ($articles as $article) {
        if ($i >= 3) {
          break;
        } ?>
        <tr>
          <td class="text-center">
            <a href="../view_public/article_show.php?article_id=<?= $article['id'] ?>" style="text-decoration:none">
              <h5 style="color:black"><?= $article['title'] ?></h5>
            </a>
          </td>
        </tr>
      <?php $i++;
      } ?>
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
            <a href="../view_public/genre_item_index.php?genre_id=<?= $genre['id'] ?>" style="text-decoration:none">
              <h5 style="color:black"><?= $genre['name'] ?></h5>
            </a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>