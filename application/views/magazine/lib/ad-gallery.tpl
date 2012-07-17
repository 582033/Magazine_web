<dd class="topic"{if isset($fx)} data-fx="{$fx}"{/if}>
	<div class="slide_pic">
		<div class="slides" style="width:{$ad_slot.width}px; height: {$ad_slot.height}px; overflow:hidden">
			{foreach from=$ad_slot.items item=item key=key}
			<a href="{$item.url}"><img {if $fx == "fadeZoom2"}widht="100%" height="100%"{else}width="{$ad_slot.width}" height="{$ad_slot.height}"{/if} src="{$item.image.url}" alt="{$item.title}" /></a>
			{/foreach}
		</div>
		<div class="tab">
			<div class="point">
			</div>
		</div>
		<div class="slide_nav">
			<a href="javascript:void(0);" class="prev">上一个</a>
			<a href="javascript:void(0);" class="next">下一个</a>
		</div>
	</div>
	<div class="slide_text">
	{foreach from=$ad_slot.items item=item key=key}
		<div class="slide">
			<h2><a href="{$item.url}">{$item.title}</a></h2>
			{if $ad_slot.show_text}
			<p>
				<span>{$item.text|mbtruncate:100}</span>
				<a href="{$item.url}" class="readmore">阅读+</a>
			</p>
			{/if}
		</div>
		{/foreach}
	</div>
</dd>
