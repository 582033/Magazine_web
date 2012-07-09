{include file='header.tpl'}
<div class="main">
	<dl class="mag_list m_index clearfix">
		<dd class="menu">
		{if isset($tag)}
		<h3 class="tag">tag: {$tag}</h3>
		{else}
			<ul>
			{foreach from=$cates item=c}
				<li><a href="{$c.url}"{if $c.current}} class="sel"{/if}>{$c.name}</a></li>
			{/foreach}
			</ul>
		{/if}
		</dd>
		{foreach from=$items item=item key=key}
		{include file="magazine/lib/magcover.tpl"}
		{/foreach}
	</dl>
{$page_list}
</div>
{include file='footer.tpl'}
{include file='share.tpl'}
