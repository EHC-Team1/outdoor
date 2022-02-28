// 配送先が入力されていない場合に「更新」ボタンが押された際のキャンセルとアラート
$('#delivery_edit_btn').click(function () {
	var name = document.getElementById("delivery_name").value;
  var postal_code = document.getElementById("delivery_postal_code").value;
	var address = document.getElementById("delivery_address").value;
	var house_num = document.getElementById("delivery_house_num").value;
	if (Number(name) == "" && Number(postal_code) == "" && Number(address) == "" && Number(house_num) == "") {
		alert("全ての項目を入力してください。");
		return false;
	}

	if (Number(name) == "" && Number(postal_code) == "") {
		alert("宛名と郵便番号を入力してください。");
		return false;
	}

	if (Number(name) == "" && Number(address) == "") {
		alert("宛名と市区町村を入力してください。");
		return false;
	}

	if (Number(name) == "" && Number(house_num) == "") {
		alert("宛名と番地・建物名を入力してください。");
		return false;
	}

	if (Number(postal_code) == "" && Number(address) == "") {
		alert("郵便番号と市区町村を入力してください。");
		return false;
	}

	if (Number(postal_code) == "" && Number(house_num) == "") {
		alert("郵便番号と番地・建物名を入力してください。");
		return false;
	}

	if (Number(address) == "" && Number(house_num) == "") {
		alert("市区町村と番地・建物名を入力してください。");
		return false;
	}

	if (Number(name) == "") {
		alert("宛名を入力してください。");
		return false;
	}

	if (Number(postal_code) == "") {
		alert("郵便番号を入力してください。");
		return false;
	}

	if (Number(address) == "") {
		alert("市区町村を入力してください。");
		return false;
	}

	if (Number(house_num) == "") {
		alert("番地・建物名を入力してください。");
		return false;
	}









});