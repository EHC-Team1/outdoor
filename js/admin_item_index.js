// 商品「削除」ボタン押下時のアラート
$('.btn-outline-danger').click(function () {
  if (window.confirm("商品を削除しますか？")) {
  } else {
    return false;
  }
});

// 販売可能状態の時
tippy('.switch_unable', {
	placement: 'top',
	animation: 'shift-toward-subtle',
	theme: 'light-border',
	duration: 200,
})

$('switch_unable').click(function() {
  var item_id = $(this).val();
  var item_status = 1;
  console.log(item_id);
  // 非同期で商品状態変更
  $.ajax({
    type: "POST",
    url: "admin_item_index.php",
    data: {
      item_id : item_id,
      item_status : item_status,
    }
  }).fail(function(){
    alert('販売停止状態に変更できません。')
  }).done(function(){
    window.location.href = "admin_item_index.php";
  });
});


// 販売停止状態の時
tippy('.switch_able', {
	placement: 'top',
	animation: 'shift-toward-subtle',
	theme: 'light-border',
	duration: 200,
})

$('switch_able').click(function() {
  var item_id = $(this).val();
  var item_status = 0;
  console.log(item_id);
  // 非同期で商品状態変更
  $.ajax({
    type: "POST",
    url: "admin_item_index.php",
    data: {
      item_id : item_id,
      item_status : item_status,
    }
  }).fail(function(){
    alert('販売停止状態に変更できません。')
  }).done(function(){
    window.location.href = "admin_item_index.php";
  });
});