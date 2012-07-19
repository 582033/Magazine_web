	<div class="right_main">
		<div class="msg_list clearfix">
			<div class="my_follow_list">
				{foreach from=$follows['items'] item=item}
				<dl class="clearfix">
					<dt><a href="/user/{$item.id}"><img src="{$item.image}!50" alt="{$item.nickname}" /></a></dt>
					<dd>
						<strong><a href="/user/{$item.id}">{$item.nickname}</a></strong>
<!--
						<p><a href="#">关注</a> | <a href="#">发现</a> | <a href="#">作品{$item.magazines}</a></p>
-->
						{if $is_me && $follow_type=='followee'}
						<span><a href="javascript:void(0)" onclick="cancelLike('user', '{$item.id}', 'user_center_followee')">取消关注</a></span>
						{/if}
					</dd>
				</dl>
				{/foreach}	
			</div>
			{$page_list}		
		</div>
	</div>
</div>
