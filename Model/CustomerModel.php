<?php
class CustomerModel
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
      die('接続エラー' . $Exception->getMessage());
    }
    return $pdo;
  }

  // ユーザー情報一致確認
  public function check()
  {
  }

  // ユーザー登録
  public function input()
  {
  }

  // ユーザーログイン
  public function login()
  {
  }

  // ユーザー情報 登録内容確認
  public function show()
  {
  }

  //
  public function index()
  {
  }

  //ユーザー情報の編集
  public function edit()
  {
  }

  // ユーザー情報の更新
  public function update()
  {
  }
}
