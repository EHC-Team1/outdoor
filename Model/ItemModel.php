  <?php
  class ItemModel
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

    // 商品の登録
    public function input()
    {
      $genre_id = $_POST['genre_id'];
      $article_id = $_POST['article_id'];
      $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
      $introduction = htmlspecialchars($_POST['introduction'], ENT_QUOTES, 'UTF-8');
      $item_image = $_FILES['item_image'];
      $price = $_POST['price'];
      // 購入ステータスの判定
      if ($_POST['is_status'] == "buy_able") {
        $is_status = 1;
      } else {
        $is_status = 0;
      }

      // 必須項目が入力されているかチェック
      if ($genre_id && $article_id && $name && $introduction && $price) {

        // 画像ファイルがある場合
        if (isset($item_image['error']) && is_int($item_image['error']) && $item_image["name"] !== "") {
          // ファイルの内容をすべて読み込む
          $raw_data = file_get_contents($item_image['tmp_name']);
          // 拡張子を取り出し、ファイルの形式を判別する
          $tmp = pathinfo($item_image['name']);
          $extension = $tmp["extension"];
          if ($extension === "jpg" || $extension === "jpeg" || $extension === "JPG" || $extension === "JPEG") {
            $extension = "jpeg";
          } elseif ($extension === "png" || $extension === "PNG") {
            $extension = "png";
          } elseif ($extension === "gif" || $extension === "GIF") {
            $extension = "gif";
          } else {
            // echo "非対応のファイルです";
            // echo ("<button onclick=location.href='../view_admin/admin_item_index.php' class=btn btn-outline-secondary btn-lg>戻る</button>");
            $message = "セキュリティの都合上、このファイル形式は許可できません。別の画像ファイルを使用してください。";
            return $message;
          }
          try {
            // db_connectメソッドを呼び出す
            $pdo = $this->db_connect();
            $date = getdate();
            // DBに格納するファイル名を設定
            $item_image = $item_image['tmp_name'] . $date["year"] . $date["mon"] . $date["mday"] . $date["hours"] . $date["minutes"] . $date["seconds"];
            $item_image = hash("sha256", $item_image);
            // DBにデータを格納
            $item = $pdo->prepare(
              "INSERT INTO items(genre_id, article_id, name, introduction, price, item_image, extension, raw_data, is_status, created_at, updated_at) VALUES (:genre_id, :article_id, :name, :introduction, :price, :item_image, :extension, :raw_data, :is_status, now(), now());"
            );
            $item->bindParam(':genre_id', $genre_id, PDO::PARAM_INT);
            $item->bindParam(':article_id', $article_id, PDO::PARAM_INT);
            $item->bindParam(':name', $name, PDO::PARAM_STR);
            $item->bindParam(':introduction', $introduction, PDO::PARAM_STR);
            $item->bindParam(':price', $price, PDO::PARAM_STR);
            $item->bindValue(":item_image", $item_image, PDO::PARAM_STR);
            $item->bindValue(":extension", $extension, PDO::PARAM_STR);
            $item->bindValue(":raw_data", $raw_data, PDO::PARAM_STR);
            $item->bindParam(':is_status', $is_status, PDO::PARAM_INT);
            $item->execute();
          } catch (PDOException $Exception) {
            die('接続エラー：' . $Exception->getMessage());
          }

          // 画像ファイルがない場合
        } else {
          try {
            // db_connectメソッドを呼び出す
            $pdo = $this->db_connect();
            // DBにデータを格納
            $item = $pdo->prepare(
              "INSERT INTO items(genre_id, article_id, name, introduction, price, is_status, created_at, updated_at) VALUES (:genre_id, :article_id, :name, :introduction, :price, :is_status, now(), now());"
            );
            $item->bindParam(':genre_id', $genre_id, PDO::PARAM_INT);
            $item->bindParam(':article_id', $article_id, PDO::PARAM_INT);
            $item->bindParam(':name', $name, PDO::PARAM_STR);
            $item->bindParam(':introduction', $introduction, PDO::PARAM_STR);
            $item->bindParam(':price', $price, PDO::PARAM_STR);
            $item->bindParam(':is_status', $is_status, PDO::PARAM_INT);
            $item->execute();
          } catch (PDOException $Exception) {
            die('接続エラー：' . $Exception->getMessage());
          }
        }
        // 格納に成功すれば商品一覧画面に遷移
        header('Location: ../view_admin/admin_item_index.php');

        // 必須項目が入力されていなければ入力画面にリダイレクト
      } else {
        $message = "画像以外は必須項目です";
        return $message;
        header('Location: ../view_admin/item_input.php');
      }
    }

    // admin_item_indexページング用データ数取得
    public function page_count_admin_index()
    {
      try {
        $pdo = $this->db_connect();
        $pages = $pdo->prepare(
          "SELECT COUNT(*) id FROM items"
        );
        $pages->execute();
      } catch (PDOException $Exception) {
        exit("接続エラー：" . $Exception->getMessage());
      }
      return $pages;
    }

    // admin側のため全表示
    // 商品の一覧表示
    public function admin_index($start)
    {
      $start = $start;
      try {
        $pdo = $this->db_connect();
        $items = $pdo->prepare(
          "SELECT items.id AS id, items.name AS item_name, items.price AS price, items.item_image AS item_image, items.extension AS extension, items.is_status AS is_status, genres.name AS genre_name FROM items, genres WHERE items.genre_id = genres.id ORDER BY items.updated_at DESC LIMIT {$start}, 15"
        );
        $items->execute();
      } catch (PDOException $Exception) {
        exit("接続エラー：" . $Exception->getMessage());
      }
      return $items;
    }

    // admin_genre_indexページング用データ数取得
    public function page_count_admin_genre_index($genre_id)
    {
      try {
        $pdo = $this->db_connect();
        $pages = $pdo->prepare(
          "SELECT COUNT(*) id FROM items WHERE genre_id = $genre_id"
        );
        $pages->execute();
      } catch (PDOException $Exception) {
        exit("接続エラー：" . $Exception->getMessage());
      }
      return $pages;
    }

    // 管理側該当ジャンル商品一覧
    public function admin_genre_index($genre_id, $start)
    {
      $genre_id = $genre_id;
      $start = $start;
      try {
        // db_connectメソッドを呼び出す
        $pdo = $this->db_connect();
        $items = $pdo->prepare(
          "SELECT * FROM items WHERE items.genre_id = $genre_id ORDER BY items.updated_at DESC LIMIT {$start}, 16"
        );
        $items->execute();
      } catch (PDOException $Exception) {
        exit("接続エラー：" . $Exception->getMessage());
      }
      return $items;
    }

    // 商品の編集
    public function edit($item_id)
    {
      $item_id = $item_id;
      try {
        // db_connectメソッドを呼び出す
        $pdo = $this->db_connect();
        $item = $pdo->prepare(
          "SELECT items.id AS item_id, items.name AS item_name, items.introduction AS introduction, items.price AS price, items.item_image AS item_image, items.extension AS extension, items.is_status AS is_status, genres.id AS genre_id, genres.name AS genre_name, items.article_id AS article_id, articles.title AS article_title FROM items, genres, articles WHERE items.genre_id = genres.id AND items.article_id = articles.id AND items.id = $item_id"
        );
        $item->execute();
      } catch (PDOException $Exception) {
        exit("接続エラー：" . $Exception->getMessage());
      }
      return $item;
    }

    // 商品の更新
    public function update($item)
    {
      $item = $item;
      $item_id = $item['item_id'];
      $genre_id = $_POST['genre_id'];
      $article_id = $_POST['article_id'];
      $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
      $introduction = htmlspecialchars($_POST['introduction'], ENT_QUOTES, 'UTF-8');
      $item_image = $_FILES['item_image'];
      $price = $_POST['price'];
      // 購入ステータスの判定
      if ($_POST['is_status'] == "buy_able") {
        $is_status = 1;
      } else {
        $is_status = 0;
      }
      // 画像削除ボタンの判定
      // if ($_POST['delete_image']) {
      if (isset($_POST['delete_image'])) {
        $delete_image = 1;
      }

      // 画像ファイルがあるかチェック
      // 画像ファイルがある場合
      if (isset($item_image['error']) && is_int($item_image['error']) && $item_image["name"] !== "") {
        // ファイルの内容をすべて読み込む
        $raw_data = file_get_contents($item_image['tmp_name']);
        // 拡張子を取り出し、ファイルの形式を判別する
        $tmp = pathinfo($item_image['name']);
        $extension = $tmp["extension"];
        if ($extension === "jpg" || $extension === "jpeg" || $extension === "JPG" || $extension === "JPEG") {
          $extension = "jpeg";
        } elseif ($extension === "png" || $extension === "PNG") {
          $extension = "png";
        } elseif ($extension === "gif" || $extension === "GIF") {
          $extension = "gif";
        } else {
          // echo "非対応のファイルです";
          // echo ("<button onclick=location.href='../view_admin/admin_item_index.php' class=btn btn-outline-secondary btn-lg>戻る</button>");
          $message = "セキュリティの都合上、このファイル形式は許可できません。別の画像ファイルを使用してください。";
          return $message;
        }
        try {
          // db_connectメソッドを呼び出す
          $pdo = $this->db_connect();
          $date = getdate();
          // DBに格納するファイル名を設定
          $item_image = $item_image['tmp_name'] . $date["year"] . $date["mon"] . $date["mday"] . $date["hours"] . $date["minutes"] . $date["seconds"];
          $item_image = hash("sha256", $item_image);
          // DBにデータを格納
          $item = $pdo->prepare(
            "UPDATE items SET genre_id = :genre_id, article_id = :article_id, name = :name, introduction = :introduction, price = :price, item_image = :item_image, extension = :extension, raw_data = :raw_data, is_status = :is_status, updated_at = now() WHERE id = $item_id"
          );
          $item->bindParam(':genre_id', $genre_id, PDO::PARAM_INT);
          $item->bindParam(':article_id', $article_id, PDO::PARAM_INT);
          $item->bindParam(':name', $name, PDO::PARAM_STR);
          $item->bindParam(':introduction', $introduction, PDO::PARAM_STR);
          $item->bindParam(':price', $price, PDO::PARAM_STR);
          $item->bindValue(":item_image", $item_image, PDO::PARAM_STR);
          $item->bindValue(":extension", $extension, PDO::PARAM_STR);
          $item->bindValue(":raw_data", $raw_data, PDO::PARAM_STR);
          $item->bindParam(':is_status', $is_status, PDO::PARAM_INT);
          $item->execute();
        } catch (PDOException $Exception) {
          die('接続エラー：' . $Exception->getMessage());
        }

        // 「画像を削除」ボタンが押されている場合
      } elseif ($delete_image) {
        try {
          // db_connectメソッドを呼び出す
          $pdo = $this->db_connect();
          // DBにデータを格納
          $item = $pdo->prepare(
            "UPDATE items SET genre_id = :genre_id, article_id = :article_id, name = :name, introduction = :introduction, price = :price, item_image = :item_image, extension = :extension, raw_data = :raw_data, is_status = :is_status, updated_at = now() WHERE id = $item_id"
          );
          $item->bindParam(':genre_id', $genre_id, PDO::PARAM_INT);
          $item->bindParam(':article_id', $article_id, PDO::PARAM_INT);
          $item->bindParam(':name', $name, PDO::PARAM_STR);
          $item->bindParam(':introduction', $introduction, PDO::PARAM_STR);
          $item->bindParam(':price', $price, PDO::PARAM_STR);
          $item->bindValue(":item_image", "", PDO::PARAM_STR);
          $item->bindValue(":extension", "", PDO::PARAM_STR);
          $item->bindValue(":raw_data", "", PDO::PARAM_STR);
          $item->bindParam(':is_status', $is_status, PDO::PARAM_INT);
          $item->execute();
        } catch (PDOException $Exception) {
          die('接続エラー：' . $Exception->getMessage());
        }

        // 新規画像が選択されてない＆「画像を削除」ボタンが押されていない場合
      } else {
        try {
          // db_connectメソッドを呼び出す
          $pdo = $this->db_connect();
          // DBにデータを格納
          $item = $pdo->prepare(
            "UPDATE items SET genre_id = :genre_id, article_id = :article_id, name = :name, introduction = :introduction, price = :price, is_status = :is_status, updated_at = now() WHERE id = $item_id"
          );
          $item->bindParam(':genre_id', $genre_id, PDO::PARAM_INT);
          $item->bindParam(':article_id', $article_id, PDO::PARAM_INT);
          $item->bindParam(':name', $name, PDO::PARAM_STR);
          $item->bindParam(':introduction', $introduction, PDO::PARAM_STR);
          $item->bindParam(':price', $price, PDO::PARAM_STR);
          $item->bindParam(':is_status', $is_status, PDO::PARAM_INT);
          $item->execute();
        } catch (PDOException $Exception) {
          die('接続エラー：' . $Exception->getMessage());
        }
      }
      // 更新成功で商品一覧画面に遷移
      header('Location: ../view_admin/admin_item_index.php');
    }

    // 商品の削除
    public function delete()
    {
      $id = $_POST['id'];
      try {
        // DBに接続
        $pdo = $this->db_connect();
        $item = $pdo->prepare(
          "DELETE FROM items WHERE id = $id"
        );
        $item->execute();
      } catch (PDOException $Exception) {
        die('接続エラー：' . $Exception->getMessage());
      }
      $message = "商品が削除されました。";
      return $message;
    }

    // public_item_indexページング用データ数取得
    public function page_count_public_index()
    {
      try {
        $pdo = $this->db_connect();
        $pages = $pdo->prepare(
          "SELECT COUNT(*) id FROM items WHERE is_status = 1"
        );
        $pages->execute();
      } catch (PDOException $Exception) {
        exit("接続エラー：" . $Exception->getMessage());
      }
      return $pages;
    }

    // public側
    // 商品の一覧表示
    public function public_index($start)
    {
      $start = $start;
      try {
        $pdo = $this->db_connect();
        $items = $pdo->prepare(
          "SELECT items.id AS id, items.name AS item_name, items.price AS price, items.item_image AS item_image, items.extension AS extension, items.is_status AS is_status, genres.name AS genre_name FROM items, genres WHERE items.genre_id = genres.id AND items.is_status = 1 ORDER BY items.updated_at DESC LIMIT {$start}, 16"
        );
        $items->execute();
      } catch (PDOException $Exception) {
        exit("接続エラー：" . $Exception->getMessage());
      }
      return $items;
    }

    // 商品の詳細表示
    public function show($item_id)
    {
      $item_id = $item_id;
      try {
        // db_connectメソッドを呼び出す
        $pdo = $this->db_connect();
        $item = $pdo->prepare(
          "SELECT items.id AS item_id, items.name AS item_name, items.introduction AS introduction, items.price AS price, items.item_image AS item_image, items.extension AS item_extension, genres.name AS genre_name, items.article_id AS article_id, articles.is_status AS article_is_status FROM items, genres, articles WHERE items.genre_id = genres.id AND items.article_id = articles.id AND items.id = $item_id AND items.is_status = 1"
        );
        $item->execute();
      } catch (PDOException $Exception) {
        exit("接続エラー：" . $Exception->getMessage());
      }
      return $item;
    }

    // genre_indexページング用データ数取得
    public function page_count_public_genre_index($genre_id)
    {
      $genre_id = $genre_id;
      try {
        $pdo = $this->db_connect();
        $pages = $pdo->prepare(
          "SELECT COUNT(*) id FROM items WHERE genre_id = $genre_id AND is_status = 1"
        );
        $pages->execute();
      } catch (PDOException $Exception) {
        exit("接続エラー：" . $Exception->getMessage());
      }
      return $pages;
    }

    // 顧客側該当ジャンル商品の一覧表示
    public function public_genre_index($genre_id, $start)
    {
      $genre_id = $genre_id;
      $start = $start;
      try {
        // db_connectメソッドを呼び出す
        $pdo = $this->db_connect();
        $items = $pdo->prepare(
          "SELECT * FROM items WHERE items.genre_id = $genre_id AND items.is_status = 1 ORDER BY items.updated_at DESC LIMIT {$start}, 16"
        );
        $items->execute();
      } catch (PDOException $Exception) {
        exit("接続エラー：" . $Exception->getMessage());
      }
      return $items;
    }

    // 検索該当商品の一覧表示
    public function search_index()
    {
      $keyword = $_POST['keyword'];
      try {
        $pdo = $this->db_connect();
        $search_items = $pdo->prepare(
          "SELECT items.id AS item_id, items.name AS item_name, items.price AS price, items.item_image AS item_image, items.extension AS extension, genres.name AS genre_name FROM items, genres WHERE items.introduction LIKE CONCAT('%',:keyword,'%') AND items.is_status = 1 AND items.genre_id = genres.id ORDER BY items.updated_at DESC"
        );
        $search_items->bindValue(':keyword', $keyword);
        $search_items->execute();
      } catch (PDOException $Exception) {
        exit("接続エラー：" . $Exception->getMessage());
      }
      return $search_items;
    }

    public function switch()
    {
      $item_id = $_POST['id'];
      $item_status = $_POST['item_status'];
      if ($item_status == 1) {
        try {
          $pdo = $this->db_connect();
          $switch_status = $pdo->prepare(
            "UPDATE items SET is_status = :is_status WHERE id = $item_id"
          );
          $switch_status->bindParam(':is_status', 0, PDO::PARAM_INT);
          $switch_status->execute();
        } catch (PDOException $Exception) {
          exit("接続エラー：" . $Exception->getMessage());
        }
      } else {
        $pdo = $this->db_connect();
        $switch_status = $pdo->prepare(
          "UPDATE items SET is_status = :is_status WHERE id = $item_id"
        );
        $switch_status->bindParam(':is_status', 1, PDO::PARAM_INT);
        $switch_status->execute();
      }
    }
  }
