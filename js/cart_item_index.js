$('select').change(function() {
  var quantity = $(this).val();
  var cart_item_id = $(this).attr('name');
  // 非同期でカート内商品更新
    $.ajax({
      type: "POST",
      url: "cart_item_index.php",
      data: {
        cart_item_id : cart_item_id,
        quantity : quantity
      }
    }).fail(function(){
      alert('数量が変更できません。')
    }).done(function(){
      alert('数量が変更されました。')
    });
});
