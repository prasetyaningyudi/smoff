function initMenu() {
  $('#menu ul').hide();
  $('#menu ul').children('.current').parent().show();
  //$('#menu ul:first').show();
  $('#menu li a').click(
	function() {
	  var checkElement = $(this).next();
	  if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
		return false;
		}
	  if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
		$('#menu ul:visible').slideUp('normal');
		checkElement.slideDown('normal');
		return false;
		}
	  }
	);
};
function addToogled(){
	var toogled = getCookie("toogled");
	if (toogled == "no") {
        $("#container").removeClass("toggled");
    }else{
		$("#container").toggleClass("toggled");
	}	
}

$(document).ready(function() {	
	initMenu();
	addToogled()	
});

$(".menu-toggle").click(function(e){
	e.preventDefault();
	var toogled = getCookie("toogled");
	if (toogled == "no") {
        setCookie("toogled", "yes", 86500);
    }else{
		setCookie("toogled", "no", 86500);
	}	
	$("#container").toggleClass("toggled");
	initMenu();
});

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
};

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

