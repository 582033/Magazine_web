function like(type, type_id){
	$dataType = {dataType:'json'};
	$.post("/like/"+type+"/"+type_id, $dataType,  function(data) {
		if (type == 'magazine'){
			if (data.likes != null){
				$("#magazine_"+type_id).text(data.likes);
				$("#magazine_"+type_id).css("background","url('/sta/images/heart.png') no-repeat");
				$("#magazine_"+type_id).css("background-position","17px 4px");
			}
		}else if (type == 'element'){
			if (data.likes != null){
				$("#element_"+type_id).text(data.likes);
				$("#element_"+type_id).css("background","url('/sta/images/heart.png') no-repeat");
				$("#element_"+type_id).css("background-position","17px 4px");
			}
		}else if (type == 'user'){
			if (data.status == 'success'){
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
