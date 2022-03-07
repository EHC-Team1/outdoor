// 配送先の削除ボタン押下時のアラート
$('.btn-outline-danger').click(function () {
  if (window.confirm("配送先を削除しますか？")) {
  } else {
    return false;
  }
});