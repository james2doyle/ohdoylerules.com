if ('ontouchstart' in window) {
  var header = document.getElementsByTagName("header")[0];
  header.addEventListener("touchend", function () {
    this.classList.toggle("active");
  }, !0);
} else {
  document.getElementsByTagName("html")[0].className += " no-touch";
}
// document.addEventListener('DOMContentLoaded', function() {});
