<?php
class CartItemModel
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

  // カートに商品を追加
  public function input()
  {
    // 数量が選択されているかチェック
    if ($_POST['quantity']) {
      $item_id = $_POST['item_id'];
      $customer_id = $_SESSION['customer']['id'];

      //商品が登録されているかチェック
      $pdo = $this->db_connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $item = $pdo->prepare(
        "SELECT item_id, quantity FROM cart_items WHERE item_id = $item_id"
      );
      $item->execute();
      $item = $item->fetch(PDO::FETCH_ASSOC);
      //商品がカートにあれば数量追加処理
      if ($item['item_id']) {
        $quantity = $_POST['quantity'] + $item['quantity'];
        try {
          // DBに接続
          $pdo = $this->db_connect();
          $cart_items = $pdo->prepare(
            "UPDATE cart_items SET quantity = :quantity WHERE item_id = $item_id"
          );
          $cart_items->bindParam(':quantity', $quantity, PDO::PARAM_INT);
          $cart_items->execute();
        } catch (PDOException $Exception) {
          die('接続エラー：' . $Exception->getMessage());
        }

        //商品がカートに存在していない場合
      } else {
        $quantity = $_POST['quantity'];
        try {
          // DBに接続
          $pdo = $this->db_connect();
          $cart_items = $pdo->prepare(
            "INSERT INTO cart_items (item_id, customer_id, quantity, created_at, updated_at) VALUES (:item_id, :customer_id, :quantity, now(), now())"
          );
          $cart_items->bindParam(':item_id', $item_id, PDO::PARAM_INT);
          $cart_items->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
          $cart_items->bindParam(':quantity', $quantity, PDO::PARAM_INT);
          $cart_items->execute();
        } catch (PDOException $Exception) {
          die('接続エラー：' . $Exception->getMessage());
        }
      }
      // 追加されればカート商品一覧画面に遷移
      header('Location: cart_item_index.php');

      // 数量が入っていなければリダイレクト
    } else {
      $message = "数量を選択してください。";
      return $message;
    }
  }

  // カート内商品件数取得
  public function count_cart_items()
  {
    $id = $_SESSION['customer']['id'];
    try {
      $pdo = $this->db_connect();
      $count_cart_items = $pdo->prepare(
        "SELECT COUNT(*) id FROM cart_items WHERE customer_id = $id"
      );
      $count_cart_items->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $count_cart_items;
  }

  // カート内商品の表示
  public function index()
  {
    try {
      // DBに接続
      $pdo = $this->db_connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $cart_items = $pdo->prepare(
        "SELECT cart_items.*, items.name, items.price, items.item_image, items.extension FROM cart_items LEFT JOIN items ON cart_items.item_id = items.id WHERE cart_items.customer_id = ? ORDER BY created_at"
      );
      $cart_items->execute(
        array(
          $_SESSION['customer']['id']
        )
      );
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $cart_items;
  }

  // カート内商品の更新
  public function update()
  {
    $id = $_POST['cart_item_id'];
    $quantity = $_POST['quantity'];
    try {
      // DBに接続
      $pdo = $this->db_connect();
      $cart_item = $pdo->prepare(
        "UPDATE cart_items SET quantity = $quantity WHERE id = $id"
      );
      $cart_item->execute();
    } catch (PDOException $Exception) {
      die('接続エラー：' . $Exception->getMessage());
    }
  }

  // カート内商品の削除
  public function delete()
  {
    $id = $_POST['id'];
    try {
      // DBに接続
      $pdo = $this->db_connect();
      $cart_items = $pdo->prepare("DELETE FROM cart_items WHERE id = :id");
      $cart_items->bindParam(':id', $id, PDO::PARAM_INT);
      $cart_items->execute();
    } catch (PDOException $Exception) {
      die('接続エラー：' . $Exception->getMessage());
    }
    header('Location: cart_item_index.php');
  }

  // カート内商品を全削除
  public function all_delete()
  {
    try {
      // DBに接続
      $pdo = $this->db_connect();
      $cart_items = $pdo->prepare("DELETE FROM cart_items");
      $cart_items->execute();
    } catch (PDOException $Exception) {
      die('接続エラー：' . $Exception->getMessage());
    }
    header('Location: cart_item_index.php');
  }
}
