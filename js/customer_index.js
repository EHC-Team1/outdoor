// 退会処理「名前」クリック時のアラート
$('.secession_btn').click(function () {

  // 苗字を表示させたい
  // var name_last = document.getElementsByClassName("secession_btn").value;
  // if (window.confirm(name_last + " さんを退会させますか？")) {

    if (window.confirm("このユーザーを退会させますか？")) {
    alert("情報を退会済みユーザー一覧へ移動しました。");
  } else {
    return false;
  }
});


// 再入会処理「名前」クリック時のアラート
$('.rejoin_btn').click(function () {
    if (window.confirm("このユーザーを再入会させますか？")) {
    alert("情報を会員ユーザー一覧へ移動しました。");
  } else {
    return false;
  }
});