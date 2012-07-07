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
{if $type != 'author'} 
{include file='share.tpl'}
<dl class="mag_list_title clearfix">
	<dt><span>共<strong>{$magazines.totalResults}</strong>本符合该关键字的杂志</span>
	{if isset($magazines.moreUrl)}<a href="{$magazines.moreUrl}" class="more">More</a></dt>{/if}
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
	{if isset($authors.moreUrl)}<a href="{$authors.moreUrl}" class="more">More</a></dt>{/if}
	{foreach from=$authors.items item=item}
 	<dd>
 		<a href="/user/{$item.id}"><img src="{$item.image}" alt="{$item.nickname}" />{$item.nickname}</a>
 	</dd>
	{/foreach}
</dl>
{/if} 

{if isset($page_list)}
<dl class="user_list">
{$page_list}
</dl>
{/if}
{include file="footer.tpl"}
