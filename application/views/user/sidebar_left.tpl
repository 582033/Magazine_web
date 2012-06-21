<div class="sidebar_left">
 		<div class="userinfo">
 			<p><a href="#">用户名</a> <a href="#" class="edit">修改</a> <!--a href="#" class="auther">认证作者</a--></p>
 			<div class="user_info">
 				<a href="#">
 					<img src="{if $user_info['image']}{$user_info['image']}{else}/sta/images/userhead/big.jpg{/if}" width="180px" height="180px" class="userhead" alt="用户名" />
 				</a>
 				<ul class="clearfix">
 					<li><a href="#">关注<span>{$user_info['followers']}</span></a></li>
 					<li><a href="#">粉丝<span>{$user_info['followers']}</span></a></li>
 					<li class="last"><a href="#">杂志<span>{$user_info['magazines']}</span></a></li>
 				</ul>
 			</div>
 			<a href="#" class="follow">关注该作者</a>
 			<!--
 			<a href="#" class="attest">认证作者</a>
 			-->
 			<p class="bottombg"></p>
 		</div>
 		
 		<dl class="tag">
 			<dt>我的标签  <a href="#" class="edit">修改</a></dt>
 			<dd>
				{if $user_info['tags']}
					{$i=1}
					{foreach from=$user_info['tags'] item=item}
						<a href="#" class="{if $i++%2=='0'}tag01{else}tag02{/if}">{$item}</a>
					{/foreach}
				{else}
					&nbsp;&nbsp;您还没有设置标签
				{/if}
 			</dd>
 		</dl>
 		
 		<dl class="follows">
 			<dt>我关注的作者</dt>
 			<dd>
 			
 				<div class="clearfix">
					{foreach from=$loved_author item=item}
						<a href="#"><img src="{$item.image}" alt="{$item.nickname}" /><span>{$item.nickname}</span></a>
					{/foreach}
 					<span class="gray"></span>
 				</div>
 			
 			</dd>
 		</dl>
 	</div>
