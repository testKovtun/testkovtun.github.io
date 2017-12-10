function getCookie(name) {
  var matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  return matches ? decodeURIComponent(matches[1]) : undefined;
}

var cookie = getCookie("background");
if (cookie != null)
{
	var body = document.getElementById("body");
	body.style.backgroundImage = "url({0})".replace("{0}", "img/photo" + cookie + ".jpeg");
}