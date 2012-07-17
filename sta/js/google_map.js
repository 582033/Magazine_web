	function initialize() {
		var myLatlng = new google.maps.LatLng(39.983598, 116.414880);
		var myOptions = {
			center: myLatlng,
			zoom: 18,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map(document.getElementById("map_canvas"),
		myOptions);
		var marker = new google.maps.Marker({
			position: myLatlng,
			title:"乐投信息"
		});
		marker.setMap(map);  
	}
