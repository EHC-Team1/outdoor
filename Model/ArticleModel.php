<?php
class ArticleModel
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

  // 記事の登録
  public function input()
  {
    // POSTデータを変数に代入
    $title = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', (htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8')));
    $body = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', (htmlspecialchars($_POST['body'], ENT_QUOTES, 'UTF-8')));
    $article_image = $_FILES['article_image'];
    // 公開ステータスの判定 「公開」の場合
    if ($_POST['is_status']  == "disclosure") {
      $is_status = 1;
    } else {
      $is_status = 0;
    }

    // 必須項目の入力チェック
    if ($title && $body) {

      // 画像ファイルがある場合
      if (isset($article_image['error']) && is_int($article_image['error']) && $article_image['name'] !== "") {
        // ファイルの内容を全て読み込む
        $raw_data = file_get_contents($article_image['tmp_name']);
        // 拡張子を取り出し、ファイルの形式を判断する
        $tmp = pathinfo($article_image["name"]);
        $extension = $tmp["extension"];
        if ($extension === "jpg" || $extension === "jpeg" || $extension === "JPG" || $extension === "JPEG") {
          $extension = "jpeg";
        } elseif ($extension === "png" || $extension === "PNG") {
          $extension = "png";
        } elseif ($extension === "gif" || $extension === "GIF") {
          $extension = "gif";
        } else {
          echo '非対応のファイルです';
          echo ("<button onclick=location.href='../view_admin/article_index.php' class=btn btn-outline-secondary btn-lg>戻る</button>");
        }
        try {
          // DB接続
          $pdo = $this->db_connect();
          $date = getdate();
          // DBに格納するファイル名を設定
          $article_image = $article_image['tmp_name'] . $date["year"] . $date["mon"] . $date["mday"] . $date["hours"] . $date["minutes"] . $date["seconds"];
          $article_image = hash("sha256", $article_image);
          // SQL文　
          $articles = $pdo->prepare("INSERT INTO articles ( title, body, article_image, extension, raw_data, is_status, created_at, updated_at)
          VALUES ( :title, :body, :article_image, :extension, :row_data, :is_status, now(), now());");

          // 値をセット
          $articles->bindParam(':title', $title, PDO::PARAM_STR);
          $articles->bindParam(':body', $body, PDO::PARAM_STR);
          $articles->bindValue(':article_image', $article_image, PDO::PARAM_STR);
          $articles->bindValue(':extension', $extension, PDO::PARAM_STR);
          $articles->bindValue(':row_data', $raw_data, PDO::PARAM_STR);
          $articles->bindParam(':is_status', $is_status, PDO::PARAM_INT);
          $articles->execute();
        } catch (PDOException $Exception) {
          die('接続エラー：' . $Exception->getMessage());
        }
        // 格納に成功すれば記事一覧画面に遷移
        // header('Location: ../view_admin/article_index.php');

        // 画像がない場合
      } else {
        try {
          // DB接続
          $pdo = $this->db_connect();
          // SQL文
          $articles = $pdo->prepare("INSERT INTO articles ( title, body, is_status, created_at, updated_at)
          VALUES ( :title, :body, :is_status, now(), now());");

          // 値をセット
          $articles->bindParam(':title', $title, PDO::PARAM_STR);
          $articles->bindParam(':body', $body, PDO::PARAM_STR);
          $articles->bindParam(':is_status', $is_status, PDO::PARAM_INT);
          $articles->execute();
        } catch (PDOException $Exception) {
          die('接続エラー：' . $Exception->getMessage());
        }
      }

      // 格納に成功すれば記事一覧画面に遷移
      header('Location: ../view_admin/article_index.php');

      // 必須項目が入力されていない場合、入力画面にリダイレクト
    } else {
      $message = "画像以外は必須項目です";
      return $message;
    }
  }


  // 記事の詳細表示
  public function show()
  {
  }


  // 記事の一覧表示
  public function index()
  {
    try {
      // DBに接続
      $pdo = $this->db_connect();
      //SQL文 全データを投稿日時の降順で取得
      $articles = $pdo->prepare(
        "SELECT * FROM articles WHERE is_status = 1 ORDER BY created_at DESC;"
      );
      $articles->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    // $articlesを返す
    return $articles;
  }

  // ------------------------------ indexメソッド分けた ---------------------------
  // 記事の一覧表示(ユーザー側)
  public function public_index()
  {
    try {
      // DBに接続
      $pdo = $this->db_connect();
      //SQL文 全データを投稿日時の降順で取得
      $articles = $pdo->prepare(
        "SELECT * FROM articles WHERE is_status = 1 ORDER BY created_at DESC;"
      );
      $articles->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    // $articlesを返す
    return $articles;
  }
  // ----------------------------------- 2022.2.21 --------------------------------

  // 記事の一覧表示(管理者側)
  public function admin_index()
  {
    try {
      // DBに接続
      $pdo = $this->db_connect();
      //SQL文 全データを投稿日時の降順で取得
      $articles = $pdo->prepare(
        "SELECT * FROM articles ORDER BY created_at DESC;"
      );
      $articles->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    // $articlesを返す
    return $articles;
  }


  // 関連記事の呼び出し
  public function item_article($article_id)
  {
    $article_id = $article_id;
    try {
      $pdo = $this->db_connect();
      $article = $pdo->prepare(
        "SELECT * FROM articles WHERE id = $article_id AND is_status = 1"
      );
      $article->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $article;
  }

  // 該当ジャンルの商品の一覧
  public function genre_index()
  {
  }

  // 記事の検索
  public function search_index()
  {
  }

  // 記事の編集
  public function edit()
  {
    $id = $_POST['id'];
    try {
      // DBに接続
      $pdo = $this->db_connect();
      // SQL文 一致したidの全データを抽出
      $articles = $pdo->prepare(
        "SELECT * FROM articles WHERE id=$id"
      );
      // $articles->bindParam(':id', $id, PDO::PARAM_INT);
      $articles->execute();
    } catch (PDOException $Exception) {
      die('接続エラー：' . $Exception->getMessage());
    }
    return $articles;
  }


  // 記事の更新
  public function update()
  {
    // POSTデータを変数に代入
    $id = $_POST['id'];
    $title = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', (htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8')));
    $body = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', (htmlspecialchars($_POST['body'], ENT_QUOTES, 'UTF-8')));
    $article_image = $_FILES['article_image'];
    // 公開ステータスの判定 「公開」の場合
    if ($_POST['is_status']  == "disclosure") {
      $is_status = 1;
    } else {
      $is_status = 0;
    }

    // 画像ファイルがある場合
    if (isset($article_image['error']) && is_int($article_image['error']) && $article_image['name'] !== "") {
      // ファイルの内容を全て読み込む
      $raw_data = file_get_contents($article_image['tmp_name']);
      // 拡張子を取り出し、ファイルの形式を判断する
      $tmp = pathinfo($article_image["name"]);
      $extension = $tmp["extension"];
      if ($extension === "jpg" || $extension === "jpeg" || $extension === "JPG" || $extension === "JPEG") {
        $extension = "jpeg";
      } elseif ($extension === "png" || $extension === "PNG") {
        $extension = "png";
      } elseif ($extension === "gif" || $extension === "GIF") {
        $extension = "gif";
      } else {
        echo '非対応のファイルです';
        echo ("<button onclick=location.href='../view_admin/article_index.php' class=btn btn-outline-secondary btn-lg>戻る</button>");
      }
      try {
        // DB接続
        $pdo = $this->db_connect();
        $date = getdate();
        // DBに格納するファイル名を設定
        $article_image = $article_image['tmp_name'] . $date["year"] . $date["mon"] . $date["mday"] . $date["hours"] . $date["minutes"] . $date["seconds"];
        $article_image = hash("sha256", $article_image);
        // SQL文　idが一致するデータへ更新処理
        $articles = $pdo->prepare("UPDATE articles SET title =:title, body =:body, article_image = :article_image, extension = :extension, raw_data=:row_data, is_status = :is_status, updated_at = now() WHERE id =$id");

        // 値をセット
        $articles->bindParam(':title', $title, PDO::PARAM_STR);
        $articles->bindParam(':body', $body, PDO::PARAM_STR);
        $articles->bindValue(':article_image', $article_image, PDO::PARAM_STR);
        $articles->bindValue(':extension', $extension, PDO::PARAM_STR);
        $articles->bindValue(':row_data', $raw_data, PDO::PARAM_STR);
        $articles->bindParam(':is_status', $is_status, PDO::PARAM_INT);
        $articles->execute();
      } catch (PDOException $Exception) {
        die('接続エラー：' . $Exception->getMessage());
      }

      // 画像がない場合
    } else {
      try {
        // DB接続
        $pdo = $this->db_connect();
        // SQL文 idが一致するデータへ更新処理
        $articles = $pdo->prepare("UPDATE articles SET title =:title, body =:body, is_status = :is_status, updated_at = now() WHERE id =$id");

        // 値をセット
        $articles->bindParam(':title', $title, PDO::PARAM_STR);
        $articles->bindParam(':body', $body, PDO::PARAM_STR);
        $articles->bindParam(':is_status', $is_status, PDO::PARAM_INT);
        $articles->execute();
      } catch (PDOException $Exception) {
        die('接続エラー：' . $Exception->getMessage());
      }
    }

    // 格納に成功すれば記事一覧画面に遷移
    // return $articles;
    // header("Location: ../view_admin/article_index.php");
    $articles = "記事を更新しました。";
    header("location:../view_admin/article_index.php?update=" . $articles);
  }


  // 記事の削除
  public function delete()
  {
    $id = $_POST['id'];
    try {
      // DBに接続
      $pdo = $this->db_connect();
      // SQL文 一致したidの全データを削除
      $articles = $pdo->prepare(
        "DELETE FROM articles WHERE id=:id"
      );
      $articles->bindParam(':id', $id, PDO::PARAM_INT);
      $articles->execute();
    } catch (PDOException $Exception) {
      die('接続エラー：' . $Exception->getMessage());
    }
    $message = "記事が削除されました。";
    return $message;
  }
}
