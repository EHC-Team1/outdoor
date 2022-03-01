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

  // 注文情報入力画面の表示
  public function input()
  {
    // $customer_id = $_POST['customer_id'];
    // $postal_code = htmlspecialchars($_POST['postal_code'], ENT_QUOTES, 'UTF-8');
    // $address = htmlspecialchars($_POST['address'], ENT_QUOTES, 'UTF-8');
    // $order_name = htmlspecialchars($_POST['order_name'], ENT_QUOTES, 'UTF-8');
    // $postage = htmlspecialchars($_POST['postage'], ENT_QUOTES, 'UTF-8');
    // $total_payment = htmlspecialchars($_POST['total_payment'], ENT_QUOTES, 'UTF-8');
    // $payment_way = htmlspecialchars($_POST['payment_way'], ENT_QUOTES, 'UTF-8');

    // try {
    //   // DBに接続
    //   $pdo = $this->db_connect();
    //   $order = $pdo->prepare(
    //     "INSERT INTO orders (customer_id, postal_code, address, order_name, postage, total_payment, payment_way) VALUES(:customer_id, :postal_code, :address, :order_name, :postage, :total_payment, :payment_way)"
    //   );
    //   $order->bindParam(':customer_id', $customer_id, PDO::PARAM_STR);
    //   $order->bindParam(':postal_code', $postal_code, PDO::PARAM_STR);
    //   $order->bindParam(':address', $address, PDO::PARAM_STR);
    //   $order->bindParam(':order_name', $order_name, PDO::PARAM_STR);
    //   $order->bindParam(':postage', $postage, PDO::PARAM_STR);
    //   $order->bindParam(':total_payment', $total_payment, PDO::PARAM_STR);
    //   $order->bindParam(':payment_way', $payment_way, PDO::PARAM_STR);
    //   $order->execute();
    // } catch (PDOException $Exception) {
    //   die('接続エラー：' . $Exception->getMessage());
    // }
    // header('Location: public_order_check.php');
  }

  // 注文情報確認画面の表示
  public function check()
  {
  }

  // 注文完了画面の表示
  public function complete()
  {
  }

  // 注文履歴一覧画面の表示
  public function index()
  {
  }

  // 注文履歴詳細画面の表示
  public function show()
  {
  }

}
