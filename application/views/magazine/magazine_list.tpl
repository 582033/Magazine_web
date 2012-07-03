{include file='header.tpl'}
<div class="main">
	<dl class="mag_list m_index clearfix">
		<dd class="menu">
			<ul>
				<li><a href="/mag_list/tour_reader" {if $tag == 'tour_reader'}class="sel"{/if} id="tour_reader">旅游攻略</a></li>
				<li><a href="/mag_list/foreign" {if $tag == 'foreign'}class="sel"{/if} id="foreign">出境游</a></li>
				<li><a href="/mag_list/domestic" {if $tag == 'domestic'}class="sel"{/if} id="domestic">国内游</a></li>
			</ul>
		{foreach from=$items item=item key=key}
		<dd class="tour_reader">
			<div class="cover">
				<a href="/magazine/detail/{$item.id}"><img src="{$item.cover}" width='180px' height='276px' alt="{$item.name}" /></a>
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
						<div class="more">
								<a href="/magazine/{$item.id}/comment/p/1" class="comment">评论</a>
								<a href="javascript:void(0);" class="share">分享</a>
								<a href="javascript:void(0);" class="like">{$item.likes}</a>
						</div>
						<div class="shareto">
							<div class="bg"></div>
	<!--						<ul>
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
			<h3><a href="/magazine/detail/{$item.id}">{$item.name}</a></h3>
		</dd>
		{/foreach}
	</dl>
{$page_list}
</div>
{include file='footer.tpl'}
{include file='share.tpl'}
