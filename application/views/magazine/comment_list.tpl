{include file="header.tpl"}
<div class="current">
{include file="magazine/lib/nav.tpl" navs=$navs}
</div>
<div class="main comment clearfix">
	<div class="sidebar_left">
		<a href="{$magazine.url}"><img src="{$magazine.cover}" width="180px" height="276px" alt="{$magazine.name}" /></a>
		<h2><a href="{$magazine.url}">{$magazine.name}</a></h2>
		<p>作者:&nbsp;<a href="{$magazine.author.url}">{$magazine.author.nickname}</a></p>
	</div>

	<div class="right_main">
		<h2>留言板</h2>
		<form id="comment" class="comment_sub" action="/magazine/refresh_comment?type=magazine&object_id={$magazine.id}&start=0&limit=10" method="post">
			<img src="/sta/images/userhear_def.gif" alt="用户头像" />
			<textarea class="text" name="conment"></textarea>
			<button type="button" id="add">发布</button>
		</form>
		{include file="magazine/lib/comments.tpl"}
		{$page_list}
	</div>
</div>

{include file="footer.tpl"}
