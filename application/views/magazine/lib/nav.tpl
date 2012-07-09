<div class="nav">
{foreach $navs as $nav}
	{if $nav@index > 0}&gt;{/if}
	{if $nav.current}<span class="cur">{$nav.name}</span>
	{else}<a href="{$nav.url}">{$nav.name}</a>{/if}
{/foreach}
</div>

