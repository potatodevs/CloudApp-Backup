/***************************/
//@Author: Adrian "yEnS" Mato Gondelle
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!					
/***************************/

//SETTING UP OUR POPUP
//0 means disabled; 1 means enabled;
var popupStatus = 0;

//loading popup with jQuery magic!
function loading(){
	//loads popup only if it is disabled
	if(popupStatus==0){
		$("#backgroundLoading").css({
			"opacity": "0.7"
		});
		$("#backgroundLoading").fadeIn("slow");
		$("#loadingPopup").fadeIn("slow");
		popupStatus = 1;
	}
}

//centering popup
function centerLoading(){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $("#loadingPopup").height();
	var popupWidth = $("#loadingPopup").width();
	//centering
	$("#loadingPopup").css({
		"position": "absolute",
		"top": windowHeight/2-popupHeight/2,
		"left": windowWidth/2-popupWidth/2
	});
	//only need force for IE6
	
	$("#backgroundLoading").css({
		"height": windowHeight
	});
	
}


function validateEmail($email) {
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	if( !emailReg.test( $email ) ) {
		return false;
	} else {
		return true;
	}
}

//CONTROLLING EVENTS IN jQuery
$(document).ready(function(){
	
	//LOADING POPUP
	//Click the button event!
	$("form").submit(function(){
		if ($("#frm-login").val() != "" && $("#frm-password").val() != "" && validateEmail($("#frm-login").val())) {
                    centerLoading();
                    loading();
                }

	});        
});