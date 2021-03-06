<?php
class DeliveryModel
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

  // 配送先の登録
  public function input()
  {
    $customer_id = $_POST['customer_id'];
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $postal_code = htmlspecialchars($_POST['postal_code'], ENT_QUOTES, 'UTF-8');
    $address = htmlspecialchars($_POST['address'], ENT_QUOTES, 'UTF-8');
    $house_num = htmlspecialchars($_POST['house_num'], ENT_QUOTES, 'UTF-8');
    // 必要項目が入っているかチェック
    if (empty($name && $postal_code && $address && $house_num)) {
      // 入っていなければdelivery_input.phpへリダイレクト
      header('Location: delivery_input.php');
      $message = "必須項目を入力してください。";
      return $message;
    } else {
      try {
        // DBに接続
        $pdo = $this->db_connect();
        $delivery = $pdo->prepare(
          "INSERT INTO deliveries (customer_id, name, postal_code, address, house_num) VALUES(:customer_id, :name, :postal_code, :address, :house_num)"
        );
        $delivery->bindParam(':customer_id', $customer_id, PDO::PARAM_STR);
        $delivery->bindParam(':name', $name, PDO::PARAM_STR);
        $delivery->bindParam(':postal_code', $postal_code, PDO::PARAM_STR);
        $delivery->bindParam(':address', $address, PDO::PARAM_STR);
        $delivery->bindParam(':house_num', $house_num, PDO::PARAM_STR);
        $delivery->execute();
      } catch (PDOException $Exception) {
        die('接続エラー：' . $Exception->getMessage());
      }

      // 格納に成功すればマイページに遷移
      header('Location: mypage.php');
    }
  }

  public function show($delivery_id)
  {
    $id = $delivery_id;
    try {
      // DBに接続
      $pdo = $this->db_connect();
      $customers = $pdo->prepare(
        "SELECT * FROM deliveries WHERE id = $id"
      );
      $customers->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $customers;
  }

  // 配送先の一覧表示
  public function index()
  {
    $customer_id = $_SESSION['customer']['id'];
    try {
      // DBに接続
      $pdo = $this->db_connect();
      $deliveries = $pdo->prepare(
        "SELECT * FROM deliveries WHERE customer_id = $customer_id"
      );
      $deliveries->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $deliveries;
  }

  // 配送先の編集
  public function edit()
  {
    $id = $_POST['id'];
    try {
      // DBに接続
      $pdo = $this->db_connect();
      $delivery = $pdo->prepare(
        "SELECT * FROM deliveries WHERE id = $id"
      );
      $delivery->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $delivery;
  }

  // 配送先の更新
  public function update($delivery)
  {
    $delivery = $delivery;
    $delivery_id = $delivery['id'];
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $postal_code = htmlspecialchars($_POST['postal_code'], ENT_QUOTES, 'UTF-8');
    $address = htmlspecialchars($_POST['address'], ENT_QUOTES, 'UTF-8');
    $house_num = htmlspecialchars($_POST['house_num'], ENT_QUOTES, 'UTF-8');
    try {
      // DBに接続
      $pdo = $this->db_connect();
      $delivery = $pdo->prepare(
        "UPDATE deliveries SET name = :name, postal_code = :postal_code, address = :address, house_num = :house_num WHERE id = $delivery_id"
      );
      $delivery->bindParam(':name', $name, PDO::PARAM_STR);
      $delivery->bindParam(':postal_code', $postal_code, PDO::PARAM_STR);
      $delivery->bindParam(':address', $address, PDO::PARAM_STR);
      $delivery->bindParam(':house_num', $house_num, PDO::PARAM_STR);
      $delivery->execute();
    } catch (PDOException $Exception) {
      die('接続エラー：' . $Exception->getMessage());
      header('Location: mypage.php');
    }
  }

  // 配送先の削除
  public function delete()
  {
    $id = $_POST['id'];
    try {
      // DBに接続
      $pdo = $this->db_connect();
      $delivery = $pdo->prepare(
        "DELETE FROM deliveries WHERE id=:id"
      );
      $delivery->bindParam(':id', $id, PDO::PARAM_INT);
      $delivery->execute();
    } catch (PDOException $Exception) {
      die('接続エラー：' . $Exception->getMessage());
    }

    header('Location: mypage.php');
  }
}
