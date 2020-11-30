function get_max_bid(){
var xhttp;
xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
  if(xhttp.readyState == 4 && xhttp.status == 200) {
    document.getElementsById("bid").innerHTML = xhttp.responseText;
  xhttp.open("GET", "get-max-bid.php", true)
  xhttp.send();
}
}
}
