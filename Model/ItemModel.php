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
  }

  // 商品の詳細表示
  public function show()
  {
  }

  // 商品の一覧表示
  public function index()
  {
  }

  // 該当ジャンル商品の一覧表示
  public function genre_index()
  {
  }

  // 検索該当商品の一覧表示
  public function search_index()
  {
  }

  // 商品の編集
  public function edit()
  {
  }

  // 商品の更新
  public function update()
  {
  }

  // 商品の削除
  public function delete()
  {
  }
}
