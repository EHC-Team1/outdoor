// 記事の削除ボタン押下時のアラート
$('#article_delete_btn').click(function () {
  if (window.confirm("記事を削除しますか？")) {
  } else {
    return false;
  }
});