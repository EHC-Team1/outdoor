<?php

class CustomerModel
{
  protected $pdo;
  const USER = 'root';
  const PASS = 'password';
  const HOST = 'localhost';
  const NAME = 'outdoor';
  const DSN = 'mysql:host=localhost;dbname=outdoor;charset=utf8';

  public function __construct()
  {
    $this->db_connect();
  }
  // DBに接続
  public function db_connect()
  {
    try {
      $pdo = new PDO($this::DSN, $this::USER, $this::PASS);
      $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    } catch (PDOException $Exception) {
      die('接続エラー' . $Exception->getMessage());
    }
    return $pdo;
  }


  // 必須項目の入力チェック
  public function check()
  {
    //----------------------------------- 62～71行 if外に持ってきただけ --------------------------------------------
    // 空白除去(文頭・文末)して、変数に代入
    $name_last = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['name_last']);
    $name_first = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['name_first']);
    $email = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['email']);
    $postal_code = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['postal_code']);
    $address = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['address']);
    $telephone_num = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['telephone_num']);
    $password = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['password']);
    // パスワード(確認)時間あれば
    // $password2 = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['password2']);

    // 変数をセッションに格納
    $_SESSION['signup'] = [
      'name_last' => $name_last, 'name_first' => $name_first, 'email' => $email,
      'postal_code' => $postal_code, 'address' => $address,
      'telephone_num' => $telephone_num, 'password' => $password
    ];
    //-------------------------------------- 2022.02.17 --------------------------------------------

    // POSTデータをセッションに格納
    // $_SESSION['signup'] = [
    //   'name_last' => $_POST['name_last'], 'name_first' => $_POST['name_first'], 'email' => $_POST['email'],
    //   'postal_code' => $_POST['postal_code'], 'address' => $_POST['address'],
    //   'telephone_num' => $_POST['telephone_num'], 'password' => $_POST['password']
    // ];

    // 各値が入力されている場合
    if ($_POST['name_last'] && $_POST['name_first'] && $_POST['email'] && $_POST['email'] && $_POST['postal_code'] && $_POST['address'] && $_POST['telephone_num'] && $_POST['password']) {

      // 空白除去(文頭・文末)して、変数に代入
      // $name_last = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['name_last']);
      // $name_first = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['name_first']);
      // $email = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['email']);
      // $postal_code = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['postal_code']);
      // $address = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['address']);
      // $telephone_num = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['telephone_num']);
      // $password = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['password']);
      // パスワード(確認)時間あれば
      // $password2 = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['password2']);

      // 名前(姓)のバリデーション 30文字以下
      if (20 <= mb_strlen($name_last, 'UTF-8')) {
        $message = '名前(姓)は、30文字以下で入力して下さい。';
        return $message;
      }

      // 名前(名)のバリデーション 30文字以下
      if (20 <= mb_strlen($name_first, 'UTF-8')) {
        $message = '名前(名)は、30文字以下で入力して下さい。';
        return $message;
      }

      //メールアドレスのバリデーション
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // メールアドレスがすでに使われていないか調べる
        // DBに接続
        $db = new CustomerModel();
        $pdo = $db->db_connect();
        $stmt = $pdo->prepare('SELECT id FROM customers WHERE email=:email');
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // すでに使われている場合
        if (isset($result['id'])) {
          $message = "このメールアドレスはすでに利用されています。";
          return $message;
        }
        // RFC違反メールアドレスの場合
      } else {
        $message = "ご入力頂いたメールアドレスは、登録できない形式のものです。
        恐れ入りますが、他のメールアドレスをご利用頂くようお願いします。";
        return $message;
      }

      // 郵便番号のバリデーション 数字7桁ハイフン無し
      if (!preg_match("/^[0-9]{7}+$/", $postal_code)) {
        $message = '郵便番号は、半角数字7桁ハイフン無しで入力して下さい。';
        return $message;
      }

      // 住所のバリデーション 300文字以下
      if (300 <= mb_strlen($address, 'UTF-8')) {
        $message = 'ご住所は、300文字以下で入力して下さい。';
        return $message;
      }

      // 電話番号のバリデーション 数字30桁以内ハイフン無し
      if (!preg_match("/^[0-9]{3,30}+$/", $telephone_num)) {
        $message = '電話番号は、半角数字ハイフン無しで入力して下さい。';
        return $message;
      }

      // パスワードのバリデーション 半角英数字8文字以上24文字以下
      if (!preg_match("/\A[a-zA-Z\d]{8,24}+$/", $password)) {
        $message = 'パスワードは、半角英数字8文字以上 24文字以下で入力して下さい。';
        return $message;

        // パスワード(確認)と一致しているか判定 時間あれば
        // } else {
        //   if ($password != $password2) {
        //     $message = 'パスワード(確認)が、一致しません。';
        //     return $message;
        //   }
      }
      // バリデーションがすべてOKなら確認画面へ
      header("Location: ./public_signup_check.php");

      // 各値が入力されていない場合のエラーメッセージ
    } else {
      $message = "全て必須項目です。";
      return $message;
    }
  }

  // ユーザー登録
  public function input()
  {

    // セッションの値を変数に代入 (パスワードのみハッシュ化)
    $name_last = htmlspecialchars($_SESSION['signup']['name_last'], ENT_QUOTES, 'UTF-8');
    $name_first = htmlspecialchars($_SESSION['signup']['name_first'], ENT_QUOTES, 'UTF-8');
    $email = $_SESSION['signup']['email'];
    $postal_code = $_SESSION['signup']['postal_code'];
    $address = htmlspecialchars($_SESSION['signup']['address'], ENT_QUOTES, 'UTF-8');
    $telephone_num = $_SESSION['signup']['telephone_num'];
    $password = password_hash($_SESSION['signup']['password'], PASSWORD_DEFAULT);

    try {
      // DB接続
      $pdo = $this->db_connect();
      // SQL文
      $customers = $pdo->prepare('INSERT INTO customers ( name_last, name_first, email, postal_code, address, telephone_num, password )
      VALUES( :name_last, :name_first, :email, :postal_code, :address, :telephone_num, :password )');

      // BDのカラムへ、各値をセット
      $customers->bindParam(':name_last', $name_last, PDO::PARAM_STR);
      $customers->bindParam(':name_first', $name_first, PDO::PARAM_STR);
      $customers->bindParam(':email', $email, PDO::PARAM_STR);
      $customers->bindParam(':postal_code', $postal_code, PDO::PARAM_INT);
      $customers->bindParam(':address', $address, PDO::PARAM_STR);
      $customers->bindParam(':telephone_num', $telephone_num, PDO::PARAM_INT);
      $customers->bindParam(':password', $password, PDO::PARAM_STR);
      // 実行
      $customers->execute();
      $pdo = null;
      unset($_SESSION['signup']);
      // 登録完了画面へリダイレクト
      header("Location: ./public_signup_complete.php");
    } catch (PDOException $Exception) {
      die('接続エラー：' . $Exception->getMessage());
    }
  }

  // ユーザーログイン
  public function login()
  {
    // 各値が入力されている場合
    if ($_POST['email'] && $_POST['password']) {

      // 空白除去(文頭・文末)して、変数に代入
      $email = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['email']);
      $password = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['password']);

      // DB接続
      $pdo = $this->db_connect();
      // SQL文 メールアドレスが一致するデータを抽出
      $customers = $pdo->prepare('SELECT * FROM customers WHERE email = :email');
      // 実行
      $customers->execute(array(':email' => $email));
      // 抽出データを配列に格納
      $result = $customers->fetch(PDO::FETCH_ASSOC);

      // ハッシュ化したパスワードの認証
      if (password_verify($password, $result['password'])) {
        // ログイン認証に成功した場合
        // loginセッションを削除
        unset($_SESSION['login']['email'], $_SESSION['password']);
        // セッションにユーザー情報を格納
        $_SESSION['customer'] = [
          'id' => $result['id'], 'name_last' => $result['name_last'], 'name_first' => $result['name_first'], 'email' => $result['email'], 'postal_code' => $result['postal_code'], 'address' => $result['address'], 'telephone_num' => $result['telephone_num'], 'password' => $result['password']
        ];
        // TOP画面へリダイレクト
        header('Location: ./top.php');
        exit;
      } else {
        // ログイン認証に失敗した場合
        $message = "メールアドレスまたはパスワードが違います。";
        return $message;
      }
    } else {
      $message = "メールアドレス・パスワードを入力してください。";
      return $message;
    }
  }


  // ユーザー情報 登録内容確認
  public function show()
  {
  }


  // ユーザー情報の一覧表示
  public function index()
  {
    try {
      // DBに接続
      $pdo = $this->db_connect();

      // SQL文 customersテーブルの情報を全て抽出
      $customers = $pdo->prepare(
        "SELECT * FROM customers"
      );
      $customers->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $customers;
  }


  //ユーザー情報の編集
  public function edit()
  {
  }

  // ユーザー情報の更新
  public function update()
  {
  }


  public function logout()
  {
    // セッション変数をクリア
    $_SESSION = array();

    // クッキーに登録されているセッションIDの情報を削除
    if (ini_get("session.use_cookies")) {
      setcookie(session_name(), '', time() - 42000, '/');
    }

    // セッションを破棄
    session_destroy();
  }
}
