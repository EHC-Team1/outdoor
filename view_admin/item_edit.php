<?php
session_start();

// Messageクラスを呼び出し
require_once('../Model/ItemModel.php');
$pdo = new ItemModel();
// showメソッドを呼び出し
$item = $pdo->edit();
?>

<?php require_once '../view_common/header.php'; ?>


<?php require_once '../view_common/footer.php'; ?>