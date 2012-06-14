function loved(mag_id,type){
	var loved_id = mag_id;
	var type = type;
	$.ajax({
		type:"GET",
		url:"magazine/judge_loved?loved_id="+loved_id+"&loved_type=magazine",
		dataType:"json",
		success:function(data){
				alert(1);
			}
		});

}
