<?php
function vcurl($url, $post = '', $cookie = '', $cookiejar = '', $referer = ''){
	$tmpInfo = '';
	$cookiepath = getcwd().'./'.$cookiejar;
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	if($referer) {
		curl_setopt($curl, CURLOPT_REFERER, $referer);
	} else {
		curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
	}
	if($post) {
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
	}
	if($cookie) {
		curl_setopt($curl, CURLOPT_COOKIE, $cookie);
	}
	if($cookiejar) {
		curl_setopt($curl, CURLOPT_COOKIEJAR, $cookiepath);
		curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiepath);
	}
	//curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($curl, CURLOPT_TIMEOUT, 100);
	curl_setopt($curl, CURLOPT_HEADER, 0);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$tmpInfo = curl_exec($curl);
	if (curl_errno($curl)) {
		echo '<pre><b>错误:</b><br />'.curl_error($curl);
	}
	curl_close($curl);
	return $tmpInfo;
	var_dump($tmpInfo);
}


//echo vcurl("http://localhost/p.php", "t=c&sd=dsd");

//type 1. signup  success 

$arr_signok=	array(
		//用户id
		'user_id' =>'113',
		//当前时间
		'occur_time' => date("Y-m-d H:i:s"),
		// 发起者
		'actor'  => '0',
		//signup
		'verb'    => 'signup',
		//message
		'msg_content'  =>'恭喜您！已经成功注册1001夜的账号！',
		);
if(isset($_GET['user_id'])){
	//reset user id from $_GET 
	$arr_signok['user_id']=(int)$_GET['user_id'];

}
	$json_signok = json_encode($arr_signok);





$api_url='http://api.in1001.com/v1/activity/add';
if(isset($_GET['type'])){
	switch ($_GET['type'])
	{
	case 'signup':
	echo vcurl($api_url,'content='.$json_signok);
	break;
	case 'signerr':
	echo vcurl($api_url,$arr_signok);
	break;

	default:
	echo "unknown type";
	}



}
else{
	die("no type selected");


}

