<?php
if (isset($_GET["target"]) && $_GET["target"] !== "") {
  $target = $_GET["target"];
} else {
  return false;
}

$MIMETypes = array(
  'png' => 'image/png',
  'jpeg' => 'image/jpeg',
  'gif' => 'image/gif',
);

try {
  $user = "root";
  $pass = "password";
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=outdoor;charset=utf8", $user, $pass);
  $stmt = $pdo->prepare("SELECT extension, raw_data FROM articles WHERE article_image = :target;");
  $stmt->bindValue(":target", $target, PDO::PARAM_STR);
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  header("Content-Type: " . $MIMETypes[$row["extension"]]);
  echo ($row["raw_data"]);
} catch (PDOException $Exception) {
  die('接続エラー：' . $Exception->getMessage());
}
