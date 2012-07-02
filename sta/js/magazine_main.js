$(function(){
	$("#tour_reader").click(function(){
		$(".tour_reader").css("display", "block");
		$(".foreign").css("display", "none");
		$(".domestic").css("display", "none");
		$("#tour_reader").addClass("sel");
		$("#foreign").removeClass("sel");
		$("#domestic").removeClass("sel");
	});
	$("#foreign").click(function(){
		$(".foreign").css("display", "block");
		$(".tour_reader").css("display", "none");
		$(".domestic").css("display", "none");
		$("#tour_reader").removeClass("sel");
		$("#domestic").removeClass("sel");
		$("#foreign").addClass("sel");
	});
	$("#domestic").click(function(){
		$(".domestic").css("display", "block");
		$(".foreign").css("display", "none");
		$(".tour_reader").css("display", "none");
		$("#domestic").addClass("sel");
		$("#foreign").removeClass("sel");
		$("#tour_reader").removeClass("sel");
	});
})
