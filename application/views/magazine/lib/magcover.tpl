<dd{if $dd_class} class="{$dd_class}"{/if}{if $dd_style} style="{$dd_style}"{/if}>
	<div class="cover">
		<a href="/magazine/detail/{$item.id}"><img src="{$item.cover}" width='180px' height='276px' alt="{$item.name}" /></a>
		<div class="mouseover">
			<div class="bg"></div>
			<div class="content">
<!--
				<div class="info">
					<ul style="margin-left:2px;">
						<li><span>杂志：</span><span>{$item.name}</span></li>
						<li><span>作者：</span><span>{$item.author.nickname}</span></li>
						<li><span>发布：</span><span>{$item.publishedAt}</span></li>
					</ul>
				</div>
-->
				<a href="/magazine/detail/{$item.id}" class="read">阅读</a>
				{if $cover_show_del}<a href="javascript:void(0)" class="del_mag" onclick="cancelLike('magazine', '{$item.id}')">删除</a>{/if}
				<div class="more">
					<a href="/magazine/{$item.id}/comments" class="comment">评论</a>
					<a href="javascript:void(0);" class="share" data-type="1" data-title="{$item.name}" data-des="{$item.intro|truncate:30}" data-id="{$item.id}" data-img="{$item.cover}">分享</a>
					<a href="javascript:void(0);" id="magazine_{$item.id}" onclick="like('magazine','{$item.id}');" class="like">{$item.likes}</a>
				</div>
				<div class="shareto">
					<div class="bg"></div>
				</div>
			</div>
		</div>
	</div>
	<h3><a href="/magazine/detail/{$item.id}" title="{$item.name}">{$item.name}</a></h3>
	{if $cover_show_intro}<p>{$item.intro|truncate:30}</p>{/if}
	{if $cover_show_status}
	<div class="edit_btn">
		{if $item.status == '0'}<span>新上传</span>{/if}
		{if $item.status == '1'}<span>审核中</span>{/if}
		{if $item.status == '3'}<span>审核未通过</span>{/if}
		{if $item.status == '2'}<a href="#">审核通过</a>{/if}
	</div>
	{/if}
</dd>

