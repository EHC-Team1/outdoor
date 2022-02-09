<?php
class OrderModel
{
  protected $pdo;
  const USER = 'root';
  const PASS = '';
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
