{include file="header.tpl"}
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
				<a href="http://pub.1001s.cn/{$magazine.author.id}/{$magazine.id}/web"><img src="/sta/images/btn_readonline.jpg" alt="在线阅读" /></a>
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
						<li><a href="http://pub.1001s.cn/{$magazine.author.id}/{$magazine.id}/web/#p{$key+1}"><img src="{$item}" alt="page 16" width="104px" height="160px" style="overflow:hidden;" /></a></li>
						{/foreach}
					</ul>
			</dd>
		</dl>
			
		
		
		
		<div class="comment_preview">
			<h3>留言板</h3>
			<form class="comment_sub">
				<img src="/sta/images/userhear_def.gif" alt="用户头像" />
				<textarea></textarea>
				<button type="submit">发表评论</button>
			</form>
			
			<dl class="clearfix">
				<dt><a href="#"><img src="/sta/images/userhead/50.jpg" alt="用户头像" /></a></dt>
				<dd>
					<p class="info"><a href="#">戴斯</a> 回复 <a href="#">肉丝</a>　<span>(2012-06-01 15:12:07)</span></p>
					<p>回复内容是这样的，我就是回复内容</p>
				</dd>
				<dd class="edit_reply"><a href="#">回复</a></dd>
			</dl>
			<dl class="clearfix">
				<dt><a href="#"><img src="/sta/images/userhead/50.jpg" alt="用户头像" /></a></dt>
				<dd>
					<p class="info"><a href="#">戴斯</a> 回复 <a href="#">肉丝</a>　<span>(2012-06-01 15:12:07)</span></p>
					<p>回复内容是这样的，我就是回复内容</p>
				</dd>
				<dd class="edit_reply"><a href="#">回复</a></dd>
			</dl>
			<dl class="clearfix">
				<dt><a href="#"><img src="/sta/images/userhead/50.jpg" alt="用户头像" /></a></dt>
				<dd>
					<p class="info"><a href="#">戴斯</a> 回复 <a href="#">肉丝</a>　<span>(2012-06-01 15:12:07)</span></p>
					<p>回复内容是这样的，我就是回复内容</p>
				</dd>
				<dd class="edit_reply"><a href="#">回复</a></dd>
			</dl>
			<dl class="clearfix">
				<dt><a href="#"><img src="/sta/images/userhead/50.jpg" alt="用户头像" /></a></dt>
				<dd>
					<p class="info"><a href="#">戴斯</a> 回复 <a href="#">肉丝</a>　<span>(2012-06-01 15:12:07)</span></p>
					<p>回复内容是这样的，我就是回复内容</p>
				</dd>
				<dd class="edit_reply"><a href="#">回复</a></dd>
			</dl>
			<dl class="clearfix">
				<dt><a href="#"><img src="/sta/images/userhead/50.jpg" alt="用户头像" /></a></dt>
				<dd>
					<p class="info"><a href="#">戴斯</a> 回复 <a href="#">肉丝</a>　<span>(2012-06-01 15:12:07)</span></p>
					<p>回复内容是这样的，我就是回复内容</p>
				</dd>
				<dd class="edit_reply"><a href="#">回复</a></dd>
			</dl>
			
			
				<p class="more_comment">
					<a href="#">查看全部123条留言</a>
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
			<dd><a href="#" title="{$item.name}"><img src="{$item.cover}" alt="{$item.name}" /></a></dd>
			{/foreach}
		</dl>
		<dl class="mag_topic">
			<dt>推荐的杂志</dt>
			{foreach from=$maylike item=item}
			<dd><a href="#" title="{$item.name}"><img src="{$item.cover}" alt="{$item.name}" /></a></dd>
			{/foreach}
		</dl>
	</div>
</div>

{include file="footer.tpl"}
