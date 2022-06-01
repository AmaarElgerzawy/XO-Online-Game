let ele = document.querySelectorAll(".area"),
 endW = document.getElementById("endW"),
 entE = document.getElementById("endE"),
 over = document.getElementById("over"),
 span = document.getElementById("winner"),
 btn = document.getElementById("btn"),
 start = document.getElementById("start"),
 same1 = document.getElementById("AgainW"),
 same2 = document.getElementById("AgainE"),
 reso = document.getElementById("reso"),
 resx = document.getElementById("resx"),
 online = document.getElementById("on"),
 offline = document.getElementById("off"),
 cr = document.getElementById("cr"),
 crr = document.getElementById("crr"),
 winx,
 wino,
 ro = 0,
 rx = 0,
 cont = 0,
 po = document.getElementById("one"),
 px = document.getElementById("two");

try {
 ele.forEach((e) => {
  e.onclick = () => {
   if (cont % 2 == 0 && check(e)) {
    let sub = e.childNodes[0];
    sub.className = "o";
    sub.innerText = "o";
    e.classList.add("done", "po");
    cont++;
   } else if (cont % 2 == 1 && check(e)) {
    let sub = e.childNodes[0];
    sub.className = "x";
    sub.innerText = "x";
    e.classList.add("done", "px");
    cont++;
   }
   win();
  };
 });
 btn.onclick = function (e) {
  e.preventDefault();
  p_o = document.getElementById("nameO").value;
  p_x = document.getElementById("nameX").value;
  up();
  start.style.display = "none";
 };
 same1.onclick = (e) => {
  e.preventDefault();
  reset();
 };
 same2.onclick = (e) => {
  e.preventDefault();
  reset();
 };
 online.onclick = (e) => {
  e.preventDefault();
  online.parentElement.style.display = "none";
  document.getElementById("online").style.display = "block";
 };
 cr.onclick = (e) => {
  e.preventDefault();
  cr.parentElement.style.display = "none";
  document.getElementById("create").style.display = "block";
 };
 offline.onclick = (e) => {
  e.preventDefault();
  offline.parentElement.style.display = "none";
  document.getElementById("offline").style.display = "block";
 };
 crr.onclick = () => {
  load = document.createElement("div");
  loa = document.createElement("div");
  load.className = "load";
  loa.className = "loa";
  loa.append(load);
  document.body.append(loa);
 };
} catch {}
function win() {
 winx = Array.from(document.querySelectorAll(".px"));
 wino = Array.from(document.querySelectorAll(".po"));
 for (i = 0; i < winx.length; i++) {
  winx[i] = Number.parseInt(winx[i].getAttribute("data-num"));
 }
 for (j = 0; j < wino.length; j++) {
  wino[j] = Number.parseInt(wino[j].getAttribute("data-num"));
 }
 try {
  if (checkwiner(wino, "o") == "o") {
   span.innerHTML = p_o;
   reso.innerText = ++ro;
  } else if (checkwiner(winx, "x") == "x") {
   span.innerHTML = p_x;
   resx.innerText = ++rx;
  }
  if (cont == 9) {
   if (checkwiner(wino, "o") == "o") {
    --ro;
    span.innerHTML = p_o;
    reso.innerText = ++ro;
   } else if (checkwiner(winx, "x") == "x") {
    --rx;
    span.innerHTML = p_x;
    resx.innerText = ++rx;
   } else {
    entE.style.display = "block";
    over.style.display = "block";
   }
  }
 } catch {}
}
function check(e) {
 return e.classList.contains("done") ? false : true;
}
function checkwiner(arr, s) {
 if (arr.includes(1) && arr.includes(2) && arr.includes(3)) {
  endW.style.display = "block";
  over.style.display = "block";
  return s;
 } else if (arr.includes(1) && arr.includes(2) && arr.includes(3)) {
  endW.style.display = "block";
  over.style.display = "block";
  return s;
 } else if (arr.includes(4) && arr.includes(5) && arr.includes(6)) {
  endW.style.display = "block";
  over.style.display = "block";
  return s;
 } else if (arr.includes(7) && arr.includes(8) && arr.includes(9)) {
  endW.style.display = "block";
  over.style.display = "block";
  return s;
 } else if (arr.includes(1) && arr.includes(4) && arr.includes(7)) {
  endW.style.display = "block";
  over.style.display = "block";
  return s;
 } else if (arr.includes(2) && arr.includes(5) && arr.includes(8)) {
  endW.style.display = "block";
  over.style.display = "block";
  return s;
 } else if (arr.includes(3) && arr.includes(6) && arr.includes(9)) {
  endW.style.display = "block";
  over.style.display = "block";
  return s;
 } else if (arr.includes(1) && arr.includes(5) && arr.includes(9)) {
  endW.style.display = "block";
  over.style.display = "block";
  return s;
 } else if (arr.includes(3) && arr.includes(5) && arr.includes(7)) {
  endW.style.display = "block";
  over.style.display = "block";
  return s;
 }
}
function reset() {
 cont = 0;
 winx = Array.from(document.querySelectorAll(".px"));
 wino = Array.from(document.querySelectorAll(".po"));
 ele.forEach((e) => {
  let sub = e.childNodes[0];
  sub.className = "sub";
  sub.innerText = "-";
  e.classList.remove("done", "po", "px");
 });
 endW.style.display = "none";
 over.style.display = "none";
 entE.style.display = "none";
 over.style.display = "none";
}
function up() {
 if (typeof p_o == "undefined" && typeof p_x == "undefined") {
  if (p_o == "") {
   p_o = "Player ONE-O";
  } else po.prepend(p_o + " :");
  if (p_x == "") {
   p_x = "Player TWO-X";
   px.prepend(p_x + " :");
  } else px.prepend(p_x + " :");
 } else {
  start.style.display = "none";
  po.prepend(p_o + " :");
  px.prepend(p_x + " :");
 }
}
