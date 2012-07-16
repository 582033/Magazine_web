<div class="sidebar_left">
	<div class="userinfo" id="user_{$user_info.id}">
		<p>
			<a href="/user/{$user_id}">{$user_info.nickname}</a>
			{if $is_me}
			<a href="/user/me/setting" class="edit">修改</a>
			{else}
			<a href="javascript:void(0)" class="auther">认证作者</a>
			{/if}
		</p>
		<div class="user_info">
			<a href="#">
				<img src="{$user_info.image}!180" width="180px" height="180px" class="userhead" alt="1{$user_info.nickname}" />
			</a>
			<ul class="clearfix">
				<li><a href="/user/{$user_id}/followees">关注<span>{$user_info.followees}</span></a></li>
				<li class="last"><a href="/user/{$user_id}/followers">粉丝<span>{$user_info.followers}</span></a></li>
			</ul>
		</div>
		{if $is_me}
		{if $user_info.role == 0}
		<a href="/user/applyAuthor/invitation" class="applyauthor thickbox">申请成为作者</a>
		{else}
		<a href="javascript:void(0)" class="applyauthor alreadyauthor">认证作者</a>
		{/if}
		{else}
		<a class="follow" href="javascript:void(0)" onclick="like('user', '{$user_id}', 'user_center')">加关注</a>
		<p class="followed">
			<a class="followed" href="javascript:void(0)" onclick="like('user', '{$user_id}', 'user_center')">已关注</a>
			<a class="cancel" href="javascript:void(0)" onclick="cancelLike('user', '{$user_id}', 'user_center')">取消</a>
		</p>
		{/if}
		<p class="bottombg"></p>
	</div>
 		
 		<dl class="tag">
			<dt>{if $is_me}我{else}TA{/if}的标签  {if $is_me}<a href="/user/me/set_tag" class="edit">修改</a></dt>{/if}
 			<dd>
				{if $user_info.tags}
					{foreach $user_info.tags as $item}
					<a href="#" class="{cycle values="tag01,tag02"}">{$item}</a>
					{/foreach}
				{else}
					&nbsp;&nbsp;{if $is_me}您{else}TA{/if}还没有设置标签
				{/if}
 			</dd>
 		</dl>
 		
 		<dl class="follows">
			<dt>{if $is_me}我{else}TA{/if}的关注</dt>
 			<dd>
 				<div class="clearfix">
					{foreach from=$loved_author.items item=item}
						<a href="/user/{$user_id}"><img src="{$item.image}!50" width="50" height="50" alt="{$item.nickname}" /><span>{$item.nickname}</span></a>
					{/foreach}
					<span class="curnick"></span>
 					<span class="gray"></span>
 				</div>
 			</dd>
 		</dl>
 	</div>
