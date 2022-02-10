<!-- ------------------------------ 表示画面 --------------------------------- -->

<?php require_once '../view_common/header.php'; ?>

<h1>会員登録が完了しました。</h1>
<h4>さっそくログインをして、お買い物を楽しんで下さいね！</h4>

<form method="post" action="public_login.php">

  <!-- TOPページへボタン → TOP画面へ -->
  <!-- <form method="post" action="top.php">
    <input type="submit" name="btn_submit" value="TOPページへ">
  </form> -->

  <!-- ログイン画面へボタン → ログイン画面へ -->
  <input type="submit" name="btn_submit" value="ログイン画面へ">


</form>
<?php require_once('../view_common/footer.php'); ?>