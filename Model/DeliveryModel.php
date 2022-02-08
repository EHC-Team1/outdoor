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
  }

  // 配送先の一覧表示
  public function index()
  {
  }

  // 配送先の編集
  public function edit()
  {
  }

  // 配送先の更新
  public function update()
  {
  }

  // 配送先の削除
  public function delete()
  {
  }
}
