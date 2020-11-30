// var endAuction = new Date(parseInt(getTimerCookie('endTime')) * 1000).getTime();
// console.log(typeof(parseInt(getCookie("endTime"))));
// console.log(getCookie("endTime"));
// console.log(parseInt(getCookie("endTime")) * 1000);
var endAuction = new Date(parseInt(getCookie("endTime")) * 1000);
var auctionInterval = setInterval(function(){
  var auctionTime = new Date();
  // console.log(auctionTime);
  // console.log(endAuction);

  var untilAuctionOver = endAuction - auctionTime;

  var auctionMinutes = Math.floor((untilAuctionOver % (1000 * 60 * 60)) / (1000 * 60));
  var auctionSeconds = Math.floor((untilAuctionOver % (1000 * 60)) / 1000);
  var min = auctionMinutes.toString();
  var sec = auctionSeconds.toString();

  if (auctionMinutes < 10) {
    min = "0" + auctionMinutes.toString();
  }
  if (auctionSeconds < 10) {
    sec = "0" + auctionSeconds.toString();
  }


  if (untilAuctionOver >= 0) {
    document.getElementById('timer').innerHTML = "Auction ends in " + min + ":" + sec;
  } else {
    clearInterval(auctionInterval);
    document.getElementById('timer').innerHTML = "Auction has ended";
    createCookie("timer", "expired");
    console.log(document.cookie);
    window.location.href = "auction.php";
  }
}, 1000);

// function createTimerCookie(name, value) {
//   var date = new Date();
//   date.setTime(date.getTime()+(60*1000));
//   var expires = "; expires="+date.toGMTString();
//
//   document.cookie = name+ "=" + value+expires+"; path=/;";
// }
//
// function deleteTimerCookie(name) {
//   document.cookie = name+ "=; expires=Thu, 18 Dec 2013 12:00:00 UTC; path=/;";
// }
//
// function getTimerCookie(cname) {
//   var name = cname + "=";
//   var decodedCookie = decodeURIComponent(document.cookie);
//   var ca = decodedCookie.split(';');
//   for(var i = 0; i <ca.length; i++) {
//     var c = ca[i];
//     while (c.charAt(0) == ' ') {
//       c = c.substring(1);
//     }
//     if (c.indexOf(name) == 0) {
//       return c.substring(name.length, c.length);
//     }
//   }
//   return "";
// }
