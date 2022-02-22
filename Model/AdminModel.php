<?php
class AdminModel
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
      die('接続エラー：' . $Exception->getMessage());
    }
    return $pdo;
  }

  public function signup()
  {
    $name = $_POST['admin_name'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    try {
      // DB接続
      $pdo = $this->db_connect();
      $admin = $pdo->prepare(
        "INSERT INTO admins (name, password) VALUES (:name, :password)"
      );
      $admin->bindParam(':name', $name, PDO::PARAM_STR);
      $admin->bindParam(':password', $password, PDO::PARAM_STR);
      $admin->execute();
      $pdo = null;
      // 管理者ログインへリダイレクト
      header('Location: ./admin_login.php');
    } catch (PDOException $Exception) {
      die('接続エラー：' . $Exception->getMessage());
    }
  }

  // ログイン処理
  public function login()
  {
    // 各値が入力されているかチェック
    if ($_POST['admin_name'] && $_POST['password']) {
      // 入力されていれば変数に代入
      $name = $_POST['admin_name'];
      $password = $_POST['password'];
      // DB接続
      $pdo = $this->db_connect();
      // SQL文 メールアドレスが一致するデータを抽出
      $admin = $pdo->prepare('SELECT * FROM admins WHERE name = :name');
      // 実行
      $admin->execute(array(':name' => $name));
      // 抽出データを配列に格納
      $result = $admin->fetch(PDO::FETCH_ASSOC);

      // ハッシュ化したパスワードの認証
      if (password_verify($password, $result['password'])) {
        // ログイン認証に成功した場合
        // loginセッションを削除
        unset($_SESSION['admin_login']['name'], $_SESSION['admin_login']['password']);
        // セッションにユーザー情報を格納
        $_SESSION['admin'] = [
          'name' => $result['name'], 'password' => $result['password']
        ];

        // 管理者TOPへリダイレクト
        header('Location: ./admin_item_index.php');
      } else {
        // ログイン認証に失敗した場合
        $message = "管理者名またはパスワードが違います。";
        return $message;
      }
    } else {
      $message = "管理者名・パスワードを入力してください。";
      return $message;
    }
  }

  // ログアウト処理
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
