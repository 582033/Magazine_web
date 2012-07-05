function show_slide_text($topic, o) {
	$topic.find('.slide_text .slide').hide().eq(o.currSlide).show();
}
$(function() {
	$('dd.topic').each(function() {
		var $me = $(this);
		$me.find('.slide_pic .slides').cycle({
			fx: 'scrollHorz',
			speed:  500,
			timeout: 0,
			next: $me.find('.slide_nav .next'),
			prev: $me.find('.slide_nav .prev'),
			pager: $me.find('.point'),
			pagerAnchorBuilder: function(i, slide) {
				return '<a href="#"></a>';
			},
			activePagerClass: 'sel',
			after: function(c, n, o) {
				if (o.speed == 0) {
					return setTimeout(function() {
						show_slide_text($me, o);
					}, 100);
				}
				else {
					show_slide_text($me, o);
				}
			}
		});
	});
});
