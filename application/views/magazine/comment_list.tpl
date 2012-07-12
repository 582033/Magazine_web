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
		{include file="magazine/lib/comments.tpl" limit=10}
		{$page_list}
	</div>
</div>

{include file="footer.tpl"}
