$(function(){
	var $container = $('#container');
	$container.masonry({
		// options
		itemSelector : '.item',
		columnWidth : 200
	});
    $container.infinitescroll(
		{
		  navSelector: '#pagenav',    // selector for the paged navigation 
		  nextSelector: '#pagenav a',  // selector for the NEXT link (to page 2)
		  itemSelector: '.item',     // selector for all items you'll retrieve
		  loading: {
			  finishedMsg: '最后一页了',
			  img: 'http://i.imgur.com/6RMhx.gif'
			},
		},
      // trigger Masonry as a callback
      function(newElements) {
          $container.masonry('appended', $(newElements)); 
      }
	);
});

