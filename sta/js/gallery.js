// fadeZoom2 similar to Ken Burns effect in http://tobia.github.com/CrossSlide/
$.fn.cycle.transitions.fadeZoom2 = function($cont, $slides, opts) {
	opts.before.push(function(curr, next, opts) {
		$.fn.cycle.commonReset(curr,next,opts,false,false);
		opts.cssBefore.left = -Math.ceil(Math.random()*(next.cycleH*0.1));
		opts.cssBefore.top = -Math.ceil(Math.random()*(next.cycleW*0.1));
		opts.cssBefore.width = next.cycleW*1.1;
		opts.cssBefore.height = next.cycleH*1.1;
		opts.cssBefore.opacity = 0;
		$.extend(opts.animIn, { top: 0, left: 0, width: next.cycleW, height: next.cycleH,'opacity':1});
	});
	opts.animOut.left = 0;
	opts.animOut.top = 0;
};
 
function show_slide_text($topic, o) {
	$topic.find('.slide_text .slide').hide().eq(o.currSlide).show();
}
$(function() {
	$('dd.topic').each(function() {
		var $me = $(this);
		$me.find('.slide_pic .slides').cycle({
			fx: $me.data('fx') || 'scrollHorz',
			speed:  500,
			timeout: 4000,
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

