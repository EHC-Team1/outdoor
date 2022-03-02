// 配送先の削除ボタン押下時のアラート
$('.btn-outline-danger').click(function () {
  if (window.confirm("配送先を削除しますか？")) {
  } else {
    return false;
  }
});

// 退会ボタン押下時のアラート
$('#is_customer_flag_btn').click(function () {
  if (window.confirm("本当に退会しますか？")) {
    alert("退会しました。\nご利用ありがとうございました。");
  } else {
    return false;
  }
});
