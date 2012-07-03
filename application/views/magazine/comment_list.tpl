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
		<form id="comment" class="comment_sub" action="/magazine/refresh_comment?type=magazine&object_id={$magazine.id}&start=0&limit=10" method="post">
			<img src="/sta/images/userhear_def.gif" alt="用户头像" />
			<textarea class="text" name="conment"></textarea>
			<button type="button" id="add">发布</button>
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
{$page_list}
	</div>
</div>

{include file="footer.tpl"}
