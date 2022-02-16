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
    // POSTデータをセッションに格納
    $_SESSION['customer'] = [
      'name_last' => $_POST['name_last'], 'name_first' => $_POST['name_first'], 'email' => $_POST['email'],
      'postal_code' => $_POST['postal_code'], 'address' => $_POST['address'],
      'telephone_num' => $_POST['telephone_num'], 'password' => $_POST['password']
    ];

    // 各値が入力されている場合
    if (
      $_POST['name_last'] && $_POST['name_first'] && $_POST['email'] && $_POST['email'] &&
      $_POST['postal_code'] && $_POST['address'] && $_POST['telephone_num'] && $_POST['password']
    ) {

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

      // メールアドレスのバリデーション 形式制限 200文字以下
      if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9])+([a-zA-Z0-9._-]+)+$/", $email)) {
        $message = 'メールアドレスの形式で入力して下さい。';
        return $message;

        // メールアドレスの文字数制限 300文字以下
      } else {
        if (300 <= mb_strlen($email, 'UTF-8')) {
          $message = 'メールアドレスは、200文字以下で入力して下さい。';
          return $message;
        }
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

      // 各値が入力されていない場合のエラーメッセージ
    } else {
      $message = "全て必須項目です。";
      return $message;
    }

    // 全項目OK(エラーメッセ無し)の場合、入力確認画面へリダイレクト
    if (empty($message)) {
      header("Location: ./public_signup_check.php");
      exit;
    }
  }


  // ユーザー登録
  public function input()
  {
    // セッションの値を空白除去して、変数に代入 (パスワードのみハッシュ化)
    $name_last = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', (htmlspecialchars($_SESSION['customer']['name_last'], ENT_QUOTES, 'UTF-8')));
    $name_first = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', (htmlspecialchars($_SESSION['customer']['name_first'], ENT_QUOTES, 'UTF-8')));
    $email =  preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_SESSION['customer']['email']);
    $postal_code =  preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_SESSION['customer']['postal_code']);
    $address =  preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', (htmlspecialchars($_SESSION['customer']['address'], ENT_QUOTES, 'UTF-8')));
    $telephone_num =  preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_SESSION['customer']['telephone_num']);
    $password =  preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', (password_hash($_SESSION['customer']['password'], PASSWORD_DEFAULT)));

    try {
      // DB接続
      $pdo = $this->db_connect();
      // SQL文
      $customer = $pdo->prepare('INSERT INTO customers ( name_last, name_first, email, postal_code, address, telephone_num, password )
      VALUES( :name_last, :name_first, :email, :postal_code, :address, :telephone_num, :password )');

      // トランザクション開始
      $pdo->beginTransaction();

      // BDのカラムへ、各値をセット
      $customer->bindParam(':name_last', $name_last, PDO::PARAM_STR);
      $customer->bindParam(':name_first', $name_first, PDO::PARAM_STR);
      $customer->bindParam(':email', $email, PDO::PARAM_STR);
      $customer->bindParam(':postal_code', $postal_code, PDO::PARAM_INT);
      $customer->bindParam(':address', $address, PDO::PARAM_STR);
      $customer->bindParam(':telephone_num', $telephone_num, PDO::PARAM_INT);
      $customer->bindParam(':password', $password, PDO::PARAM_STR);
      // 実行
      $customer->execute();

      // 問題なければ処理実行
      $customer = $pdo->commit();
    } catch (PDOException $Exception) {
      die('接続エラー：' . $Exception->getMessage());

      // エラー発生時は処理を取り消し
      $pdo->rollBack();
    }

    // 登録出来たら、登録完了画面へリダイレクト
    header('Location: ./public_signup_complete.php');
    exit;
  }



  // ユーザーログイン
  public function login()
  {
    // POSTデータをセッションに格納
    $_SESSION['customer'] = ['email' => $_POST['email'], 'password' => $_POST['password']];

    // 各値が入力されている場合
    if ($_POST['email'] && $_POST['password']) {

      // 空白除去(文頭・文末)して、変数に代入
      $email = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['email']);
      $password = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['password']);

      // メールアドレスのバリデーション 形式制限 200文字以下
      if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9])+([a-zA-Z0-9._-]+)+$/", $email)) {
        $message = 'メールアドレスの形式で入力して下さい。';
        return $message;
      }

      // パスワードのバリデーション 半角英数字8文字以上24文字以下
      if (!preg_match("/\A[a-zA-Z\d]{8,24}+$/", $password)) {
        $message = 'パスワードは、半角英数字8文字以上 24文字以下で入力して下さい。';
        return $message;
      }

      // 各値が入力されていない場合のエラーメッセージ
    } else {
      $message = "全て必須項目です。";
      return $message;
    }

    // 全項目OK(エラーメッセ無し)の場合
    if (empty($message)) {

      try {
        // DB接続
        $pdo = $this->db_connect();

        // SQL文 メールアドレスが一致するデータを抽出
        $customer = $pdo->prepare('SELECT * FROM customers WHERE email = :email');

        // トランザクション開始
        $pdo->beginTransaction();

        // BDのカラムへ、値をセット
        $customer->bindParam(':email', $email, PDO::PARAM_STR);
        // 実行
        $customer->execute();

        // 抽出データを配列に格納
        $member = $customer->fetch();

        // 問題なければ処理実行
        $customer = $pdo->commit();
      } catch (PDOException $Exception) {
        die('接続エラー：' . $Exception->getMessage());

        // エラー発生時は処理を取り消し
        $pdo->rollBack();
      }

      // ハッシュ化したパスワードが一致するか検証
      if (password_verify($password, $member['password'])) {

        // 条件一致の場合、カスタマー情報をセッションに再代入
        $_SESSION['customer'] = [
          'name_last' => $member['name_last'], 'name_first' => $member['name_first'], 'email' => $member['email'],
          'postal_code' => $member['postal_code'], 'address' => $member['address'],
          'telephone_num' => $member['telephone_num'], 'password' => $member['password']
        ];

        // TOP画面へリダイレクト
        header('Location: ./top.php');
        exit;

        // 不一致の場合、エラーメッセージを返す
      } else {
        $message = "メールアドレス または、パスワードが間違っています。";
        return $message;
      }
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
      $customer->execute();
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
}
