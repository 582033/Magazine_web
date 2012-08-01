<dd id="element_{$item.id}" class="item{if $favorited} favorited{/if}">
	<div class="cover">
		<a href="{$item.mag_read_url}"><img src="{$item.image.180.url}" width="{$width|default:180}" height="{$height|default:$item.image.180.height}" alt="{$item.magName}" /></a>
		<div class="mouseover">
			<div class="bg"></div>
			<div class="content">
				<a href="{$item.mag_read_url}" class="read" target="_blank">阅读</a>
				{if $cover_show_del}<a href="javascript:void(0)" class="del_mag" onclick="cancelLike('element', '{$item.id}')">删除</a>{/if}
				<div class="more">
					<a href="#" class="share" data-type="2" data-title="{$item.magName}" data-id="{$item.mag_read_url}" data-img="{$item.image.180.url}">分享</a>
					<a href="javascript:void(0);" onclick="like('element','{$item.id}');" class="like">{$item.likes}</a>
				</div>
				<div class="shareto">
					<div class="bg"></div>
				</div>
			</div>
		</div>
	</div>
	{if $cover_show_title}<h3><a href="{$item.mag_read_url}">{$item.title}</a></h3>{/if}
</dd>

