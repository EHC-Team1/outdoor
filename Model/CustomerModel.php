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
    // 空白除去(文頭・文末)して、変数に代入
    $name_last = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['name_last']);
    $name_first = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['name_first']);
    $email = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['email']);
    $postal_code = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['postal_code']);
    $address = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['address']);
    $house_num = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['house_num']);
    $telephone_num = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['telephone_num']);
    $password = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['password']);

    // 変数をセッションに格納
    $_SESSION['signup'] = ['name_last' => $name_last, 'name_first' => $name_first, 'email' => $email, 'postal_code' => $postal_code, 'address' => $address, 'house_num' => $house_num, 'telephone_num' => $telephone_num, 'password' => $password];

    // 各値が入力されている場合
    if ($_POST['name_last'] && $_POST['name_first'] && $_POST['email'] && $_POST['email'] && $_POST['postal_code'] && $_POST['address'] && $_POST['house_num'] && $_POST['telephone_num'] && $_POST['password']) {

      // 名前(姓)のバリデーション 40文字以下
      if (40 <= mb_strlen($name_last, 'UTF-8')) {
        $message = '名前(姓)は、40文字以下で入力して下さい。';
        return $message;
      }

      // 名前(名)のバリデーション 40文字以下
      if (40 <= mb_strlen($name_first, 'UTF-8')) {
        $message = '名前(名)は、40文字以下で入力して下さい。';
        return $message;
      }

      //メールアドレスのバリデーション
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // メールアドレスがすでに使われていないか調べる
        // DBに接続
        $db = new CustomerModel();
        $pdo = $db->db_connect();
        $stmt = $pdo->prepare('SELECT id,is_customer_flag FROM customers WHERE email=:email');
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // すでに会員登録済みで使われている場合
        if (isset($result['id']) && $result['is_customer_flag'] == 0) {
          $message = "このメールアドレスはでに利用されています。";
          return $message;

          // 退会済みユーザーのメールアドレスの場合
        } elseif (isset($result['id']) && $result['is_customer_flag'] == 1) {
          header("Location: ./public_rejoin.php");
          exit;
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

      // 市区町村のバリデーション 80文字以下
      if (80 <= mb_strlen($address, 'UTF-8')) {
        $message = '市区町村は、80文字以下で入力して下さい。';
        return $message;
      }

      // 番地・建物名のバリデーション 80文字以下
      if (80 <= mb_strlen($house_num, 'UTF-8')) {
        $message = '番地・建物名は、80文字以下で入力して下さい。';
        return $message;
      }

      // 電話番号のバリデーション 数字30桁以内ハイフン無し
      if (!preg_match("/^[0-9]{3,30}+$/", $telephone_num)) {
        $message = '電話番号は、半角数字30文字以内ハイフン無しで入力して下さい。';
        return $message;
      }

      // パスワードのバリデーション 半角英数字8文字以上24文字以下
      if (!preg_match("/\A[a-zA-Z\d]{8,24}+$/", $password)) {
        $message = 'パスワードは、半角英数字8文字以上 24文字以下で入力して下さい。';
        return $message;

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
    $house_num = htmlspecialchars($_SESSION['signup']['house_num'], ENT_QUOTES, 'UTF-8');
    $telephone_num = $_SESSION['signup']['telephone_num'];
    $password = password_hash($_SESSION['signup']['password'], PASSWORD_DEFAULT);

    try {
      // DB接続
      $pdo = $this->db_connect();
      $customer = $pdo->prepare(
        'INSERT INTO customers ( name_last, name_first, email, postal_code, address, house_num, telephone_num, password ) VALUES( :name_last, :name_first, :email, :postal_code, :address, :house_num, :telephone_num, :password )'
      );
      $customer->bindParam(':name_last', $name_last, PDO::PARAM_STR);
      $customer->bindParam(':name_first', $name_first, PDO::PARAM_STR);
      $customer->bindParam(':email', $email, PDO::PARAM_STR);
      $customer->bindParam(':postal_code', $postal_code, PDO::PARAM_INT);
      $customer->bindParam(':address', $address, PDO::PARAM_STR);
      $customer->bindParam(':house_num', $house_num, PDO::PARAM_STR);
      $customer->bindParam(':telephone_num', $telephone_num, PDO::PARAM_INT);
      $customer->bindParam(':password', $password, PDO::PARAM_STR);
      $customer->execute();
      // idを取得
      $id = $pdo->lastInsertId();
      $pdo = null;

      // セッションにユーザー情報を格納
      $_SESSION['customer'] = [
        'id' => $id, 'name_last' => $name_last, 'name_first' => $name_first, 'email' => $email, 'postal_code' => $postal_code, 'address' => $address, 'house_num' => $house_num, 'telephone_num' => $telephone_num, 'password' => $password
      ];
      unset($_SESSION['signup']);

    } catch (PDOException $Exception) {
      die('接続エラー：' . $Exception->getMessage());
    }
    // 登録完了画面へリダイレクト
    header("Location: ./public_signup_complete.php?admission");
  }

  // ユーザーログイン
  public function login()
  {
    // 空白除去(文頭・文末)して、変数に代入
    $email = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['email']);
    $password = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['password']);

    // 値をloginセッションに格納
    $_SESSION['login'] = ['email' => $email, 'password' => $password];

    // 各値が入力されている場合
    if ($_POST['email'] && $_POST['password']) {
      // DB接続
      $pdo = $this->db_connect();
      // メールアドレスが一致するデータを抽出
      $customer = $pdo->prepare("SELECT * FROM customers WHERE email=:email");
      $customer->bindParam(':email', $email, PDO::PARAM_STR);
      $customer->execute();
      // 抽出データを配列に格納
      $result = $customer->fetch(PDO::FETCH_ASSOC);

      // 入力値が全て一致、会員であればログイン処理
      if ($result == true && password_verify($password, $result['password']) && $result['is_customer_flag'] == 0) {
        // loginセッションを削除
        unset($_SESSION['login']);
        // セッションにユーザー情報を格納
        $_SESSION['customer'] = [
          'id' => $result['id'], 'name_last' => $result['name_last'], 'name_first' => $result['name_first'], 'email' => $result['email'], 'postal_code' => $result['postal_code'], 'address' => $result['address'], 'house_num' => $result['house_num'], 'telephone_num' => $result['telephone_num'], 'password' => $result['password']
        ];
        // TOP画面へリダイレクト
        header('Location: ./top.php');
        exit;

        // 入力値が全て一致、退会済みユーザーと判定したら、再登録画面へ遷移
      } elseif ($result == true && password_verify($password, $result['password']) && $result['is_customer_flag'] == 1) {
        header("Location: ./public_rejoin.php");
        exit;

        // ログイン認証に失敗した場合
      } else {
        $message = "メールアドレスまたはパスワードが違います。";
        return $message;
      }
    } else {
      $message = "メールアドレス・パスワードを入力してください。";
      return $message;
    }
  }


  // ユーザー再登録
  public function rejoin()
  {
    // 空白除去(文頭・文末)して、変数に代入
    $name_last = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['name_last']);
    $name_first = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['name_first']);
    $email = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['email']);
    $password = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '',  $_POST['password']);
    // loginセッションに値を格納
    $_SESSION['login'] = ['name_last' => $name_last, 'name_first' => $name_first, 'email' => $email, 'password' => $password];

    // 各値が入力されている場合
    if ($_POST['name_last'] && $_POST['name_first'] && $_POST['email'] && $_POST['password']) {

      $pdo = $this->db_connect();
      // 退会済みユーザーの中からメールアドレスが一致するデータを抽出
      $customer = $pdo->prepare("SELECT * FROM customers WHERE is_customer_flag = 1 AND email = :email ");
      $customer->bindParam(':email', $email, PDO::PARAM_STR);
      $customer->execute();
      // 抽出データを配列に格納
      $result = $customer->fetch(PDO::FETCH_ASSOC);

      // 入力値が全て一致した場合
      if ($result == true && password_verify($password, $result['password']) && $result['name_first'] == $name_first && $result['name_last'] == $name_last) {

        // 再入会処理
        $id = $result['id'];
        $is_customer_flag = 0;
        try {
          $pdo = $this->db_connect();
          $switch_status = $pdo->prepare(
            "UPDATE customers SET is_customer_flag = :is_customer_flag WHERE id = $id"
          );
          $switch_status->bindParam('is_customer_flag', $is_customer_flag, PDO::PARAM_INT);
          $switch_status->execute();
        } catch (PDOException $Exception) {
          die('接続エラー：' . $Exception->getMessage());
        }

        // 各セッションを削除
        unset($_SESSION['login']);
        unset($_SESSION['signup']);
        // customerセッションにユーザー情報を格納
        $_SESSION['customer'] = [
          'id' => $id, 'name_last' => $result['name_last'], 'name_first' => $result['name_first'], 'email' => $result['email'], 'postal_code' => $result['postal_code'], 'address' => $result['address'], 'house_num' => $result['house_num'], 'telephone_num' => $result['telephone_num'], 'password' => $result['password']
        ];
        // 登録完了画面へリダイレクト
        header("Location: ./public_signup_complete.php?rejoin");
        exit;

        // 再入会認証に失敗した場合
      } else {
        $message = "登録情報が一致しません。";
        return $message;
      }
    } else {
      $message = "全て必須項目です。";
      return $message;
    }
  }


  // ユーザー情報 登録内容表示
  public function show()
  {
    try {
      $id = $_SESSION['customer']['id'];
      // DBに接続
      $pdo = $this->db_connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $customers = $pdo->prepare(
        "SELECT * FROM customers WHERE id = $id"
      );
      $customers->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $customers;
  }


  // customer_indexページング用データ数取得
  public function page_count_admin_index()
  {
    // 退会済みユーザーのみを取得
    if (isset($_GET['secession_members'])) {
      try {
        $pdo = $this->db_connect();
        $pages = $pdo->prepare(
          "SELECT COUNT(*) id FROM customers WHERE is_customer_flag = 1"
        );
        $pages->execute();
      } catch (PDOException $Exception) {
        exit("接続エラー：" . $Exception->getMessage());
      }

      // 会員ユーザーのみを取得
    } else {
      try {
        $pdo = $this->db_connect();
        $pages = $pdo->prepare(
          "SELECT COUNT(*) id FROM customers WHERE is_customer_flag = 0"
        );
        $pages->execute();
      } catch (PDOException $Exception) {
        exit("接続エラー：" . $Exception->getMessage());
      }
    }
    return $pages;
  }


  // ユーザー情報の一覧表示
  public function index($start)
  {
    $start = $start;

    // 退会済みユーザーのみを取得
    if (isset($_GET['secession_members'])) {
      try {
        $pdo = $this->db_connect();
        $customers = $pdo->prepare(
          // 退会日降順で取得
          "SELECT * FROM customers WHERE is_customer_flag = 1 ORDER BY updated_at DESC LIMIT {$start}, 15"
        );
        $customers->execute();
      } catch (PDOException $Exception) {
        exit("接続エラー：" . $Exception->getMessage());
      }

      // 会員ユーザーのみを取得
    } else {
      try {
        // DBに接続
        $pdo = $this->db_connect();
        $customers = $pdo->prepare(
          // 登録日降順で取得
          "SELECT * FROM customers WHERE is_customer_flag = 0 ORDER BY created_at DESC LIMIT {$start}, 15"
        );
        $customers->execute();
      } catch (PDOException $Exception) {
        exit("接続エラー：" . $Exception->getMessage());
      }
    }
    return $customers;
  }


  //ユーザー情報の編集
  public function edit()
  {
    $id = $_SESSION['customer']['id'];
    try {
      // DBに接続
      $pdo = $this->db_connect();
      $customer = $pdo->prepare(
        "SELECT * FROM customers WHERE id = $id"
      );
      $customer->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $customer;
  }

  // ユーザー情報の更新
  public function update($customer)
  {
    $customer = $customer;
    $customer_id = $customer['id'];
    $name_last = htmlspecialchars($_POST['name_last'], ENT_QUOTES, 'UTF-8');
    $name_first = htmlspecialchars($_POST['name_first'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $postal_code = htmlspecialchars($_POST['postal_code'], ENT_QUOTES, 'UTF-8');
    $address = htmlspecialchars($_POST['address'], ENT_QUOTES, 'UTF-8');
    $house_num = htmlspecialchars($_POST['house_num'], ENT_QUOTES, 'UTF-8');
    $telephone_num = htmlspecialchars($_POST['telephone_num'], ENT_QUOTES, 'UTF-8');
    try {
      // DBに接続
      $pdo = $this->db_connect();
      $customer = $pdo->prepare(
        "UPDATE customers SET name_last = :name_last, name_first = :name_first, email = :email, postal_code = :postal_code, address = :address, house_num = :house_num, telephone_num = :telephone_num WHERE id = $customer_id"
      );
      $customer->bindParam('name_last', $name_last, PDO::PARAM_STR);
      $customer->bindParam('name_first', $name_first, PDO::PARAM_STR);
      $customer->bindParam('email', $email, PDO::PARAM_STR);
      $customer->bindParam('postal_code', $postal_code, PDO::PARAM_STR);
      $customer->bindParam('address', $address, PDO::PARAM_STR);
      $customer->bindParam('house_num', $house_num, PDO::PARAM_STR);
      $customer->bindParam('telephone_num', $telephone_num, PDO::PARAM_STR);
      $customer->execute();
    } catch (PDOException $Exception) {
      die('接続エラー：' . $Exception->getMessage());
      header('Location: mypage.php');
    }
  }


  // ユーザー退会(ユーザー側)
  public function public_switch_status($id)
  {
    $id = $id;
    $is_customer_flag = 1;
    try {
      // DBに接続
      $pdo = $this->db_connect();
      $customer_status = $pdo->prepare(
        "UPDATE customers SET is_customer_flag = :is_customer_flag, updated_at = now() WHERE id = $id"
      );
      $customer_status->bindParam('is_customer_flag', $is_customer_flag, PDO::PARAM_INT);
      $customer_status->execute();
    } catch (PDOException $Exception) {
      die('接続エラー：' . $Exception->getMessage());
    }
    // 処理後、ログアウトしてTOPへ画面遷移
    $pdo = new CustomerModel();
    $customer_status = $pdo->logout();
    header('location: top.php');
  }


  // ユーザー退会(管理者側)
  public function admin_switch_status($id, $secession_member_id)
  {
    $id = $id;
    $secession_member_id = $secession_member_id;

    // 再入会処理
    if ($secession_member_id) {
      $is_customer_flag = 0;
      try {
        // DBに接続
        $pdo = $this->db_connect();
        $switch_status = $pdo->prepare(
          "UPDATE customers SET is_customer_flag = :is_customer_flag WHERE id = $secession_member_id"
        );
        $switch_status->bindParam('is_customer_flag', $is_customer_flag, PDO::PARAM_INT);
        $switch_status->execute();
      } catch (PDOException $Exception) {
        die('接続エラー：' . $Exception->getMessage());
      }
      // 処理後、ユーザー一覧(会員タグ)へ画面遷移
      header('location: customer_index.php');

      // 退会処理
    } else {
      $is_customer_flag = 1;
      try {
        // DBに接続
        $pdo = $this->db_connect();
        $switch_status = $pdo->prepare(
          "UPDATE customers SET is_customer_flag = :is_customer_flag, updated_at = now() WHERE id = $id"
        );
        $switch_status->bindParam('is_customer_flag', $is_customer_flag, PDO::PARAM_INT);
        $switch_status->execute();
      } catch (PDOException $Exception) {
        die('接続エラー：' . $Exception->getMessage());
      }
      // 処理後、ユーザー一覧(退会済みタグ)へ画面遷移
      header('location: customer_index.php?secession_members');
    }
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
