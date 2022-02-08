<?php
class GenreModel
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

  // ジャンルの登録
  public function input()
  {
  }

  // ジャンルの一覧表示
  public function index()
  {
    try {
      $pdo = $this->db_connect();
      $genres = $pdo->prepare(
        "SELECT * FROM genres"
      );
      $genres->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    return $genres;
  }

  // ジャンルの編集
  public function edit()
  {
  }

  // ジャンルの更新
  public function update()
  {
  }

  // ジャンルの削除
  public function delete()
  {
  }
}
