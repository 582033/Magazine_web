window.onload= function(){
 resize();
}

function resize(){
	page_height = $(".main_left_line").height();
	if ($(".sidebar_left").height()<page_height){
		$(".sidebar_left").css("height",$(".main_left_line").height()-1+"px");
	}
	if ($(".right_main").height()<page_height){
		$(".mag_list").css("height",$(".main_left_line").height()+"px");
	}
}
window.onload= function(){
	detail_resize();
}

function detail_resize(){
	page_height = $(".main").height();
	if ($(".left_main").height()<page_height){
		$(".left_main").css("height",page_height+"px");
	}
	$(".scrollbar ul").css("width",$(".scrollbar li").outerWidth(true)*$(".scrollbar li").size()+"px");
	$(function(){
		$('.scrollbar').jScrollPane({
				autoReinitialise: true
			});
	});
}
$("document").ready(function(){
    $(".mag_list dd").mouseenter(function(){
		$(this).find(".mouseover").css("display","block");
	});
    $(".mag_list dd").mouseleave(function(){
		$(this).find(".mouseover").css("display","none");
	});
	$(".element_list dd").mouseenter(function(){
		$(this).find(".mouseover").css("display","block");
		$(this).find(".cover").css("z-index","99");
	});
    $(".element_list dd").mouseleave(function(){
		$(this).find(".mouseover").css("display","none");
		$(this).find(".cover").css("z-index","1");
	});

	$('.mouseover .share').hover(
		function(){
			$bdshare = $('#bdshare');
			$share = $(this).parent().parent().find('.shareto');
			$bdshare.appendTo($share);
			$share.show();
		},
		function(){
			$share = $(this).parent().parent().find('.shareto');
			window.console.log(0);
			$share.hide();
		}
	);
	$('.mouseover .shareto').hover(
		function(){
			window.console.log(1);
			$(this).show();
		},
		function(){
			$(this).hide();
		}
	);

    $(".follows a").mouseenter(function(){
        $(".follows .gray").css("display","block");
        $(this).css("z-index","999");
        $(this).find("span").css("left","-"+$(this).position().left+"px");
        $(this).find("span").css("display","block");
		if($(this).position().top>150){
        	$(this).find("span").css("top","-35px");
        }
    });
    $(".follows a").mouseleave(function(){
        $(".gray").css("display","none");
        $(this).find("span").css("display","none");
        $(this).css("z-index","0");
    });
})

$(function(){
	$("#tour_reader").click(function(){
		$(".foreign").css("display","none");
		$(".local").css("display","none");
		$(".tour_reader").css("display","block");
		$("#foreign").removeClass("sel");
		$("#local").removeClass("sel");
		$("#tour_reader").addClass("sel");
	})
	
	$("#foreign").click(function(){
		$(".tour_reader").css("display","none");
		$(".local").css("display","none");
		$(".foreign").css("display","block");
		$("#tour_reader").removeClass("sel");
		$("#local").removeClass("sel");
		$("#foreign").addClass("sel");
	})
	
	$("#local").click(function(){
		$(".tour_reader").css("display","none");
		$(".foreign").css("display","none");
		$(".local").css("display","block");
		$("#tour_reader").removeClass("sel");
		$("#foreign").removeClass("sel");
		$("#local").addClass("sel");
	})	
})
