// 確認画面へ進むボタンを押下時にファイル呼び出し
$('#order_confirm_btn').click(function () {
  // 新しいお届け先にチェックが付いていた時に入力フォーム空欄時のキャンセルとアラート
  value = $("#new-delivery:checked").val();
  if (value) {
    var postal_code = document.getElementById("new_postal_code").value;
    var address = document.getElementById("new_address").value;
    var name = document.getElementById("new_name").value;
    if (Number(postal_code) == "" && Number(address) == "" && Number(name) == "") {
      alert("新しいお届け先の項目を入力してください。")
      return false;
    }

    if (Number(postal_code) == "" && Number(address) == "") {
      alert("新しいお届け先の郵便番号と住所を入力してください。")
      return false;
    }

    if (Number(postal_code) == "" && Number(name) == "") {
      alert("新しいお届け先の郵便番号と宛名を入力してください。")
      return false;
    }

    if (Number(postal_code) == "") {
      alert("新しいお届け先の郵便番号を入力してください。")
      return false;
    }

    if (Number(address) == "" && Number(name) == "") {
      alert("新しいお届け先の住所と宛名を入力してください。")
      return false;
    }

    if (Number(address) == "") {
      alert("新しいお届け先の住所を入力してください。")
      return false;
    }

    if (Number(name) == "") {
      alert("新しいお届け先の宛名を入力してください。")
      return false;
    }
  }

})