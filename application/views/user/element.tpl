<div class="right_main">
	<dl class="element_list clearfix">
		<dt style="display:none;"><a href="#" class="sel">全部发现<span>(12)</span></a>　|　<a href="#">发现的美图<span>(12)</span></a>　|　<a href="#">发现的视频<span>(12)</span></a></dt>
		<div id="container">
			{foreach from=$element['items'] item=item}
			{include file="magazine/lib/elemcover.tpl" cover_show_del=$is_me}
			{/foreach}
		</div>
	</dl>
	{if isset($nextpage)}
	<div id="pagenav" style="display:none">
		<a href="{$nextpage}"></a>
	</div>
	{/if}
</div>
<script type="text/javascript" src="http://sta.in1001.com/lib/jquery/jquery.masonry.js"></script>
<script type="text/javascript" src="http://sta.in1001.com/lib/jquery/jquery.infinitescroll.js"></script>
<script type="text/javascript" src="/sta/js/element.js"></script>
