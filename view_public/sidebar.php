<?php
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

?>
<div class="row">
  <div class=" col-md-9">
    <input type="text" name="name" class="form-control" placeholder="search">
  </div>
  <div class="col-md-3">
    <button type="submit" name="" class="btn btn-outline-primary">検索</button>
  </div>
</div>

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
          <td>
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
          <td>
            <h6><?= $genre['name'] ?></h6>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>