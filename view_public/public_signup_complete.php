<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <h1 class="text-center mt-5 mb-5">
    Welcome！</br>アカウントが作成されました
  </h1>
  <div class="row d-flex justify-content-around">
    <button onclick="location.href='top.php'" class="btn btn-outline-info btn-lg">TOP画面へ</button>
    <button onclick="location.href='public_login.php'" class="btn btn-outline-primary btn-lg">ログイン</button>
  </div>
</div>


<!-- <h1>会員登録が完了しました。</h1>
<h4>さっそくログインをして、お買い物を楽しんで下さいね！</h4>
<form method="post" action="top.php">
  <button type="submit" name="top" class="btn btn-outline-success btn-lg">TOP画面へ</button>
</form>
<a href="public_login.php">ログイン画面へ</a> -->

<?php require_once('../view_common/footer.php'); ?>