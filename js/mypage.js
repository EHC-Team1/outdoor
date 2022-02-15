// 配送先の削除ボタン押下時のアラート
$('#delivery_delete_btn').click(function () {
  if (window.confirm("配送先を削除しますか？")) {
    location.href = "mypage.php";
  } else {
    window.alert("キャンセルされました");
  }
  return false;
});