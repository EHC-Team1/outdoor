// 配送先の削除ボタン押下時のアラート
$('#delete_btn').click(function () {
  if (window.confirm("この商品を削除しますか？")) {
  } else {
    return false;
  }
});

// 入力必須事項が未入力の場合に「商品更新」ボタンが押された際のキャンセルとアラート
$('#item_update_btn').click(function () {
	var item_name = document.getElementById("item_name").value;
  var item_introduction = document.getElementById("item_introduction").value;
  var item_price = document.getElementById("item_price").value;

if (Number(item_name) == "" && Number(item_introduction) == "" && Number(item_price) == ""){
  alert("商品名・商品説明文・価格を入力してください。");
  return false;
}

if (Number(item_name) == "" && Number(item_introduction) == ""){
  alert("商品名と商品説明文を入力してください。");
  return false;
}

if (Number(item_name) == "" && Number(item_price) == ""){
  alert("商品名と価格を入力してください。");
  return false;
}

if (Number(item_introduction) == "" && Number(item_price) == ""){
  alert("商品説明文と価格を入力してください。");
  return false;
}

if (Number(item_name) == ""){
  alert("商品名を入力してください。");
  return false;
}

if(Number(item_introduction) == ""){
  alert("商品説明文を入力してください。");
  return false;
}

if(Number(item_price) == ""){
alert("価格を入力してください。");
  return false;
}
});