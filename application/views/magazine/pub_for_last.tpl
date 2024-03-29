<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
{literal}
<style>
body {
	margin:0;
	padding:0;
}
ul,li{
	margin:0;padding:0;
}
li {
	list-style:none;
}
a {
	text-decoration:none;
	color:#000;
}
img {
	border:none;
}
.main {
	position:relative;
	padding:20px;
	width:650px;
	/*height:576px;*/
	background:#FFF;
}
.head {
	font-size:25px;
	font-family:"黑体";
}
.author {
	margin:0 0 0 0;
	border-top:dashed 1px #666;
	padding:10px 0 10px;
}
.author_avter {
	float:left;
	display:block;
	width:50px;
	height:50px;
}
.author ul{
	height:50px;
	margin:0 0 0 10px;padding:0;
	width:200px;
	float:left;
}
.follow {
	padding:0 5px 0 5px;
	background:#000;
	color:#FFF;
	font-weight:bold;
	font-size:20px;
}
.like-header {
	margin-top:10px;
	height: 43px;
	overflow:hidden;
}
.like-header h3 {
	width:200px;
	float:left;
	height: 100%;
	margin:10px 0 0 0;
	padding:0 0 0 0;
}
.like-header .more {
	float:right; 
	width:40px; 
	height:20px; 
	margin:10px 10px 0 0;
	background:url(/sta/images/more.gif) no-repeat 0px 0px; 
	text-indent:-100px; 
	overflow:hidden;
}
.like-header .more:hover{
	background-position:0px -19px;
}
.may-like {
	width:100%;
	margin-top:10px;
}
.may-like ul{
	float:left;
	width:100%;
}
.may-like ul li{
	margin:0 0 10px 0;
	overflow:hidden;
	width:20%;
	float:left;
	height:198px;
	overflow:hidden;
	text-align:center;
}
.may-like ul li a img{
	padding:0 12px 0 12px;
	width:105px;
	height:162px;
}
.may-like ul li a div{ 
	font-size:13px;
	padding:5px 5px 5px 5px;
}
</style>
{/literal}
</head>
<body>
<div class="main">
		<div class="head">最后一页啦!</div>
		<div class="author">
			<a class="author_avter" href="/user/{$author['id']}" target="_blank"><img src="{$author['image']}!50" /></a>
			<ul>
			<li><span class="name" style="font-weight:bold;">{$author['nickname']}</span></li>
			<li style="margin-top:10px;"><span><a class="follow" href="/user/{$author['id']}" target="_blank">+</a> 关注杂志作者</span></li>
			</ul>
			<div style="clear:both;"></div>
		</div>
		<div class="like-header">
			<h3>您可能还会喜欢</h3>
			<a class="more" href="/mag" target="_blank"></a>
			<div class="clear:both"></div>
		</div>
		<div class="may-like">
			<ul>
			{foreach from=$recommend item=item key=key}
				<li><a href="{$pub_host}/{$item.id|truncate:3:''}/{$item.id}/web/" target="_parent"><img src="{$item.cover}" /><div title="{$item.name}">{$item.name|truncate:28}</div></a></li>
			{/foreach}
			</ul>
			<div class="clear:both"></div>
		</div>
</div>
</body>
</html>
