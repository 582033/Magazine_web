function like(type, type_id){
	$dataType = {dataType:'json'};
	$.post("/like/"+type+"/"+type_id, $dataType,  function(data) {
		if (type == 'magazine'){
			$("#magazine_"+type_id).text(data.likes);
			$("#magazine_"+type_id).css("background","url('/sta/images/heart.png') no-repeat");
			$("#magazine_"+type_id).css("background-position","17px 4px");
		}else if (type == 'element'){
			$("#element_"+type_id).text(data.likes);
			$("#element_"+type_id).css("background","url('/sta/images/heart.png') no-repeat");
			$("#element_"+type_id).css("background-position","17px 4px");
		}
	});
}

function detail_like(magazine_id){
	$dataType = {dataType:'json'};
	$.post("/like/magazine/"+magazine_id, $dataType, function(data){
		$("#magazine_"+magazine_id).next('span').text(data.likes);
		$("#magazine_"+magazine_id).parent().css("display","none");
		$("#new_likes").text(data.likes);
		$("#magazine_"+magazine_id).parent().next('.liked').css("display","block");
	})
}
function detail_liked(magazine_id){
	$dataType = {dataType:'json'};
	$.post("/like/magazine/"+magazine_id, $dataType, function(data){
		$('#new_likes').text(data.likes);
	});
}
