 window.onload= function(){
  resize();
 }
 
 function resize(){
 	page_height = $(".main_left_line").height();
 	if ($(".sidebar_left").height()<page_height){
 		$(".sidebar_left").css("height",$(".main_left_line").height()-1+"px");
 	}
 	if ($(".right_main").height()<page_height){
 		$(".element_list").css("height",$(".main_left_line").height()+"px");
 	}
 	if ( $.browser.msie && $.browser.version < 7 ) {
 		$(".mouseover").each( function(){
 				$(this).css("height",$(this).parent().find("img").height()+"px");
 				$(this).css("width",$(this).parent().find("img").width()+"px");
 		});
 	}
 }
 
 
 $("document").ready(function(){
     $(".element_list dd").mouseenter(function(){
 		$(this).find(".mouseover").css("display","block");
 		$(this).find(".cover").css("z-index","99");
 	});
     $(".element_list dd").mouseleave(function(){
 		$(this).find(".mouseover").css("display","none");
 		$(this).find(".cover").css("z-index","1");
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
 
