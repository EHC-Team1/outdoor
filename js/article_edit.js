// 「記事を更新する」ボタン押下時のアラート
$('#article_update_btn').click(function () {
  // 必須項目の入力チェック
  var title = document.getElementById("article_update_title").value;
  var body = document.getElementById("article_update_body").value;

  if (Number(title) == "" || Number(body) == ""){
    alert("画像以外は必須項目です");
    return false;
  }

  // 更新に成功した場合
  value = $('#success-outlined').prop("checked");
  if (value == true) {
    alert("公開設定で、記事を更新しました。");
  } else {
    alert("非公開設定で、記事を更新しました。");
  }
});

// 記事の削除ボタン押下時のアラート
$('#delete_btn').click(function () {
  if (window.confirm("記事を削除しますか？")) {
    alert("記事を削除しました。");
  } else {
    return false;
  }
});