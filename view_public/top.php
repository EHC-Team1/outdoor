<?php
// ArticleModelファイルを読み込み
require_once('../Model/ArticleModel.php');
// Articleクラスを呼び出し
$pdo = new ArticleModel();
// indexメソッドを呼び出し
$articles = $pdo->index();
// モデルからreturnしてきた情報をitemsに格納
$articles = $articles->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
// require_once '../view_common/header.php';
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/bootstrap.css">
  <!-- BootstrapのJS読み込み -->
  <script src="../js/bootstrap.min.js"></script>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src='https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.5.0.js'></script>
  <!-- スライド用slick -->
  <link rel="stylesheet" href="../css/slick-theme.css" type="text/css">
  <link rel="stylesheet" href="../css/slick.css" type="text/css">
  <script type="text/javascript" src="http://code.jquery.com/jquery-3.1.0.min.js"></script>
  <script src="../js/slick.js" type="text/javascript"></script>
  <title>Outdoor</title>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="../view_public/top.php">OUTDOOR</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <button onclick="location.href='public_login.php'" class="btn btn-outline-primary nav-link">ログイン</button>
          </li>
          <li class="nav-item active">
            <button onclick="location.href='public_signup.php'" class="btn btn-outline-info nav-link">カートを見る</button>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="main-visual">
    <div class="slide1"></div>
    <div class="slide2"></div>
    <div class="slide3"></div>
    <div class="slide4"></div>
    <div class="slide5"></div>
  </div>

  <div class="container">
    <div class="row d-flex align-items-center justify-content-center">
      <div class="col-md-4">
        <?php require_once '../view_public/sidebar.php'; ?>
      </div>

      <div class="col-md-8">
        <table class="table">
          <tbody>
            <?php foreach ($articles as $article) {
              $target = $article["article_image"]; ?>
              <tr>
                <td rowspan="3">
                  <?php if ($article["extension"] == "jpeg" || $article["extension"] == "png" || $article["extension"] == "gif") { ?>
                    <img src="../view_common/article_image.php?target=<?= $target ?>" alt="article_image" width=200 height=200>
                  <?php } ?>
                </td>
                <td>
                  <h5><?= $article['title'] ?></h5>
                </td>
              </tr>
              <tr>
                <td>
                  <p><?= $article['body'] ?></p>
                </td>
              </tr>
              <tr>
                <p><small class="text-muted"><?= $article['updated_at'] ?></small></p>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- スライド用jsファイル -->
  <script src="../js/top.js"></script>
  <?php require_once '../view_common/footer.php'; ?>