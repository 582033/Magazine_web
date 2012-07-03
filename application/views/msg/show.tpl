<script type="text/javascript" >

window.onload= function(){

 resize();

}


function delmsg(msgid){
{$web_host} 
 
}
function resize(){

	page_height = $(".main_left_line").height();

	if ($(".sidebar_left").height()<page_height){

		$(".sidebar_left").css("height",$(".main_left_line").height()-1+"px");

	}

	if ($(".right_main").height()<page_height){

		$(".msg_list").css("height",$(".main_left_line").height()+"px");

	}

}





$("document").ready(function(){

    $(".msg_list dd").mouseenter(function(){

		$(this).find(".del_msg").css("visibility","visible");

	});

    $(".msg_list dd").mouseleave(function(){

		$(this).find(".del_msg").css("visibility","hidden");

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

</script>
</head>
 <body>
 	<div class="right_main">
 		<div class="msg_list clearfix">
 			<div class="menu">
 				<ul>
 					<li><a href="#" class="sel">消息中心</a></li>
 					<li><a href="#">关注的作者</a></li>
 					<li><a href="#">喜欢的发现</a></li>
 					<li><a href="#">喜欢的书</a></li>
 					<li><a href="#">我的作品</a></li>
 				</ul>
 			</div>
 			
 			<div class="my_msg_list">
{$msg} 
			</div>
	{$page_list}
 		</div>
 	</div>
 </div>
 
