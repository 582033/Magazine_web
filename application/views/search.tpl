{include file="header.tpl"}
<ul class="search_menu">
 	<li><a href="/search/{$keyword}" {if !$type}class="sel"{/if}>全部</a></li>
 	<li><a href="/search/{$keyword}/magazine" {if $type == 'magazine'}class="sel"{/if}>杂志</a></li>
 	<li><a href="/search/{$keyword}/author" {if $type == 'author'}class="sel"{/if}>作者</a></li>
</ul>
<div class="search_big">
<input type="text" name="search_big" value="{if $keyword}{$keyword}{else}搜索{/if}" onfocus="if(this.value !='')this.value='';" onblur="if(this.value=='')this.value='{if $keyword}{$keyword}{else}搜索{/if}'" class="graytext" />
	<button type="submit">搜索</button>
 	<p><a href="">旅游</a> <a href="#">美食</a></p>
</div>
{if $type != 'author'} 
{include file='share.tpl'}
<dl class="mag_list_title clearfix">
 	<dt><span>共<strong>{$magazines.totalResults}</strong>本符合该关键字的杂志</span> <a href="/search/{$keyword}/magazine" class="more">More</a></dt>
</dl>
<dl class="mag_list search clearfix">
		{foreach from=$magazines.items item=item}
			{include file="magazine/lib/magcover.tpl"}
		{/foreach}
</dl>
{/if} 

{if $type != 'magazine'} 
<dl class="user_list clearfix">
 	<dt><span>共<strong>{$authors.totalResults}</strong>个符合该关键字的用户</span> <a href="/search/{$keyword}/author" class="more">More</a></dt>
	{foreach from=$authors.items item=item}
 	<dd>
 		<a href="/user/{$item.id}"><img src="{$item.image}" alt="{$item.nickname}" />{$item.nickname}</a>
 	</dd>
	{/foreach}
</dl>
{/if} 

<dl class="user_list">
{$page_list}
</dl>
{include file="footer.tpl"}
