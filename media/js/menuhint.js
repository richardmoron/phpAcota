var hintcontainer = null;
function showhint(obj, txt) {
if (hintcontainer==null) {
      hintcontainer = document.createElement("div");
      hintcontainer.className="hintstyle";
      document.body.appendChild(hintcontainer);
   }
   obj.onmouseout = hidehint;
   obj.onmousemove=movehint;
   hintcontainer.innerHTML=txt;
}
function movehint(e) {
    if (!e) e = event; //line for IE compatibility
    hintcontainer.style.top =  (e.clientY+document.documentElement.scrollTop-10)+"px";//(90)+"px";
    hintcontainer.style.left = (e.clientX+100)+"px";
    hintcontainer.style.display="";
}
function hidehint() {
   hintcontainer.style.display="none";
}
function f_scrollLeft() {
    return f_filterResults (
            window.pageXOffset ? window.pageXOffset : 0,
            document.documentElement ? document.documentElement.scrollLeft : 0,
            document.body ? document.body.scrollLeft : 0
    );
}
function f_filterResults(n_win, n_docel, n_body) {
    var n_result = n_win ? n_win : 0;
    if (n_docel && (!n_result || (n_result > n_docel)))
            n_result = n_docel;
    return n_body && (!n_result || (n_result > n_body)) ? n_body : n_result;
}