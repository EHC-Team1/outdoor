// +が押下されたらカウント増
$('.up').click(function () {
  const text = document.getElementsByClassName('textbox')[i = 0, i++]; //配列の０番目を取得
  if (text.value < 10) {
    text.value++;
  };
  console.log(text.value);
});

$('.down').click(function () {
  const text = document.getElementsByClassName('textbox')[0];
  if (text.value > 1) {
    text.value--;
  }
});