$('#customer_update_btn').click(function() {
  var name_last = document.getElementById("customer_name_last").value;
  var name_first = document.getElementById("customer_name_first").value;
  var email = document.getElementById("customer_email").value;
  var postal_code = document.getElementById("customer_postal_code").value;
  var address = document.getElementById("customer_address").value;
  var house_num = document.getElementById("customer_house_num").value;
  var telephone_num = document.getElementById("customer_telephone_num").value;
  if (Number(name_last) == "" && Number(name_first) == "" && Number(email) == "" && Number(postal_code) == "" && Number(address) == "" && Number(house_num) == "" && Number(telephone_num) == "") {
    alert("全ての項目を入力してください。");
    return false;
  }

	if (Number(name_last) == "" || Number(name_first) == "") {
		alert("氏名を入力してください。");
		return false;
	}

	if (Number(email) == "") {
		alert("メールドレスを入力してください。");
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

	if (Number(telephone_num) == "") {
		alert("電話番号を入力してください。");
		return false;
	}

});

// 退会ボタン押下時のアラート
$('#public_switch_status_btn').click(function () {
  if (window.confirm("本当に退会しますか？")) {
    alert("退会しました。\nご利用ありがとうございました。");
  } else {
    return false;
  }
});