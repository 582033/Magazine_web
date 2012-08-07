{include file="header.tpl"}
<ul class="search_menu">
	{foreach from=$search_types item=s}
	<li><a href="{$s.url}"{if $s.current} class="sel"{/if}>{$s.name}</a></li>
	{/foreach}
</ul>
<div class="search_big">
	<form id="search_big" action="/search/{$type}" method="GET">
		<input type="text" name="q"
			value="{$keyword|default:"请输入关键字"}" class="graytext" />
		<button type="submit">搜索</button>
	</form>
	<p>
	{foreach from=$hotwords item=w}
		<a href="{$w.url}">{$w.word}</a>
	{/foreach}
	</p>
</div>
<div style="min-height:672px;width:1000px;margin:auto;background-color:white;margin-bottom:30px;">
	{if $type != 'author'} 
	{include file='share.tpl'}
	<dl class="mag_list_title clearfix">
		<dt><span>共<strong>{$magazines.totalResults}</strong>本符合该关键字的杂志</span>
			{if $magazines.totalResults > 20}
				{if isset($magazines.moreUrl)}<a href="{$magazines.moreUrl}" class="more">More</a></dt>{/if}
			{/if}
	</dl>
	<dl class="mag_list search clearfix">
			{foreach from=$magazines.items item=item}
				{include file="magazine/lib/magcover.tpl"}
			{/foreach}
	</dl>
	{/if} 

	{if $type != 'magazine'} 
	<dl class="user_list clearfix">
		<dt><span>共<strong>{$authors.totalResults}</strong>个符合该关键字的用户</span>
		{if $authors.totalResults > 20}
			{if isset($authors.moreUrl)}<a href="{$authors.moreUrl}" class="more">More</a></dt>{/if}
		{/if}
		{foreach from=$authors.items item=item}
		<dd>
			<a href="/user/{$item.id}"><img src="{$item.image}!50" alt="{$item.nickname}" />{$item.nickname}</a>
		</dd>
		{/foreach}
	</dl>
	{/if} 

	<dl class="user_list user_list_pages">
	{$page_list}
	</dl>
</div>
{include file="footer.tpl"}
