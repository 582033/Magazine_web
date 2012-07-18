{include file="header.tpl"}
<link rel="stylesheet" type="text/css" href="/sta/styles/topic.css"/>
<div class="main_body">
	<img src="/sta/images/topic/heaser.jpg" class="banner" alt="" />
	<dl class="mag clearfix">
		<dt><img src="/sta/images/topic/title01.jpg" alt="" /></dt>
		{foreach from=$mag_recommend item=item key=key}
		<dd>
			<a href="/magazine/detail/{$item.id}">
				<img src="{$item.cover}" width="180" height="276" alt="{$item.name}" />
			</a>
			<h2>
				<a href="/magazine/detail/{$item.id}">{$item.name}</a>
				<span></span>
			</h2>
		</dd>
		{/foreach}
	</dl>
	
	<div class="warp">
		<img src="/sta/images/topic/step.jpg" alt="" border="0" usemap="#Map" />
		<map name="Map" id="Map">
			<area shape="rect" coords="674,46,971,223" href="#" />
			<area shape="rect" coords="338,46,635,223" href="#" />
			<area shape="rect" coords="2,45,299,222" href="#" />
		</map>
	</div>
	<div class="warp">
		<img src="/sta/images/topic/jiang.jpg" alt="" border="0" usemap="#Map2" />
		<map name="Map2" id="Map2">
			<area shape="rect" coords="738,50,891,238" href="#" />
			<area shape="rect" coords="563,50,716,238" href="#" />
			<area shape="rect" coords="380,51,533,239" href="#" />
			<area shape="rect" coords="49,53,351,241" href="#" />
		</map>
	</div>

</div>
{include file="footer.tpl"}
