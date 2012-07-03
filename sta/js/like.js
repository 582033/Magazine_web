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
		data.likes = 1;
		
	})
}
