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
  public function input($order_id, $cart_items)
  {
    $order_id = $order_id;
    $cart_items = $cart_items;
    foreach ($cart_items as $cart_item) {
      try {
        // DBに接続
        $pdo = $this->db_connect();
        $order_detail = $pdo->prepare(
          "INSERT INTO order_details (order_id, item_id, price, quantity) VALUES(:order_id, :item_id, :price, :quantity)"
        );
        $order_detail->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $order_detail->bindParam(':item_id', $cart_item['item_id'], PDO::PARAM_INT);
        $order_detail->bindParam(':price', $cart_item['price'], PDO::PARAM_INT);
        $order_detail->bindParam(':quantity', $cart_item['quantity'], PDO::PARAM_INT);
        $order_detail->execute();
      } catch (PDOException $Exception) {
        die('接続エラー：' . $Exception->getMessage());
      }
    }
    header('Location: public_order_complete.php');
  }

  // 注文履歴詳細画面の表示
  public function show($order_id)
  {
    try {
      // DBに接続
      $pdo = $this->db_connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $order_detail = $pdo->prepare(
        "SELECT order_details.*, items.name, items.price, orders.postal_code, orders.address, orders.house_num, orders.orderer_name, orders.postage, orders.total_payment, orders.payment_way, orders.created_at FROM order_details LEFT JOIN items ON order_details.item_id = items.id LEFT JOIN orders ON order_details.order_id = orders.id WHERE order_details.order_id = ? ORDER BY orders.created_at"
      );
      $order_detail->execute([$order_id]);
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $order_detail;
  }
}
