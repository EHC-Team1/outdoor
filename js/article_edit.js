// 「記事を更新する」ボタン押下時のアラート
$('#article_update_btn').click(function () {
  // 必須項目の入力チェック
  var title = document.getElementById("article_update_title").value;
  var body = document.getElementById("article_update_body").value;
  if (title == "" || body == "") {
    alert("画像以外は必須項目です");
    return false;
  }

  // 更新に成功した場合
    alert("記事を更新しました。");
});