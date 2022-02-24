$('#customer_update_btn').click(function() {
  var name_last = document.getElementById("customer_name_last").value;
  var name_first = document.getElementById("customer_name_first").value;
  var email = document.getElementById("customer_email").value;
  var postal_code = document.getElementById("customer_postal_code").value;
  var address = document.getElementById("customer_address").value;
  var telephone_num = document.getElementById("customer_telephone_num").value;
  if (Number(name_last) == "" || Number(name_first) == "" || Number(email) == "" || Number(postal_code) == "" || Number(address) == "" || Number(telephone_num) == "") {
    alert("全ての項目を入力してください。");
    return false;
  } 
});