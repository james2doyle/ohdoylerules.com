var header = document.getElementsByTagName('header')[0];

function toggleActive() {
  this.classList.toggle('active');
}

function init() {
  if ('ontouchstart' in window) {
    header.addEventListener('touchstart', toggleActive, false);
  } else {
    header.classList.toggle('no-touch');
  }
}
document.addEventListener('DOMContentLoaded', init());
