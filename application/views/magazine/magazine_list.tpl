{include file='header.tpl'}

<div class="main">

	<dl class="mag_list m_index clearfix">
		<dd class="menu">
			<ul>
				<li><a href="#" class="sel" id="tour_reader">旅游攻略</a></li>
				<li><a href="#" id="foreign">出境游</a></li>
				<li><a href="#" id="local">国内游</a></li>
			</ul>
		</dd>
		{foreach from=$tour_reader item=item key=key}
		<dd class="tour_reader">
			<div class="cover">
				<a href="#"><img src="{$item.cover}" width='180px' height='276px' title="{$item.magazine_id}" alt="宠爱日记" /></a>
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
						<a href="#" class="read">阅读</a>
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
		</dd>
		{/foreach}
		{foreach from=$foreign item=item key=key}
		<dd style="display:none;" class="foreign">
			<div class="cover">
				<a href="#"><img src="{$item.cover}" width='180px' height='276px' title="{$item.magazine_id}" alt="宠爱日记" /></a>
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
						<a href="#" class="read">阅读</a>
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
		</dd>
		{/foreach}
		{foreach from=$local item=item key=key}
		<dd style="display:none;" class="local">
			<div class="cover">
				<a href="#"><img src="{$item.cover}" width='180px' height='276px' title="{$item.magazine_id}" alt="宠爱日记" /></a>
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
						<a href="#" class="read">阅读</a>
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
		</dd>
		{/foreach}
	</dl>

	<ul class="pagenav clearfix">
		<li><a href="#" class="sel">1</a></li>
		<li><a href="#">2</a></li>
		<li><a href="#">3</a></li>
		<li><a href="#">4</a></li>
		<li><a href="#">5</a></li>
		<li><a href="#">6</a></li>
		<li><a href="#">7</a></li>
		<li><a href="#">8</a></li>
		<li><a href="#">9</a></li>
		<li><a href="#">10</a></li>
	</ul>
	<form>
	<p class="page_no">
		<input type="text" value="1" /> | 590页 <button type="submit" style="display:none">跳转</button>
	</p>
	</form>

</div>
{include file='footer.tpl'}

