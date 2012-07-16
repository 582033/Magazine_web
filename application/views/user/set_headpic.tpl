	
	<div class="set_main headpic">
		<h2>当前头像</h2>
		<ul class="clearfix">
			<li class="big"><img src="{$image}" width="180" height="180" alt="180x180" />180x180</li>
			<li><img src="{$image}" width="80" height="80" alt="80x80" />80x80<span>(系统自动生成)</span></li>
			<li><img src="{$image}" width="50" height="50" alt="50x50" />50x50<span>(系统自动生成)</span></li>
		</ul>
		{literal}<button class="btn_set" onclick="$.colorbox({href:'/user/me/cut'})"><span>本地上传</span></button>{/literal}
		<p>上传头像只支持JPG、PNG、GIF格式图片，且小于5M。</p>
	</div>
