function cancelLike(type, type_id) {
	$dataType = {dataType: 'json'};
	$.post("/" + type + "/" + type_id + "/cancelLike", {dataType: 'json'}, function(data) {
		window.location.reload();
	});
}
function like(type, type_id) {
	var action = type == 'user' ? 'follow' : 'like';
	$.post("/" + type + "/" + type_id + '/' + action, {dataType: 'json'},  function(data) {
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
				$("img.fellow_item").css("display","none");
				$("span.fellow_item").text("已关注");
			}
		}
	});
}
function detail_like(magazine_id){
	$dataType = {dataType:'json'};
	$.post("/like/magazine/"+magazine_id, $dataType, function(data){
		if (data.likes != null){
			$("#magazine_"+magazine_id).next('span').text(data.likes);
			$("#magazine_"+magazine_id).parent().css("display","none");
			$("#new_likes").text(data.likes);
			$("#magazine_"+magazine_id).parent().next('.liked').css("display","block");
		}
	})
}
function detail_liked(magazine_id){
	$dataType = {dataType:'json'};
	$.post("/like/magazine/"+magazine_id, $dataType, function(data){
		$('#new_likes').text(data.likes);
	});
}
