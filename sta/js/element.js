$(function(){
	var $container = $('#container');
	$container.masonry({
		// options
		itemSelector : 'dd.item',
		columnWidth : 200
	});
    $container.infinitescroll(
		{
		  navSelector: '#pagenav',    // selector for the paged navigation 
		  nextSelector: '#pagenav a',  // selector for the NEXT link (to page 2)
		  itemSelector: 'dd.item',     // selector for all items you'll retrieve
		  loading: {
			  finishedMsg: '最后一页了',
			  img: 'http://i.imgur.com/6RMhx.gif'
			}
		},
      // trigger Masonry as a callback
      function(newElements) {
          $container.masonry('appended', $(newElements)); 
      }
	);
});

$(document).ready(function(){
	//首先将#back-to-top隐藏
	$("#back-to-top").hide();
	//当滚动条的位置处于距顶部100像素以下时，跳转链接出现，否则消失
	$(function () {
		$(window).scroll(function(){
			if ($(window).scrollTop()>100){
				$("#back-to-top").fadeIn(1500);
			}
			else {
				$("#back-to-top").fadeOut(1500);
			}
		});
		//当点击跳转链接后，回到页面顶部位置
		$("#back-to-top").click(function(){
			$('body,html').animate({scrollTop:0},1000);
			return false;
		});
	});
});
