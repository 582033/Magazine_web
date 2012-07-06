<div class="right_main">
	<dl class="element_list clearfix">
		<dd class="menu">
		{include file='user/user_nav.tpl'}
		</dd>
		<dt style="display:none;"><a href="#" class="sel">全部发现<span>(12)</span></a>　|　<a href="#">发现的美图<span>(12)</span></a>　|　<a href="#">发现的视频<span>(12)</span></a></dt>
		{foreach from=$element['items'] item=item}
		{include file="magazine/lib/elemcover.tpl" cover_show_del=$is_me}
		{/foreach}
	</dl>
{$page_list}
</div>
