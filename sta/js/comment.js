function show_reply(){
	$("#reply").slideDown();
}


$(document).ready(function() { 
	$("#reply").find("button").click(function(){
		$('#myForm').ajaxForm(function() { 
			alert("Thank you for your comment!"); 
		}); 
	});
}); 

function comment (api_host, sid) {
	/*
	$.ajax({
		type: 'post',
		url: 'http://api.1001s.cn/magazine.comment?session_id='+sid,
		data: "{magazine_id:'" + $("#magazine_id") +"',comment:'"+ $("#comment") +"',parents_id:'"+ $("#parents_id") +"'}",
		success: function (msg) {
			alert("post ok");
			$("#reply").slideUp();
		}
	});	
	*/
        // wait for the DOM to be loaded 
	$.post(api_host+"/magazine.comment?session_id="+sid, function(data) {
			alert("post ok");
			$("#reply").slideUp();
	});
}
