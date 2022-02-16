<?php
class ArticleModel
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

  // 記事の登録
  public function input()
  {
  }

  // 記事の詳細表示
  public function show()
  {
  }

  // 記事の一覧表示
  public function index()
  {

    try {
      // DBに接続
      $pdo = $this->db_connect();
      // DBからarticlesテーブルの全データを投稿日時の降順で取得
      $articles = $pdo->prepare(
        "SELECT * FROM articles ORDER BY created_at DESC;"
      );
      $articles->execute();
    } catch (PDOException $Exception) {
      exit("接続エラー：" . $Exception->getMessage());
    }
    // $articlesを返す
    return $articles;
  }

  // 該当ジャンルの商品の一覧
  public function genre_index()
  {
  }

  // 記事の検索
  public function search_index()
  {
  }

  // 記事の編集
  public function edit()
  {
  }

  // 記事の更新
  public function update()
  {
  }

  // 記事の削除
  public function delete()
  {
  }
}
