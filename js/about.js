var bar = new ProgressBar.Line(splash_text,{
  easing: 'easeInOut',
  duration: 1000,
  strokeWidth: 0.2,
  color: '#555',
  trailColor: '#bbb',
  text: {
    style: {
      position: 'absolute',
      left: '50%',
      top: '50%',
      padding: '0',
      margin: '-30px 0 0 0',
      transform: 'translate(-50%,-50%)',
      'font-size': '1rem',
      color: '#fff',
    },
    autoStyleContainer: false
  },
  step: function(state, bar){
    bar.setText(Math.round(bar.value() * 100) + ' %');
  }
});
bar.animate(1.0, function(){
  $("#splash").delay(500).fadeOut(800);
});

const FADEIN_ELEM1 = document.getElementById('fadein1');
window.addEventListener('scroll', () => {
  const FADEIN_ELEM_TOP1 = FADEIN_ELEM1.getBoundingClientRect().top;
  const WINDOW_HEIGHT1 = window.innerHeight;
  if(WINDOW_HEIGHT1 > (FADEIN_ELEM_TOP1 + 200)){
    FADEIN_ELEM1.classList.add('fadein-after1');
  }else{
    FADEIN_ELEM1.classList.remove('fadein-after1');
  }
});

const FADEIN_ELEM2 = document.getElementById('fadein2');
window.addEventListener('scroll', () => {
  const FADEIN_ELEM_TOP2 = FADEIN_ELEM2.getBoundingClientRect().top;
  const WINDOW_HEIGHT2 = window.innerHeight;
  if(WINDOW_HEIGHT2 > (FADEIN_ELEM_TOP2 + 200)){
    FADEIN_ELEM2.classList.add('fadein-after2');
  }else{
    FADEIN_ELEM2.classList.remove('fadein-after2');
  }
});

const FADEIN_ELEM3 = document.getElementById('fadein3');
window.addEventListener('scroll', () => {
  const FADEIN_ELEM_TOP3 = FADEIN_ELEM3.getBoundingClientRect().top;
  const WINDOW_HEIGHT3 = window.innerHeight;
  if(WINDOW_HEIGHT3 > (FADEIN_ELEM_TOP3 + 200)){
    FADEIN_ELEM3.classList.add('fadein-after3');
  }else{
    FADEIN_ELEM3.classList.remove('fadein-after3');
  }
});