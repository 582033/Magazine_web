$(function() {
		$(document).ajaxError(function(e, jqxhr, settings, exception) {
			if (jqxhr.status == 401) showSigninBox();
			});
		});
function showSigninBox() {
	$.colorbox({
		overlayClose: false,
		fixed: true,
		opacity: 0.5,
		href: '/user/signinbox'
	});
}
function checkSignedIn() {
	if ($.cookie('nickname')) {
		return true;
	}
	else {
		showSigninBox();
		return false;
	}
}
function getLikeUrl(type, id, action) {
	return "/" + type + "/" + id + "/" + action;
}
function cancelLike(type, type_id, where) {
	if (!checkSignedIn()) return;
	var action = type == 'user' ? 'unfollow' : 'cancelLike';
	$dataType = {dataType: 'json'};
	$.post(getLikeUrl(type, type_id, action),
			{dataType: 'json'}, function(data) {
		if ($.inArray(type, ['magazine', 'element']) >= 0) {
			window.location.reload();
		}
		else if (type == 'user') {
			if (where == 'user_center') {
				$('div.userinfo a.follow').show();
				$('div.userinfo p.followed').hide();
			}
			else if (where  == 'user_center_followee') {
				window.location.reload();
			}
			else { // detail
				$('a.follow').show();
				$('a.followed').hide();
			}
		}
	});
}
function like(type, type_id, where) {
	if (!checkSignedIn()) return;
	var action = type == 'user' ? 'follow' : 'like';
	var $e = $("#" + type + "_" + type_id);
	$.post(getLikeUrl(type, type_id, action),
			{dataType: 'json'},  function(data) {
		if ($.inArray(type, ['magazine', 'element']) >= 0) {
			if (data.likes) {
				$e.addClass('favorited');
				$('a.like', $e).text(data.likes);
			}
		}
		else if (type == 'user') {
			if (data.status == 'success') {
				if (where == 'user_center') {
					$('div.userinfo a.follow').hide();
					$('div.userinfo p.followed').show();
				}
				else { // detail
					$('a.follow').hide();
					$('a.followed').show();
				}
			}
		}
	});
}
function detail_like(magazine_id){
	if (!checkSignedIn()) return;
	$dataType = {dataType:'json'};
	$.post(getLikeUrl('magazine', magazine_id, 'like'),
			$dataType, function(data) {
		if (data.likes != null){
			$("#magazine_"+magazine_id).next('span').text(data.likes);
			$("#magazine_"+magazine_id).parent().css("display","none");
			$("#new_likes").text(data.likes);
			$("#magazine_"+magazine_id).parent().next('.liked').css("display","block");
		}
	})
}
function detail_liked(magazine_id){
	if (!checkSignedIn()) return;
	$dataType = {dataType:'json'};
	$.post(getLikeUrl('magazine', magazine_id, 'like'),
			$dataType, function(data) {
		$('#new_likes').text(data.likes);
	});
}
