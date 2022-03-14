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
        $extension = pathinfo($article_image["name"], PATHINFO_EXTENSION);
        if ($extension === "jpg" || $extension === "jpeg" || $extension === "JPG" || $extension === "JPEG") {
          $extension = "jpeg";
        } elseif ($extension === "png" || $extension === "PNG") {
          $extension = "png";
        } elseif ($extension === "gif" || $extension === "GIF") {
          $extension = "gif";
        } else {
          $message = "セキュリティの都合上、このファイル形式は許可できません。別の画像ファイルを使用してください。";
          return $message;
        }
        try {
          // DB接続
          $pdo = $this->db_connect();
          $date = getdate();

          // DBに格納するファイル名を設定
          $article_image = $article_image['tmp_name'] . $date["year"] . $date["mon"] . $date["mday"] . $date["hours"] . $date["minutes"] . $date["seconds"];
          $article_image = hash("sha256", $article_image);
          // SQL文　
          $article = $pdo->prepare(
            "INSERT INTO articles ( title, body, article_image, extension, raw_data, is_status, created_at, updated_at) VALUES ( :title, :body, :article_image, :extension, :raw_data, :is_status, now(), now());"
          );
          // 値をセット
          $article->bindParam(':title', $title, PDO::PARAM_STR);
          $article->bindParam(':body', $body, PDO::PARAM_STR);
          $article->bindValue(':article_image', $article_image, PDO::PARAM_STR);
          $article->bindValue(':extension', $extension, PDO::PARAM_STR);
          $article->bindValue(':raw_data', $raw_data, PDO::PARAM_STR);
          $article->bindParam(':is_status', $is_status, PDO::PARAM_INT);
          $article->execute();
        } catch (PDOException $Exception) {
          die('接続エラー：' . $Exception->getMessage());
        }

        // 画像がない場合
      } else {
        try {
          // DB接続
          $pdo = $this->db_connect();
          // SQL文
          $article = $pdo->prepare(
            "INSERT INTO articles ( title, body, is_status, created_at, updated_at) VALUES (:title, :body, :is_status, now(), now());"
          );
          // 値をセット
          $article->bindParam(':title', $title, PDO::PARAM_STR);
          $article->bindParam(':body', $body, PDO::PARAM_STR);
          $article->bindParam(':is_status', $is_status, PDO::PARAM_INT);
          $article->execute();
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
  public function show($article_id)
  {
    $article_id =  $article_id;
    try {
      // db_connectメソッドを呼び出す
      $pdo = $this->db_connect();
      $article_show = $pdo->prepare(
        "SELECT * FROM articles WHERE id = $article_id"
      );
      $article_show->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $article_show;
  }

  public function article_item($article_id)
  {
    $article_id =  $article_id;
    try {
      // db_connectメソッドを呼び出す
      $pdo = $this->db_connect();
      $items = $pdo->prepare(
        "SELECT genres.name AS genre_name, items.id AS item_id, items.article_id AS item_article_id, items.name AS name, items.price AS price, items.item_image AS item_image, items.extension AS item_extension, items.is_status AS item_is_status FROM genres,items WHERE items.genre_id = genres.id AND items.is_status = 1 AND items.article_id = $article_id"
      );
      $items->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $items;
  }

  // サイドバー内コラム一覧表示
  public function sidebar_index()
  {
    try {
      // DBに接続
      $pdo = $this->db_connect();
      //SQL文 投稿日時の降順で取得
      $articles = $pdo->prepare(
        "SELECT * FROM articles WHERE is_status = 1 ORDER BY updated_at DESC;"
      );
      $articles->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    // $articlesを返す
    return $articles;
  }

  // public_indexページング用データ数取得
  public function page_count_public_index()
  {
    try {
      $pdo = $this->db_connect();
      $pages = $pdo->prepare(
        "SELECT COUNT(*) id FROM articles WHERE is_status = 1"
      );
      $pages->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $pages;
  }

  // 記事の一覧表示(ユーザー側)
  public function public_index($start)
  {
    $start = $start;
    try {
      // DBに接続
      $pdo = $this->db_connect();
      //SQL文 投稿日時の降順で取得
      $top_articles = $pdo->prepare(
        "SELECT * FROM articles WHERE is_status = 1 ORDER BY updated_at DESC LIMIT {$start}, 16"
      );
      $top_articles->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    // $articlesを返す
    return $top_articles;
  }

  // public_indexページング用データ数取得
  public function page_count_admin_index()
  {
    try {
      $pdo = $this->db_connect();
      $pages = $pdo->prepare(
        "SELECT COUNT(*) id FROM articles"
      );
      $pages->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $pages;
  }

  // 商品関連記事一覧表示(管理者側)
  public function admin_index()
  {
    try {
      $pdo = $this->db_connect();
      // 更新日時の降順で取得
      $articles = $pdo->prepare(
        "SELECT * FROM articles ORDER BY updated_at DESC"
      );
      $articles->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $articles;
  }

  // 記事の一覧表示(管理者側)
  public function admin_index_limit($start)
  {
    $start = $start;
    try {
      $pdo = $this->db_connect();
      // 更新日時の降順で取得
      $articles = $pdo->prepare(
        "SELECT * FROM articles ORDER BY updated_at DESC LIMIT {$start}, 15"
      );
      $articles->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $articles;
  }


  // 関連記事の呼び出し
  public function item_article($article_id)
  {
    $article_id = $article_id;
    try {
      $pdo = $this->db_connect();
      $article_show = $pdo->prepare(
        "SELECT * FROM articles WHERE id = $article_id AND is_status = 1"
      );
      $article_show->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $article_show;
  }

  // 記事の検索
  public function search_index()
  {
    $keyword = $_POST['keyword'];
    try {
      $pdo = $this->db_connect();
      // キーワードがタイトル又は本文に入っているものを、更新日の降順で抽出
      $search_articles = $pdo->prepare(
        "SELECT * FROM articles WHERE body LIKE CONCAT('%',:keyword_body,'%') AND is_status = 1 OR title LIKE CONCAT('%',:keyword_title,'%') AND is_status = 1 ORDER BY updated_at DESC"
      );
      $search_articles->bindValue(':keyword_body', $keyword);
      $search_articles->bindValue(':keyword_title', $keyword);
      $search_articles->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $search_articles;
  }

  // 記事の編集
  public function edit($article_id)
  {
    $id = $article_id;
    try {
      // DBに接続
      $pdo = $this->db_connect();
      // SQL文 一致したidのデータを抽出
      $article = $pdo->prepare(
        "SELECT * FROM articles WHERE id=$id"
      );
      $article->execute();
    } catch (PDOException $Exception) {
      die('接続エラー：' . $Exception->getMessage());
    }
    return $article;
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

    // 画像削除ボタンの判定
    if (isset($_POST['delete_image'])) {
      $delete_image = 1;
    }

    // 更新日時ボタンの判定
    if ($_POST['posting_date'] == "updated_at_keep") {
      $updated_at_keep = $_POST['updated_at_keep'];
    }

    // 画像ファイルがある場合
    if (isset($article_image['error']) && is_int($article_image['error']) && $article_image['name'] !== "") {
      // ファイルの内容を全て読み込む
      $raw_data = file_get_contents($article_image['tmp_name']);
      // 拡張子を取り出し、ファイルの形式を判断する
      $extension = pathinfo($article_image["name"], PATHINFO_EXTENSION);
      if ($extension === "jpg" || $extension === "jpeg" || $extension === "JPG" || $extension === "JPEG") {
        $extension = "jpeg";
      } elseif ($extension === "png" || $extension === "PNG") {
        $extension = "png";
      } elseif ($extension === "gif" || $extension === "GIF") {
        $extension = "gif";
      } else {
        $message = "セキュリティの都合上、このファイル形式は許可できません。別の画像ファイルを使用してください。";
        return $message;
      }
      try {
        $pdo = $this->db_connect();
        // DBに格納するファイル名を設定
        $date = getdate();
        $article_image = $article_image['tmp_name'] . $date["year"] . $date["mon"] . $date["mday"] . $date["hours"] . $date["minutes"] . $date["seconds"];
        $article_image = hash("sha256", $article_image);

        // 投稿日の判定「変更なし」の場合
        if ($updated_at_keep) {
          $articles = $pdo->prepare(
            "UPDATE articles SET title =:title, body =:body, article_image = :article_image, extension = :extension, raw_data=:raw_data, is_status = :is_status, updated_at = :updated_at WHERE id =$id"
          );
          $articles->bindParam(':updated_at', $updated_at_keep, PDO::PARAM_INT);
          // 投稿日の判定「変更あり」の場合
        } else {
          $articles = $pdo->prepare(
            "UPDATE articles SET title =:title, body =:body, article_image = :article_image, extension = :extension, raw_data=:raw_data, is_status = :is_status, updated_at = now() WHERE id =$id"
          );
        }
        $articles->bindParam(':title', $title, PDO::PARAM_STR);
        $articles->bindParam(':body', $body, PDO::PARAM_STR);
        $articles->bindValue(':article_image', $article_image, PDO::PARAM_STR);
        $articles->bindValue(':extension', $extension, PDO::PARAM_STR);
        $articles->bindValue(':raw_data', $raw_data, PDO::PARAM_STR);
        $articles->bindParam(':is_status', $is_status, PDO::PARAM_INT);
        $articles->execute();
      } catch (PDOException $Exception) {
        die('接続エラー：' . $Exception->getMessage());
      }

      // 「画像削除」ボタンが押された場合
    } elseif ($delete_image) {
      try {
        $pdo = $this->db_connect();
        // 投稿日の判定「変更なし」の場合
        if ($updated_at_keep) {
          $articles = $pdo->prepare(
            "UPDATE articles SET title =:title, body =:body, article_image = :article_image, extension = :extension, raw_data=:raw_data, is_status = :is_status, updated_at = :updated_at WHERE id =$id"
          );
          $articles->bindParam(':updated_at', $updated_at_keep, PDO::PARAM_INT);
          // 投稿日の判定「変更あり」の場合
        } else {
          $articles = $pdo->prepare(
            "UPDATE articles SET title =:title, body =:body, article_image = :article_image, extension = :extension, raw_data=:raw_data, is_status = :is_status, updated_at = now() WHERE id =$id"
          );
        }
        $articles->bindParam(':title', $title, PDO::PARAM_STR);
        $articles->bindParam(':body', $body, PDO::PARAM_STR);
        $articles->bindValue(':article_image', "", PDO::PARAM_STR);
        $articles->bindValue(':extension', "", PDO::PARAM_STR);
        $articles->bindValue(':raw_data', "", PDO::PARAM_STR);
        $articles->bindParam(':is_status', $is_status, PDO::PARAM_INT);
        $articles->execute();
      } catch (PDOException $Exception) {
        die('接続エラー：' . $Exception->getMessage());
      }

      // 新規画像が選択されてない＆「画像削除」ボタンが押されていない場合
    } else {
      try {
        $pdo = $this->db_connect();
        // 投稿日の判定「変更なし」の場合
        if ($updated_at_keep) {
          $articles = $pdo->prepare(
            "UPDATE articles SET title =:title, body =:body, is_status = :is_status, updated_at = :updated_at WHERE id =$id"
          );
          $articles->bindParam(':updated_at', $updated_at_keep, PDO::PARAM_INT);
          // 投稿日の判定「変更あり」の場合
        } else {
          $articles = $pdo->prepare(
            "UPDATE articles SET title =:title, body =:body, is_status = :is_status, updated_at = now() WHERE id =$id"
          );
        }
        $articles->bindParam(':title', $title, PDO::PARAM_STR);
        $articles->bindParam(':body', $body, PDO::PARAM_STR);
        $articles->bindParam(':is_status', $is_status, PDO::PARAM_INT);
        $articles->execute();
      } catch (PDOException $Exception) {
        die('接続エラー：' . $Exception->getMessage());
      }
    }

    // 格納に成功すれば記事一覧画面に遷移
    header("location:../view_admin/article_index.php");
  }


  // 記事の削除
  public function delete()
  {
    $id = $_POST['id'];
    try {
      // DBに接続
      $pdo = $this->db_connect();
      // SQL文 一致したidの全データを削除
      $article = $pdo->prepare(
        "DELETE FROM articles WHERE id=:id"
      );
      $article->bindParam(':id', $id, PDO::PARAM_INT);
      $article->execute();
    } catch (PDOException $Exception) {
      die('接続エラー：' . $Exception->getMessage());
    }
    $message = "記事を削除しました。";
    return $message;
  }
}
