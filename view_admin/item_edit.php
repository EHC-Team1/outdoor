<?php
session_start();

// ItemModelファイルを呼び出し
require_once('../Model/ItemModel.php');
// Itemクラスを呼び出し
$pdo = new ItemModel();
// editメソッドを呼び出し
$item = $pdo->edit();
?>

<?php require_once '../view_common/header.php'; ?>


<?php require_once '../view_common/footer.php'; ?>