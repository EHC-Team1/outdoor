<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <link rel="stylesheet" href="../css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <title>Outdoor</title>
</head>

<body>
  <header>
    <!-- ログイン状態か判別 -->
    <?php if (isset($_SESSION['admin'])) { ?>
      <!-- 管理者ログイン状態 -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand mb-0 h1 ms-5" href="../view_admin/admin_item_index.php">OUTDOOR</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            </ul>
            <button class="btn btn-outline-secondary ms-5 me-5" onclick="location.href='../view_admin/admin_login.php'">ログアウト</button>
            <button class="btn btn-outline-secondary me-5" onclick="location.href='../view_public/public_login.php'">ユーザーログインへ</button>
            <button class="btn btn-outline-secondary me-5" onclick="location.href='../view_public/top.php'">ユーザートップへ</button>
          </div>
        </div>
      </nav>
    <?php } elseif (isset($_SESSION['customer'])) { ?>
      <!-- ログイン状態 -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand mb-0 h1 ms-5" href="../view_public/top.php">OUTDOOR</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-lg-0">
            </ul>
            <h5 class="navbar-brand mb-0 ms-5"><?= $_SESSION['customer']['name_last'] ?>さん</h5>
            <button class="btn btn-outline-success ms-5 me-5" onclick="location.href='mypage.php'">マイページ</button>
            <button class="btn btn-outline-secondary me-5" onclick="location.href='public_logout.php'" type="submit" name="customer_logout" value="1">ログアウト</button>
            <button class="btn btn-outline-info me-5" onclick="location.href='cart_item_index.php'">カートを見る</button>
          </div>
        </div>
      </nav>
    <?php } else { ?>
      <!-- ゲスト状態 -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand mb-0 h1 ms-5" href="../view_public/top.php">OUTDOOR</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            </ul>
            <button class="btn btn-outline-primary ms-5 me-5" onclick="location.href='public_login.php'">ログイン</button>
            <button class="btn btn-outline-info me-5" onclick="location.href='public_signup.php'">サインアップ</button>
          </div>
        </div>
      </nav>
    <?php } ?>
  </header>


  <div id="splash">
    <div id="splash_text">
    </div>
  </div>

  <div id="container">
    <main>
      <div class="title1">
        <h2>Let's get another place.</h2>
        <h2 class="ms-5">外に出よう。風を感じよう。</h2>
        <div id="fadein1" class="fadein-before1 mt-5"></div>
      </div>
      <div class="title2">
        <h2 class="me-5">さあ、動き出そう。</h2>
        <h2>いつか行きたかったあの場所へ。</h2>
        <div id="fadein2" class="fadein-before2 mt-5"></div>
      </div>
      <div class="title3">
        <h2 class="ms-5">会社概要</h2>
        <div id="fadein3" class="fadein-before3 mt-5"></div>
      </div>
    </main>
  </div>



  <footer>
    <a href="../view_public/top.php" style="text-decoration:none">
      <span style="color:black; line-height: 40px;">TOP　</span>
    </a>
    <a href="../view_public/about.php" style="text-decoration:none">
      <span style="color:black; line-height: 40px;">　|　　ABOUT　　|　</span>
    </a>
    <a href="../view_public/public_item_index.php" style="text-decoration:none">
      <span style="color:black; line-height: 40px;">　商品一覧</span>
    </a>
  </footer>

  <!-- jQuery読み込み -->
  <script src='https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.5.0.js'></script>
  <!-- ProgressBar.js -->
  <script src="https://rawgit.com/kimmobrunfeldt/progressbar.js/master/dist/progressbar.min.js"></script>
  <script src="https://cdnjs.sloudflare.com/ajax/libs/babel-standalone/6.26.0/babel.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/6.26.0/polyfill.min.js"></script>
  <!-- jsファイル -->
  <script src="../js/about.js"></script>
  <!-- Bootstrap用js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>