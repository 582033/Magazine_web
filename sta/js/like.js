$(function() {
		$(document).ajaxError(function(e, jqxhr, settings, exception) {
			if (jqxhr.status == 401) showSigninBox();
			});
		});
function showSigninBox() {
	tb_show('登陆', '/user/signin?height=404&width=736&modal=true', false);
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
function cancelLike(type, type_id) {
	$dataType = {dataType: 'json'};
	$.post(getLikeUrl(type, type_id, 'cancelLike'),
			{dataType: 'json'}, function(data) {
		window.location.reload();
	});
}
function like(type, type_id, where) {
	if (!checkSignedIn()) return;
	var action = type == 'user' ? 'follow' : 'like';
	$.post(getLikeUrl(type, type_id, action),
			{dataType: 'json'},  function(data) {
		if ($.inArray(type, ['magazine', 'element']) >= 0) {
			if (data.likes) {
				var $e = $("#" + type + "_" + type_id);
				$e.text(data.likes)
					.css("background","url('/sta/images/heart.png') no-repeat")
					.css("background-position","17px 4px");
			}
		}
		else if (type == 'user') {
			if (data.status == 'success') {
				if (where == 'user_center') {
					$('div.userinfo a.follow').text('已关注').addClass('followed');
				}
				else {
					$("img.fellow_item").css("display","none");
					$("span.fellow_item").text("已关注");
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
