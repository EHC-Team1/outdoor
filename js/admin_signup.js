// 管理者サインアップ時アラート
$('#admin_signup_btn').click(function () {
  // 必須項目の入力チェック
  var admin_name = document.getElementById("admin_name").value;
  var password = document.getElementById("password").value;
  if (admin_name == "" || password == "") {
  }else{
    alert("管理者登録に成功しました。")
  }
});