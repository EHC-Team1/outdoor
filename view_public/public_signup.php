<?php

// 使用する変数の初期化
$message_array = array();

// 確認ボタンでデータが送信された場合
if (!empty($POST['confirmation_submit'])) {


  // 入力値を変数に代入　(ここで空白除去しながら代入する？)
  // ( $name_last = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['name_last']); )
  $name_last = $POST_['name_last'];
  $name_first = $POST_['name_first'];
  $mail = $POST_['email'];
  $postal_code = $POST_['postal_code'];
  $address = $POST_['address'];
  $telephone_num = $POST_['telephone_num'];
  $password = $POST_['password'];

  // 入力チェック開始
  // 苗字
  if (empty($name_last)) {
    $error_message[] = '姓を入力して下さい。';

    // 文字数を制限　→　いる？？
    // } else {
    //   if (20 < md_strlen($name_last,'UTF-8')) {
    //     $error_message[] = '姓は20文字以内で、入力して下さい。';
    //   }
  }

  // 名前
  if (empty($name_first)) {
    $error_message[] = '名を入力して下さい。';
  }

  // メール
  if (empty($email)) {
    $error_message[] = 'メールアドレスを入力して下さい。';
  }

  // 郵便番号
  if (empty($postal_code)) {
    $error_message[] = '郵便番号を入力して下さい。';
  }

  // 住所
  if (empty($address)) {
    $error_message[] = '住所を入力して下さい。';
  }

  // 電話番号
  if (empty($address)) {
    $error_message[] = '電話番号を入力して下さい。';
  }

  // パスワード
  if (empty($password)) {
    $error_message[] = 'パスワードを入力して下さい。';

    // 文字数を確認 0-9の桁の数字4文字以外はエラーで返す
  } else {
    if (!preg_match("/^[0-9]{4}+$/", $password)) {
      $error_message[] = 'パスワードは、数字4文字で入力して下さい。';
    }
  }
}

// 必須項目に入力漏れがない場合
// if (empty($error_message)) {
//   header('Location: ./');
//   exit;  // 処理終了
// }
?>



<!-- ------------------------------ 表示画面 --------------------------------- -->

<?php require_once '../view_common/header.php'; ?>

<h1>新規会員登録</h1>
<h4>下記項目を入力して、確認ボタンを押して下さい。</h4>

<?php

if (!empty($error_message)) : ?>
  <ul class="error_message">

    <!-- 該当エラーメッセージを全て表示する -->
    <?php foreach ($error_message as $value) : ?>
      <li>・<?php echo $value; ?></li>
    <?php endforeach; ?>

  </ul>

<?php endif; ?>

<form method="post" action="">

  <!-- 名前入力 -->
  <label for="name">Name</label>
  <input id="name" type="text" name="name_last" placeholder="姓" value="<?php if (!empty($name_last)) {
                                                                          // エラーになっても入力値はそのまま表示
                                                                          htmlspecialchars($name_last, ENT_QUOTES, 'UTF-8');
                                                                        } ?>">

  <input id="name" type="text" name="name_first" placeholder="名"><br><br>

  <!-- メールアドレス入力 -->
  <label for="email">E-mail</label>
  <input id="email" type="text" name="email"><br><br>

  <!-- 郵便番号入力 -->
  <label for="postal_code">Postal Code</label>
  <input id="postal_code" type="number" name="postal_code"><br><br>

  <!-- 住所入力 -->
  <label for="address">Address</label>
  <input id="address" type="text" name="address"><br><br>

  <!-- 電話番号入力 -->
  <label for="telephone_num">Tell</label>
  <input id="telephone_num" type="number" name="telephone_num"><br><br>

  <!-- パスワード入力 -->
  <label for="password">Password</label>
  <input id="password" type="password" name="password"><br><br>



  <!-- キャンセルボタン → ログイン画面へ-->
  <a href="public_login.php">キャンセル</a>

  <!-- 入力チェックを通って、問題なければ入力確認画面へ -->
  <input type="submit" name="confirmation_submit" value="確認">


</form>
<?php require_once('../view_common/footer.php'); ?>