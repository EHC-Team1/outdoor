// 配送先が入力されていない場合に「更新」ボタンが押された際のキャンセルとアラート
$('#delivery_input_btn').click(function () {
	var name = document.getElementById("delivery_input").value;
  var postal_code = document.getElementById("delivery_input").value;
	var address = document.getElementById("delivery_input").value;
	if (name == "" || postal_code == "" || address == "") {
		alert("全ての項目を入力してください。");
		return false;
	}
});