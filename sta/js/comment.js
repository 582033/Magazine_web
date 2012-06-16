$(function (){
	$("#add").click(function(){
		$('#myForm').ajaxSubmit({
			dataType:'json',
			success: function (result) {
				$("#list").html("");
				var div = "";
				for(i=0; i<5; i++){
					div += "<div style='width:600px;height:80px;border:1px solid black;'><div>user_id:"+result.data[i].user_id+"</div><div>user_name:"+result.data[i].nickname+"</div><div>parent_id:"+result.data[i].parent_id+"</div><div>comment:"+result.data[i].comment+"</div></div>";
				}
				$("#list").html(div);
			}
		});
	});
});
