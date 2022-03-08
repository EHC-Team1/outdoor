<?php
class OrderModel
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

  // 注文情報の保存
  public function input()
  {
    $customer_id = $_POST['customer_id'];
    $postal_code = $_POST['postal_code'];
    $address = $_POST['address'];
    $house_num = $_POST['house_num'];
    $orderer_name = $_POST['orderer_name'];
    $postage = $_POST['postage'];
    $total_payment = $_POST['total_payment'];
    $payment_way = $_POST['payment_way'];
    try {
      // DBに接続
      $pdo = $this->db_connect();
      $order = $pdo->prepare(
        "INSERT INTO orders (customer_id, postal_code, address, house_num, orderer_name, postage, total_payment, payment_way) VALUES(:customer_id, :postal_code, :address, :house_num, :orderer_name, :postage, :total_payment, :payment_way)"
      );
      $order->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
      $order->bindParam(':postal_code', $postal_code, PDO::PARAM_STR);
      $order->bindParam(':address', $address, PDO::PARAM_STR);
      $order->bindParam(':house_num', $house_num, PDO::PARAM_STR);
      $order->bindParam(':orderer_name', $orderer_name, PDO::PARAM_STR);
      $order->bindParam(':postage', $postage, PDO::PARAM_INT);
      $order->bindParam(':total_payment', $total_payment, PDO::PARAM_INT);
      $order->bindParam(':payment_way', $payment_way, PDO::PARAM_INT);
      $order->execute();
      $order_id = $pdo->lastInsertId();
    } catch (PDOException $Exception) {
      die('接続エラー：' . $Exception->getMessage());
    }
    return $order_id;
  }

  // 注文情報確認画面の表示
  public function check()
  {
  }

  // 注文完了画面の表示
  public function complete()
  {
  }

  // public側
  // 注文履歴一覧画面の表示
  public function index($start)
  {
    $customer_id = $_SESSION['customer']['id'];
    $start = $start;
    try {
      // DBに接続
      $pdo = $this->db_connect();
      $orders = $pdo->prepare(
        "SELECT * FROM orders WHERE customer_id = $customer_id ORDER BY orders.updated_at DESC LIMIT {$start}, 10"
      );
      $orders->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $orders;
  }

  // public_order_indexページング用データ数取得
  public function page_count_public_index()
  {
    $customer_id = $_SESSION['customer']['id'];
    try {
      $pdo = $this->db_connect();
      $pages = $pdo->prepare(
        "SELECT COUNT(*) id FROM orders WHERE customer_id = $customer_id"
      );
      $pages->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $pages;
  }

  // admin側
  // 注文履歴一覧画面の表示
  public function admin_index($start)
  {
    $start = $start;
    try {
      // DBに接続
      $pdo = $this->db_connect();
      $orders = $pdo->prepare(
        "SELECT orders.*, customers.name_first, customers.name_last FROM orders LEFT JOIN customers ON orders.customer_id = customers.id ORDER BY orders.updated_at DESC LIMIT {$start}, 10"
      );
      $orders->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $orders;
  }

  // ページング用データ数取得
  public function page_count_admin_index()
  {
    try {
      // DBに接続
      $pdo = $this->db_connect();
      $pages = $pdo->prepare(
        "SELECT COUNT(*) id FROM orders"
      );
      $pages->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $pages;
  }

  // 注文履歴詳細画面の表示
  public function show($order_id)
  {
    $order_id = $order_id;
    try {
      // DBに接続
      $pdo = $this->db_connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $order = $pdo->prepare(
        "SELECT * FROM orders WHERE id = $order_id"
      );
      $order->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $order;
  }

  // 注文履歴詳細画面の表示
  public function admin_show($customer_id, $order_id)
  {
    $customer_id = $customer_id;
    $order_id = $order_id;
    try {
      // DBに接続
      $pdo = $this->db_connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $orders = $pdo->prepare(
        "SELECT orders.*, customers.name_first, customers.name_last FROM orders LEFT JOIN customers ON orders.customer_id = customers.id WHERE orders.customer_id = $customer_id"
      );
      $orders->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $orders;
  }
}
