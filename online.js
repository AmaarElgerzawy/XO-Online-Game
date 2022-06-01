let on_btn = Array.from(document.querySelectorAll(".ddd"));

window.onload = () => {
 write(O, "o", on_btn);
 write(X, "x", on_btn);
 die(on_btn);
};
function die(Ary) {
 Ary.forEach((ele) => {
  if (ele.classList.contains("die")) {
   ele.onclick = function (e) {
    e.preventDefault();
   };
  }
 });
}
function write(ch, s, ary) {
 ch.forEach((num) => {
  ary[num - 1].classList.add("die");
  ary[num - 1].classList.add("done");
  ary[num - 1].classList.add("p" + s);
  the_span = ary[num - 1].firstElementChild.firstElementChild;
  the_span.innerHTML = s;
  the_span.className = s;
 });
 win();
}
function time() {
 setInterval(() => {
  location.reload();
 }, 5000);
}
