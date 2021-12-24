$(document).ready(function() {
	$(".hot_banner_box").append('<div id="loading" style="position:absolute;overflow:hidden;left:0;top:0;width:100%;height: 100%;z-index:300;"><div style="position:absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);z-index: 10;"><img style="max-width: 32px;" src="' + maccms.path_tpl + '/asset/img/loading.gif"></div></div>');
	setTimeout(function () {
        $("#loading").remove();   
	    $(".banner-top,.banner-wtop").addClass("opacity-top");
    }, 2000);
});