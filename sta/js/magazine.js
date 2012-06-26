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

    $(".mouseover .share").mouseenter(function(){
		$(this).parent().parent().children(".shareto").css("display","block");
	});
    $(".mouseover .share").mouseleave(function(){
		$(this).parent().parent().children(".shareto").css("display","none");
	});
    $(".mouseover .shareto").mouseenter(function(){
		$(this).css("display","block");
	});
    $(".mouseover .shareto").mouseleave(function(){
		$(this).css("display","none");
	});

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
