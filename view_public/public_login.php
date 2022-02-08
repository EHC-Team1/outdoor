<?php require_once('../view_common/header.php'); ?>

<h1>会員ログイン</h1>
<h4>商品のご購入の際は、ログインが必要です。</h4>

<form>

  <!-- 名前入力 -->
  <label for="name">お名前</label>
  <input id="name" type="text"><br><br>

  <!-- パスワード入力 -->
  <label for="password">パスワード</label>
  <input id="password" type="password"><br><br>

  <!-- ログインボタン -->
  <input type="submit" name="btn_submit" value="新規登録">
  <input type="submit" name="btn_submit" value="ログイン">

</form>

<?php require_once('../view_common/footer.php'); ?>