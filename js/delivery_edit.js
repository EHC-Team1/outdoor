// 配送先が入力されていない場合に「更新」ボタンが押された際のキャンセルとアラート
$('#delivery_edit_btn').click(function () {
	var name = document.getElementById("delivery_edit_input").value;
  var postal_code = document.getElementById("delivery_edit_input").value;
	var address = document.getElementById("delivery_edit_input").value;
	if (Number(name) == "" || Number(postal_code) == "" || Number(address) == "") {
		alert("全ての項目を入力してください。");
		return false;
	}
});