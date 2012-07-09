{include file='header.tpl' pageid="magazine_home"}
<script type="text/javascript" src="http://sta.in1001.com/lib/jquery/jquery.cycle.all.js"></script>
<script type="text/javascript" src="/sta/js/gallery.js"></script>
<div class="main">
	<dl class="mag_list m_topic clearfix">
		<dt><strong><span><a href="#">看杂志</a></span></strong></dt>
		{include file="magazine/lib/ad-gallery.tpl" ad_slot=$ad_slot_magtop}
		<dd class="info clearfix">
			<ul class="clearfix">
				<li class="text_list">
					<dl>
						<dt>
							<a href="#">那些年，我们一见倾心的鞋子</a>
						</dt>
						<dd>
							<a href="#">描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述</a>
							<a href="#" class="readmore">阅读+</a>
						</dd>
					</dl>
					<dl>
						<dt>
							<a href="#">那些年，我们一见倾心的鞋子</a>
						</dt>
						<dd>
							<a href="#">描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述</a>
							<a href="#" class="readmore">阅读+</a>
						</dd>
					</dl>
					<dl class="last">
						<dt>
							<a href="#">那些年，我们一见倾心的鞋子</a>
						</dt>
						<dd>
							<a href="#">描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述文字描述</a>
							<a href="#" class="readmore">阅读+</a>
						</dd>
					</dl>
				</li>
				<li>
					<dl>
						{include file="magazine/lib/magcover.tpl"}
					</dl>
				</li>
			</ul>
		</dd>
	</dl>
	
	<dl class="mag_list m_index clearfix">
		<dd class="menu">
			<ul>
				{foreach $cate_magazines as $mags}
				<li><a id="{$mags.cid}"{if $mags@index == 0} class="sel"{/if}>{$mags.cname}</a></li>
				{/foreach}
			</ul>
		</dd>
		<div class="tabs">
			{foreach $cate_magazines as $mags}
			<div class="{$mags.cid}"{if $mags@index > 0} style="display: none"{/if}>
				<dt><a href="{$mags.more_url}" class="more">More</a></dt>
				{foreach $mags.items as $item}
					{include file="magazine/lib/magcover.tpl"}
				{/foreach}
			</div>
			{/foreach}
		</div>
	</dl>
	
</div>
{include file="footer.tpl"}
{include file='share.tpl'}
