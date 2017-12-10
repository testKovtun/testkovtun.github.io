var startLocation = window.location.href;
var helper;
if (startLocation.substr(-1) == "#") { helper = "window-blackout";}
else {
	helper = "#window-blackout";
}
addEventListener("keydown", function(event) {
    if (event.keyCode == 112)
		window.location.href = startLocation + helper;
  });

window.addEventListener("keydown",function(event) {
if (event.keyCode === 112) { 
event.preventDefault();
}
})
 