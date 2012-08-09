{include file='header.tpl'}
<script type="text/javascript" src="http://sta.in1001.com/lib/jquery/jquery.cycle.all.js"></script>
<script type="text/javascript" src="/sta/js/gallery.js"></script>
<div class="main">
	<dl class="mag_list clearfix">
		<dt><strong>爱阅读</strong> <a href="/mag" class="more">More</a></dt>
		{include file="magazine/lib/ad-gallery.tpl" container_id="magazine_gallery_container" ad_slot=$ad_slot_indextop fx="fadeZoom2"}
		{foreach from=$mag_list item=item key=key}
		{include file="magazine/lib/magcover.tpl" cover_show_intro=true}
		{/foreach}
	</dl>

	<dl class="element_list clearfix">
		<dt><strong>爱发现</strong> <a href="/find" class="more">More</a></dt>
		{include file="magazine/lib/ad-gallery.tpl" container_id="element_gallery_container" ad_slot=$ad_slot_indexbottom}
		{foreach from=$elm_4 item=item key=key}
		{include file="magazine/lib/elemcover.tpl" width=180 height=180 cover_show_title=true}
		{/foreach}
	</dl>
</div>
<p id="float-weibo"><a href="http://e.weibo.com/qianyeyuedu"><span></span></a></p>
{include file='share.tpl'}
{include file='footer.tpl'}
