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
		  var $newElems = $(newElements).css({opacity:0});
		  $newElems.animate({opacity:1});
          $container.masonry('appended', $newElems, true); 
      }
	);
});

$(document).ready(function(){
	$("#back-to-top").hide();
	$(function () {
		$(window).scroll(function(){
			if ($(window).scrollTop()>100){
				$("#back-to-top").fadeIn(1500);
			}
			else {
				$("#back-to-top").fadeOut(1500);
			}
		});
		$("#back-to-top").click(function(){
			$('body,html').animate({scrollTop:0},1000);
			return false;
		});
	});
});
