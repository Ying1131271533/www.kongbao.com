$(document).ready(function(e) {
	$("#rightButton").css("right", "0px");

	var button_toggle = true;
	$(".right_ico").bind("mouseover", function(){
		var tip_top;
		var show= $(this).attr('show');
		var hide= $(this).attr('hide');
		tip_top = show == 'tel' ?  65 :  -10;
		button_toggle = false;
		$("#right_tip").css("top" , tip_top).show().find(".flag_"+show).show();
		$(".flag_"+hide).hide();

	}).bind("mouseout", function(){
		button_toggle = true;
		hideRightTip();
	});


	$("#right_tip").bind("mouseover", function(){
		button_toggle = false;
		$(this).show();
	}).bind("mouseout", function(){
		button_toggle = true;
		hideRightTip();
	});

	function hideRightTip(){
		setTimeout(function(){
			if( button_toggle ) $("#right_tip").hide();
		}, 500);
	}

	$("#backToTop").bind("click", function(){
		var _this = $(this);
		$('html,body').animate({ scrollTop: 0 }, 500 ,function(){
			_this.hide();
		});
	});

	$(window).scroll(function(){
		var htmlTop = $(document).scrollTop();
		if( htmlTop > 0){
			$("#backToTop").fadeIn();
		}else{
			$("#backToTop").fadeOut();
		}
	});
});



