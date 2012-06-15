<?php
	function api($url){	//通过URL获取API里的数据{{{
		@$api_data = json_decode(file_get_contents($url), true);
		return $api_data;
	}	//}}}
