var modal = document.getElementById('modal');
var modalImg = document.getElementById("img01");
var somethingShowed = false;
var requestNum;
var imgCount = 5;
var loaded = [false, false, false, false, false];
var loading = [false, false, false, false, false];
for (var i = 1; i < 6; i++)
{
	document.getElementById('photo' + i).onclick = requestToShow;
}
window.onload = checkCookie();
var span = document.getElementsByClassName("close")[0];
span.onclick = function() { 
    modal.style.display = "none";
	deleteCookie("lastImage");
	somethingShowed = false;
}

function unshow(){
    var cookie = getCookie("lastImage");
	if (cookie != null) {
		document.getElementById("full" + cookie).style.display = "none"
    }
    var modal = document.getElementById("modal");
    modal.style.display = "none";
}

function popstateHandler(){
    if (document.location.hash.length != 0){
        var imgNum = document.location.hash.substring(1);
        document.getElementById("photo" + imgNum).click();
    }
    else {
        unshow();
    }
}
window.addEventListener("popstate", popstateHandler);

function checkCookie(){
	var cookie = getCookie("lastImage");
	if (cookie != null){
		document.getElementById("photo" + cookie).click();
		}
}

function showBackground(num)
{
	var body = document.getElementById("body");
	body.style.backgroundImage = "url({0})".replace("{0}", document.getElementById("full" + num).src);
}

addEventListener("keydown", function(event) {
    if (event.keyCode == 27)
	{
      span.onclick();
	  somethingShowed = false;
	}
	if (event.keyCode == 39 && somethingShowed == true)
	{
		if (requestNum == imgCount) { requestNum = 0; }
		requestNum += 1;
		document.getElementById("photo" + requestNum).click();
	}
	if (event.keyCode == 37 && somethingShowed == true)
	{
		if (requestNum == 0) { requestNum = imgCount; }
		if (requestNum == 1) { requestNum = imgCount + 1}
		requestNum -= 1;
		document.getElementById("photo" + requestNum).click();
	}
	if (event.keyCode == 32){
		showBackground(requestNum);
		document.cookie = "background={0}".replace("{0}", requestNum);
		}
	if (event.keyCode == 107)
	{
		alert(document.cookie);
	}
});
 
function createFullPhoto(num){
    var modal = document.getElementById("modal");
    var modalImg = document.createElement("img");
    modalImg.src = "img/photo" + num + ".jpeg";
    modalImg.className = "modal-content";
    modalImg.style.display = "none";
    modalImg.id = "full" + num.toString();
    modalImg.onload = showLoad;
    modal.insertBefore(modalImg, modal.firstChild);
	loading[num - 1] = true;
}

function deleteCookie(name) {
    var cookieDate = new Date();
    cookieDate.setTime(cookieDate.getTime() - 1);
    var cookie = name += "=; expires=" + cookieDate.toGMTString();
    document.cookie = cookie;
}

function setCookie(){
	window.location.hash = "#" + requestNum;
    somethingShowed = true;
    document.cookie = "lastImage=" + requestNum;
}

function getCookie(name) {
  var matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  return matches ? decodeURIComponent(matches[1]) : undefined;
}

function requestToShow(event){
	target = event.target || event.srcElement;
	requestNum = parseInt(target.id[5]);
    modal.style.display = "block";
	if (loaded[target.id[5] - 1] == true) 
	{
    modalImg.src = "img/photo" + target.id[5] + ".jpeg";
	somethingShowed = true;
	setCookie();
	return true;
	}
	else
	{
	modalImg.src = 'img/loader.gif';
	modalImg.style.width = '315px';
	modalImg.style.height = '318px';
	}
	createFullPhoto(target.id[5])
	setCookie();
}

function showLoad(event)
{
	target = event.target || event.srcElement;
    loading[target.id[4] - 1] = false;
	loaded[target.id[4] - 1] = true;
	modalImg.src = "img/photo" + target.id[4] + ".jpeg";
	somethingShowed = true;
	modalImg.style.width = '700px';
	modalImg.style.height = '700px';
	var nextImg = (requestNum + 1) % (imgCount + 1);
    if (loaded[nextImg-1] || loading[nextImg - 1]){
        return false;
    }
    var oImg = document.createElement("img");
	oImg.src = "img/photo" + nextImg + ".jpeg";
}