$('.btn-outline-danger:not(:eq(0))').click(function () {
  if (window.confirm("記事を削除しますか？")) {
  } else {
    return false;
  }
});