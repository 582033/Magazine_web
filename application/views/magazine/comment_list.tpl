{include file="header.tpl"}

	<div class="current"><a href="#">杂志</a> &gt; <a href="#">{$magazine.cate}</a> &gt; <a href="#">{$magazine.name}</a> &gt; <a href="#" class="cur">留言板</a></div>
<div class="main comment clearfix">
	<div class="sidebar_left">
		<a href="#"><img src="{$magazine.cover}" width="180px" height="276px" alt="杂志名" /></a>
		<h2><a href="#">{$magazine.name}</a></h2>
		<p>作者:<a href="#">{$magazine.author.nickname}</a></p>
	</div>
	
	<div class="right_main">
		<h2>留言板</h2>
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
		
		
			<p class="pagenav msg_pagenav">
				<a href="#" class="prav">上一页</a>
				<a href="#" class="sel">1</a>
				<a href="#">2</a>
				<a href="#">3</a>
				<a href="#">4</a>
				<a href="#">5</a>
				<a href="#">6</a>
				<a href="#">7</a>
				<a href="#">8</a>
				<a href="#">...</a>
				<a href="#" class="next">下一页</a>
			</p>
		
	</div>
</div>

{include file="footer.tpl"}
