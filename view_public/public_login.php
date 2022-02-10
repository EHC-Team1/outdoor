<?php require_once('../view_common/header.php'); ?>

<h1>会員ログイン</h1>
<h4>商品のご購入の際は、ログインが必要です。</h4>

<form method="post" action="">

  <!-- 名前入力 -->
  <label for="name">Name</label>
  <input id="name" type="text" placeholder="姓">
  <input id="name" type="text" placeholder="名"><br><br>

  <!-- パスワード入力 -->
  <label for="password">Password</label>
  <input id="password" type="password"><br><br>

  <!-- サインアップ画面へ -->
  <a href="public_signup.php">新規登録</a>

  <!-- ログインボタン -->
  <input type="submit" name="btn_submit" value="ログイン">

</form>

<?php require_once('../view_common/footer.php'); ?>