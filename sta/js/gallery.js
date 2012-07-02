$(document).ready(function(){
	$('#magazine_gallery_container').cycle({
		fx:     'scrollHorz',
		speed:  500,
		timeout: 0,
		next:   '#next1',
		prev:   '#prev1',
		pager: $('.mag_list .point'),
		pagerAnchorBuilder : function(i, slide) {
			return $('.mag_list .point').children().eq(i);
		},
		activePagerClass:'sel',
		after:function(c,n,o) {
			if (o.speed == 0) {
			  return setTimeout(function() {
				toggleM(o);
			  }, 100);
			} else {
			  toggleM(o);
			}
		}
	});
	function toggleM(o) {
		$('.mag_list .topic h2').each(function(i){
					if(i==o.currSlide) {
						$(this).show();
					}
					else {
						$(this).hide();
					}
				});
		$('.mag_list .topic p').each(function(i){
					if(i==o.currSlide) {
						$(this).show();
					}
					else {
						$(this).hide();
					}
				});
	}
	
	$('#element_gallery_container').cycle({
		fx:     'scrollHorz',
		speed:  500,
		timeout: 0,
		next:   '#next2',
		prev:   '#prev2',
		pager: $('.element_list .point'),
		pagerAnchorBuilder : function(i, slide) {
			return $('.element_list .point').children().eq(i);
		},
		activePagerClass:'sel',
		after:function(c,n,o) {
			if (o.speed == 0) {
			  return setTimeout(function() {
				toggleE(o);
			  }, 100);
			} else {
			  toggleE(o);
			}
		}
	});
	function toggleE(o) {
		$('.element_list .topic h2').each(function(i){
					if(i==o.currSlide) {
						$(this).show();
					}
					else {
						$(this).hide();
					}
				});
	}
});
