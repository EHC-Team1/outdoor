<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/bootstrap.css">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src='https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.5.0.js'></script>
  <link rel="stylesheet" href="../css/slick-theme.css" type="text/css">
  <link rel="stylesheet" href="../css/slick.css" type="text/css">
  <script type="text/javascript" src="http://code.jquery.com/jquery-3.1.0.min.js"></script>
  <script src="../js/slick.js" type="text/javascript"></script>
  <title>Outdoor</title>
</head>

<body>
  <header>
    <!-- ログイン状態か判別 -->
    <?php if (isset($_SESSION['customer'])) { ?>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="../view_public/top.php">OUTDOOR</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <form method="post" class="d-flex">
              <button type="submit" name="logout" class="btn btn-outline-secondary">ログアウト</button>
            </form>
            <button onclick="location.href='cart_item_index.php'" class="btn btn-outline-info">カートを見る</button>
          </div>
        </div>
      </nav>
    <?php } else { ?>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="../view_public/top.php">OUTDOOR</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-bs-target="#header_item" aria-controls="header_item" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="header_item">
            <ul class="navbar-nav">
              <button onclick="location.href='public_login.php'" class="btn btn-outline-primary">ログイン</button>
              <button onclick="location.href='public_signup.php'" class="btn btn-outline-info">カートを見る</button>
            </ul>
          </div>
        </div>
      </nav>
    <?php } ?>
  </header>