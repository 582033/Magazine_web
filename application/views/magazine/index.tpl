{include file='header.tpl'}
<div class="main">

	<dl class="mag_list clearfix">
		<dt><strong>看杂志</strong> <a href="#" class="more">More</a></dt>
		<dd class="topic">
			<div class="slide_pic">
				<a href="#"><img src="/sta/images/temp/580x576.jpg" alt="描述" /></a>
				<div class="tab">
					<a href="javascript:void(0);" class="sel">1</a>
					<a href="javascript:void(0);">2</a>
					<a href="javascript:void(0);">3</a>
					<a href="javascript:void(0);">4</a></div>
				<div class="slide_nav">
					<a href="javascript:void(0);" class="prev">上一个</a>
					<a href="javascript:void(0);" class="next">下一个</a>
				</div>
			</div>
			<h2><a href="#">那些年 让我们一见倾心的鞋子</a></h2>
			<p>
				<a href="#">描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述</a>
				<a href="#" class="readmore">阅读+</a>
			</p>
		</dd>
		{foreach from=$mag_list item=item key=key}
		<dd>
			<div class="cover">
				<a href="/magazine/magazine_detail?id={$item.id}"><img src="{$item.cover}" width='180px' height='276px' alt="宠爱日记" /></a>
				<div class="mouseover">
					<div class="bg"></div>
					<div class="content">
						<div class="info">
							<ul style="margin-left:2px;">
								<li><span>杂志：</span><span>{$item.name}</span></li>
								<li><span>作者：</span><span>{$item.author.nickname}</span></li>
								<li><span>发布：</span><span>{$item.publishedAt}</span></li>							
							</ul>
						</div>
						<a href="/magazine/magazine_detail?id={$item.id}" class="read">阅读</a>
						<a href="#" class="del_mag">删除</a>
						<div class="more">
								<a href="#" class="comment">评论</a>
								<a href="javascript:void(0);" class="share">分享</a>
								<a href="#" class="like">{$item.likes}</a>
						</div>
						<div class="shareto">
							<div class="bg"></div>
							<ul>
								<li><a href="#" class="s_qq">分享到QQ空间</a></li>
								<li><a href="#" class="s_sina">分享到新浪微博</a></li>
								<li><a href="#" class="s_renren">分享到人人网</a></li>
								<li><a href="#" class="s_qt">分享到腾讯微博</a></li>
								<li><a href="#" class="s_douban">分享到豆瓣</a></li>
								<li><a href="#" class="s_baidu">分享到百度空间</a></li>
								<li><a href="#" class="s_kaixin01">分享到开心网</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<h3><a href="#">{$item.name}</a></h3>
			<p>{$item.intro}</p>
		</dd>
		{/foreach}
	</dl>
	
	
	<dl class="element_list clearfix">
		<dt><strong>爱发现</strong> <a href="#" class="more">More</a></dt>
		<dd class="topic">
			<div class="slide_pic">
				<a href="#"><img src="/sta/images/temp/580x380.jpg" alt="描述" /></a>
				<div class="tab">
					<a href="javascript:void(0);" class="sel">1</a>
					<a href="javascript:void(0);">2</a>
					<a href="javascript:void(0);">3</a>
					<a href="javascript:void(0);">4</a>
				</div>
				<div class="slide_nav">
					<a href="javascript:void(0);" class="prev">上一个</a>
					<a href="javascript:void(0);" class="next">下一个</a>
				</div>
			</div>
			<h2><a href="#">那些年 让我们一见倾心的鞋子</a></h2>
		</dd>
		{foreach from=$elem_list item=item key=key}
		{if $key != 4}
		<dd onmouseover="javascript:this.getElementsByTagName('div')[1].style.display='block'" onmouseout="javascript:this.getElementsByTagName('div')[1].style.display='none'">
			<div class="cover">
				<a href="#"><img src="{$item.image.128}" width='180px' height='180px' alt="宠爱日记" /></a>
				<div class="mouseover">
					<div class="bg"></div>
					<div class="content">
						<a href="#" class="read">阅读</a>
						<div class="more">
								<a href="#" class="share">分享</a>
								<a href="#" class="like">喜欢</a>
						</div>
					</div>
				</div>
			</div>
			<h3><a href="#">宠爱日记</a></h3>
		</dd>
		{else}
		<dd class="col2" onmouseover="javascript:this.getElementsByTagName('div')[1].style.display='block'" onmouseout="javascript:this.getElementsByTagName('div')[1].style.display='none'">
			<div class="cover">
				<a href="#"><img src="{$item.image.128}" width='380px' height='180px' alt="宠爱日记" /></a>
				<div class="mouseover">
					<div class="bg"></div>
					<div class="content">
						<a href="#" class="read">阅读</a>
						<div class="more">
								<a href="#" class="share">分享</a>
								<a href="#" class="like">喜欢</a>
						</div>
					</div>
				</div>
			</div>
			<h3><a href="#">鼠标滑过测试鼠标滑过测试鼠标滑过测试鼠标滑过测试鼠标滑过测试</a></h3>
		</dd>
		{/if}
		{/foreach}
	</dl>

</div>
 {include file='footer_big.tpl'}
 
