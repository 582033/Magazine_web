<dd class="topic">
	<div class="slide_pic">
		<div class="slides">
			{foreach from=$ad_slot.items item=item key=key}
			<a href="{$item.url}"><img src="{$item.image.url}" width="{$ad_slot.width}" height="{$ad_slot.height}" alt="{$item.title}" /></a>
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
				<span>{$item.text|truncate:50}</span>
				<a href="{$item.url}" class="readmore">阅读+</a>
			</p>
			{/if}
		</div>
		{/foreach}
	</div>
</dd>
