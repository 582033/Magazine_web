			<ul>
				{if $is_me}
				<li><a href="/user/{$user_id}/messages"{if $love_msg}class="sel"{/if}>消息中心</a></li>
				{/if}
				<li><a href="/user/{$user_id}/followees" {if $followees}class="sel"{/if}>关注的作者</a></li>
				<li><a href="/user/{$user_id}/elements" {if $element}class="sel"{/if}>喜欢的发现</a></li>
				<li><a href="/user/{$user_id}/magazines" {if $magazine}class="sel"{/if}>喜欢的书</a></li>
				<li><a href="/user/{$user_id}/bookstore" {if $bookstore}class="sel"{/if}>{if $is_me}我的作品{else}作品{/if}</a></li>
			</ul>
