// ジャンル名が入力されていない場合に「更新」ボタンが押された際のキャンセルとアラート
$('#genre_edit_btn').click(function () {
	var genre_name = document.getElementById("genre_edit_input").value;
	if (Number(genre_name) == "") {
		alert("ジャンル名を入力してください。");
		return false;
	}
});

// ジャンル「削除」ボタン押下時のアラート
$('.btn-outline-danger').click(function () {
  if (window.confirm('すべての商品が同時に削除されます。\nジャンルを削除しますか？')) {
  } else {
    return false;
  }
});