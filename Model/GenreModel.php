<?php
class GenreModel
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

  // ジャンルの登録
  public function input()
  {
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    // ジャンル名が入っているかチェック
    if (empty($name)) {
      // 入っていなければエラーメッセージを表示
      $message = "ジャンル名を入力してください。";
      return $message;

      // 入力されていた場合
    } else {
      try {
        // DBに接続
        $pdo = $this->db_connect();
        $genre = $pdo->prepare(
          "INSERT INTO genres (name, created_at, updated_at) VALUES (:name, now(), now())"
        );
        $genre->bindParam(':name', $name, PDO::PARAM_STR);
        $genre->execute();
      } catch (PDOException $Exception) {
        die('接続エラー：' . $Exception->getMessage());
      }
      $message = "ジャンルが追加されました。";
      return $message;
    }
  }

  // ジャンルの一覧表示
  public function index()
  {
    try {
      // DBに接続
      $pdo = $this->db_connect();
      $genres = $pdo->prepare(
        "SELECT * FROM genres"
      );
      $genres->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $genres;
  }

  // ジャンルの編集
  public function edit()
  {
    $id = $_POST['id'];
    try {
      // DBに接続
      $pdo = $this->db_connect();
      $genre = $pdo->prepare(
        "SELECT * FROM genres WHERE id = $id"
      );
      $genre->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $genre;
  }

  // ジャンルの更新
  public function update()
  {
    $id = $_POST['id'];
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    try {
      // DBに接続
      $pdo = $this->db_connect();
      $genre = $pdo->prepare(
        "UPDATE genres SET name = :name, updated_at = now() WHERE id = $id"
      );
      $genre->bindParam(':name', $name, PDO::PARAM_STR);
      $genre->execute();
    } catch (PDOException $Exception) {
      die('接続エラー：' . $Exception->getMessage());
    }
    header('Location: genre_index.php');
  }

  // ジャンルの削除
  public function delete()
  {
    $id = $_POST['id'];
    try {
      // DBに接続
      $pdo = $this->db_connect();
      $genre = $pdo->prepare(
        "DELETE FROM genres WHERE id=:id"
      );
      $genre->bindParam(':id', $id, PDO::PARAM_INT);
      $genre->execute();
    } catch (PDOException $Exception) {
      die('接続エラー：' . $Exception->getMessage());
    }
    $message = "ジャンルが削除されました。";
    return $message;
  }

  // ジャンル名の参照
  public function show($genre_id)
  {
    $id = $genre_id;
    try {
      // DBに接続
      $pdo = $this->db_connect();
      $selected_genre = $pdo->prepare(
        "SELECT * FROM genres WHERE id = $id"
      );
      $selected_genre->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $selected_genre;
  }
}
