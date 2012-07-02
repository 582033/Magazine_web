{include file='header.tpl'}
<script type="text/javascript" src="/sta/js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="/sta/js/gallery.js"></script>
<div class="main">
	<dl class="mag_list clearfix">
		<dt><strong>看杂志</strong> <a href="/mag" class="more">More</a></dt>
		<dd class="topic">
			<div class="slide_pic">
				<div id="magazine_gallery_container">
					{foreach from=$mag_gallery item=item key=key}
						<a href="/magazine/detail/{$item.id}"><img src="{$item.cover}" width="580" height="576" alt="描述" /></a>
					{/foreach}
				</div>
				<div class="tab">
					<div class="point">
						<a href="#" class="sel"></a>
						<a href="#"></a>
						<a href="#"></a>
						<a href="#"></a>
					</div>
				</div>
				<div class="slide_nav">
					<a href="javascript:void(0);" class="prev" id="prev1">上一个</a>
					<a href="javascript:void(0);" class="next" id="next1">下一个</a>
				</div>
			</div>
			{foreach from=$mag_gallery item=item key=key}
				<h2><a href="#">{$item.name}</a></h2>
				<p>
					<a href="#">{$item.intro|truncate:50}</a>
					<a href="/magazine/detail/{$item.id}" class="readmore">阅读+</a>
				</p>
			{/foreach}
		</dd>
		{foreach from=$mag_list item=item key=key}
		<dd>
			<div class="cover">
				<a href="/magazine/detail/{$item.id}"><img src="{$item.cover}" width='180px' height='276px' alt="宠爱日记" /></a>
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
						<a href="/magazine/detail/{$item.id}" class="read">阅读</a>
						<a href="#" class="del_mag">删除</a>
						<div class="more" border:1px solid blue;>
								<a href="/comment/magazine/{$item.id}" class="comment">评论</a>
								<a href="javascript:void(0);" class="share">分享</a>
								<a href="javascript:void(0);" class="like">{$item.likes}</a>
						</div>
						<div class="shareto">
							<div class="bg"></div>
							<!--<ul>
								<li><a href="#" class="s_qq">分享到QQ空间</a></li>
								<li><a href="#" class="s_sina">分享到新浪微博</a></li>
								<li><a href="#" class="s_renren">分享到人人网</a></li>
								<li><a href="#" class="s_qt">分享到腾讯微博</a></li>
								<li><a href="#" class="s_douban">分享到豆瓣</a></li>
								<li><a href="#" class="s_baidu">分享到百度空间</a></li>
								<li><a href="#" class="s_kaixin01">分享到开心网</a></li>
							</ul>-->
						</div>
					</div>
				</div>
			</div>
			<h3><a href="#">{$item.name}</a></h3>
			<p>{$item.intro|truncate:30}</p>
		</dd>
		{/foreach}
	</dl>


	<dl class="element_list clearfix">
		<dt><strong>爱发现</strong> <a href="/find" class="more">More</a></dt>
		<dd class="topic">
			<div class="slide_pic">
				<div id="element_gallery_container">
					{foreach from=$elem_gallery item=item key=key}
						<a href="http://pub.1001s.cn/{$item.read_mag_id}/{$item.magId}/web/#{$item.page}"><img src="{$item.image.url}" width="580" height="380" alt="描述" /></a>
					{/foreach}
				</div>
				<div class="tab">
					<div class="point">
						<a href="#" class="sel"></a>
						<a href="#"></a>
						<a href="#"></a>
						<a href="#"></a>
					</div>
				</div>
				<div class="slide_nav">
					<a href="javascript:void(0);" class="prev" id="prev2">上一个</a>
					<a href="javascript:void(0);" class="next" id="next2">下一个</a>
				</div>
			</div>
			{foreach from=$elem_gallery item=item key=key}
				<h2><a href="#">1那些年 让我们一见倾心的鞋子</a></h2>
			{/foreach}
		</dd>
		{foreach from=$elem_list item=item key=key}
		{if $key != 4}
		<dd>
			<div class="cover">
				<a href="#"><img src="{$item.image.128}" width='180px' height='180px' alt="宠爱日记" /></a>
				<div class="mouseover">
					<div class="bg"></div>
					<div class="content">
						<a href="http://pub.1001s.cn/{$item.read_mag_id}/{$item.magId}/web/#{$item.page}" class="read">阅读</a>
						<div class="more">
								<a href="#" class="share">分享</a>
								<a href="javascript:void(0);" class="like">喜欢</a>
						</div>
						<div class="shareto">
							<div class="bg"></div>
						</div>
					</div>
				</div>
			</div>
			<h3><a href="#">宠爱日记</a></h3>
		</dd>
		{else}
		<dd class="col2">
			<div class="cover">
				<a href="http://pub.1001s.cn/{$item.read_mag_id}/{$item.magId}/web/#{$item.page}"><img src="{$item.image.128}" width='380px' height='180px' alt="宠爱日记" /></a>
				<div class="mouseover">
					<div class="bg"></div>
					<div class="content">
						<a href="http://pub.1001s.cn/{$item.read_mag_id}/{$item.magId}/web/#{$item.page}" class="read">阅读</a>
						<div class="more">
								<a href="#" class="share">分享</a>
								<a href="javascript:void(0);" class="like">喜欢</a>
						</div>
						<div class="shareto">
							<div class="bg"></div>
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
{include file='share.tpl'}
{include file='footer_big.tpl'}
