{include file="header.tpl"}
<script src="/sta/js/jquery.jscrollpane.min.js"></script>
<div class="current"><a href="#">杂志</a> &gt;<a href="#" class="current">{$magazine.cate}</a> &gt; <a href="#" class="cur">{$magazine.name}</a></div>

<div class="main mag_preview clearfix">
	<div class="left_main">
		<div class="cover">
			<img src="{$magazine.cover}" alt="{$magazine.name}" />
		</div>
		<div class="intro">
			<h2>{$magazine.name}</h2>
			<p class="auther">作者：<a href="#">{$magazine.author.nickname}</a> <a href="#" class="follow"><img src="/sta/images/ico_plus.gif" alt="加关注" /> 加关注</a></p>
			<p>上传：{$magazine.publishedAt}</p>
			<p class="tag">TAG：{foreach from=$magazine['tag'] item=item}<a href="#">{$item}</a>&nbsp;&nbsp;{/foreach}</p>
			<p class="intro_txt" style="height:77px;"><strong>简介：</strong>
				{$magazine.intro}
			</p>
			<p class="shareto">
				分享到：
				<a href="#" class="s_qq" title="分享到QQ空间">分享到QQ空间</a>
				<a href="#" class="s_sina" title="分享到新浪微博">分享到新浪微博</a>
				<a href="#" class="s_renren" title="分享到人人网">分享到人人网</a>
				<a href="#" class="s_qt" title="分享到腾讯微博">分享到腾讯微博</a>
				<a href="#" class="s_douban" title="分享到豆瓣">分享到豆瓣</a>
				<a href="#" class="s_baidu" title="分享到百度空间">分享到百度空间</a>
				<a href="#" class="s_kaixin01" title="分享到开心网">分享到开心网</a>
			</p>
			<p class="readonline">
				<a href="{$pub_host}/{$magazine.read_mag_id}/{$magazine.id}/web"><img src="/sta/images/btn_readonline.jpg" alt="在线阅读" /></a>
			</p>
			<p class="info">
				<span class="view"><a href="javascript:void(0)" title="阅读">阅读</a>{$magazine.views}</span>
				<span class="like"><a href="javascript:void(0)" title="喜欢">喜欢</a>{$magazine.likes}</span>
				<!--span class="liked"><a href="javascript:void(0)" title="已经喜欢">已经喜欢</a>2121</span-->
			</p>
		</div>

		<dl class="preview">
			<dt>精彩内容预览</dt>
			<dd class="scrollbar">
					<ul>
						{foreach from=$magazine.pageThumbs item=item key=key}
						<li><a href="{$pub_host}/{$magazine.read_mag_id}/{$magazine.id}/web/#p{$key+1}"><img src="{$item}" alt="page 16" width="104px" height="160px" style="overflow:hidden;" /></a></li>
						{/foreach}
					</ul>
			</dd>
		</dl>



		<div class="comment_preview">
			<h3>留言板</h3>
			<form id="comment" class="comment_sub" action="/magazine/refresh_comment?object_id={$magazine.id}&start=0&limit=5" method="post">
				<img src="/sta/images/userhear_def.gif" alt="用户头像" />
				<textarea class="text" name="content"></textarea>
				<input type="button" id="add" value="发布"/>
			</form>

			<dl id="list" class="clearfix">
				{foreach from=$comment item=item}
				<dt><a href="javascript:void(0)"><img src="{$item.author.image}" alt="用户头像" /></a></dt>
				<dd>
					<p class="info"><a href="javascript:void(0)" class="author">{$item.author.nickname}</a><span></span></p>
					<p>{$item.content}</p>
				</dd>
				<dd class="edit_reply"><a href="javascript:void(0)" class="reply">回复</a></dd>
				{/foreach}
			</dl>

				<p class="more_comment">
					<a href="/magazine/{$magazine.id}/comment/p/1">查看全部留言</a>
				</p>

		</div>

	</div>

	<div class="sidebar_right">
		<div class="topic">
		<a href="#"><img src="/sta/images/temp/230x180.jpg" alt="预览" /></a>
		</div>

		<dl class="mag_topic">
			<dt>推荐的杂志</dt>
			{foreach from=$recommendation item=item}
			<dd><a href="/magazine/magazine_detail?id={$item.id}" title="{$item.name}"><img src="{$item.cover}" alt="{$item.name}" /></a></dd>
			{/foreach}
		</dl>
		<dl class="mag_topic">
			<dt>猜你喜欢</dt>
			{foreach from=$maylike item=item}
			<dd><a href="/magazine/magazine_detail?id={$item.id}" title="{$item.name}"><img src="{$item.cover}" alt="{$item.name}" /></a></dd>
			{/foreach}
		</dl>
	</div>
</div>

{include file="footer.tpl"}
