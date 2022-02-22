// 商品「削除」ボタン押下時のアラート
$('.btn-outline-danger').click(function () {
  if (window.confirm("商品を削除しますか？")) {
  } else {
    return false;
  }
});