<div class="right_main">
	<dl class="mag_list clearfix">
		<dd class="menu">
		{include file='user/user_nav.tpl'}
		</dd>
		<dt style="display:none;"><a href="#" class="sel">已发布的杂志<span>(12)</span></a>　|　<a href="#">未发布的杂志<span>(12)</span></a></dt>
		{foreach from=$bookstore.items item=item}
		{include file="magazine/lib/magcover.tpl"}
		{/foreach}
	</dl>
	{$page_list}
</div>
