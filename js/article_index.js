// 記事の削除ボタン押下時のアラート
$('.btn-outline-danger').click(function () {
  if (window.confirm("記事を削除しますか？")) {
  } else {
    return false;
  }
});