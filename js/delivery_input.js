// 配送先が入力されていない場合に「新規登録」ボタンが押された際のキャンセルとアラート
$('#delivery_input_btn').click(function () {
	var name = document.getElementById("delivery_name").value;
  var postal_code = document.getElementById("delivery_postal_code").value;
	var address = document.getElementById("delivery_address").value;
	if (Number(name) == "" && Number(postal_code) == "" && Number(address) == "") {
		alert("全ての項目を入力してください。");
		return false;
	}

	if (Number(name) == "" && Number(postal_code) == "") {
		alert("宛名と郵便番号を入力してください。");
		return false;
	}

	if (Number(name) == "" && Number(address) == "") {
		alert("宛名と住所を入力してください。");
		return false;
	}

	if (Number(name) == "") {
		alert("宛名を入力してください。");
		return false;
	}

	if (Number(postal_code) == "" && Number(address) == "") {
		alert("郵便番号と住所を入力してください。");
		return false;
	}

	if (Number(postal_code) == "") {
		alert("郵便番号を入力してください。");
		return false;
	}

	if (Number(address) == "") {
		alert("住所を入力してください。");
		return false;
	}
});
