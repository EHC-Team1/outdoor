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

  // 
  public function input()
  {
  }

  // カート内商品の表示
  public function index()
  {
    try {
      // DBに接続
      $pdo = $this->db_connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $cart_items = $pdo->prepare(
        "SELECT cart_items.*,
        items.name, items.price FROM cart_items LEFT JOIN items ON cart_items.item_id = items.id ORDER BY updated_at"
      );
      $cart_items->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $cart_items;
  }

  // カート内商品の更新
  public function update()
  {
  }

  // カート内商品の削除
  public function delete()
  {
    $id = $_POST['id'];
    try {
      // DBに接続
      $pdo = $this->db_connect();
      $cart_items = $pdo->prepare(
        "DELETE FROM cart_items WHERE id=:id"
      );
      $cart_items->bindParam(':id', $id, PDO::PARAM_INT);
      $cart_items->execute();
    } catch (PDOException $Exception) {
      die('接続エラー：' . $Exception->getMessage());
    }
    
    header('Location: cart_item_index.php');
  }
}
