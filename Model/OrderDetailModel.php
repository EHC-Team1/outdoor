<?php
class OrderDetailModel
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

  // 注文詳細の保存
  public function input()
  {
    $order_id = $_POST['order_id'];
    $item_id = $_POST['item_id'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    try {
      // DBに接続
      $pdo = $this->db_connect();
      $order_detail = $pdo->prepare(
        "INSERT INTO order_details (order_id, item_id, price, quantity) VALUES(:order_id, :item_id, :price, :quantity)"
      );
      $order_detail->bindParam(':order_id', $order_id, PDO::PARAM_INT);
      $order_detail->bindParam(':item_id', $item_id, PDO::PARAM_STR);
      $order_detail->bindParam(':price', $price, PDO::PARAM_STR);
      $order_detail->bindParam(':quantity', $quantity, PDO::PARAM_STR);
      $order_detail->execute();
    } catch (PDOException $Exception) {
      die('接続エラー：' . $Exception->getMessage());
    }
    header('Location: public_order_check.php');
  }

  // 注文履歴詳細画面の表示
  public function show()
  {
  }

}
