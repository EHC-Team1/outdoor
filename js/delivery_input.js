// 配送先が入力されていない場合に「新規登録」ボタンが押された際のキャンセルとアラート
$('#delivery_input_btn').click(function () {
	var name = document.getElementById("delivery_input").value;
  var postal_code = document.getElementById("delivery_input").value;
	var address = document.getElementById("delivery_input").value;
<<<<<<< Updated upstream
	if (name == "" || postal_code == "" || address == "") {
=======
	if (Number(name) == "" || Number(postal_code) == "" || Number(address) == "") {
>>>>>>> Stashed changes
		alert("全ての項目を入力してください。");
		return false;
	}
});
