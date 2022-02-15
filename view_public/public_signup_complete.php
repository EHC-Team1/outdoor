<?php require_once '../view_common/header.php'; ?>

<h1>会員登録が完了しました。</h1>
<h4>さっそくログインをして、お買い物を楽しんで下さいね！</h4>

<form method="post" action="top.php">
  <!-- TOPへ -->
  <button type="submit" name="top" class="btn btn-outline-success btn-lg">TOP画面へ</button>
</form>

<a href="public_signup.php">ログイン画面へ</a>

<?php require_once('../view_common/footer.php'); ?>