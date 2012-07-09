{include file='header.tpl'}
<div class="current clearfix">
	<div class="nav">
		<a href="/">首页</a> &gt; <a href="#" class="cur">个人中心</a>
	</div>
	<div class="menu clearfix">
		<ul>
			{if $is_me}
			<li><a href="/user/{$user_id}/messages"{if $love_msg}class="sel"{/if}>消息中心</a></li>
			{/if}
			<li><a href="/user/{$user_id}/followees" {if $followees}class="sel"{/if}>关注的作者</a></li>
			<li><a href="/user/{$user_id}/elements" {if $element}class="sel"{/if}>喜欢的发现</a></li>
			<li><a href="/user/{$user_id}/magazines" {if $magazine}class="sel"{/if}>喜欢的书</a></li>
			<li><a href="/user/{$user_id}/bookstore" {if $bookstore}class="sel"{/if}>{if $is_me}我的作品{else}作品{/if}</a></li>
		</ul>
	</div>
</div>
    <div class="main main_left_line clearfix">
        {include file='user/sidebar_left.tpl'}
        {if $element}
            {include file='user/element.tpl'}
        {/if}
        {if $magazine}
            {include file='user/magazine.tpl'}
        {/if}
        {if $bookstore}
	    {include file='user/my_bookstore.tpl'}
        {/if}
        {if $msg_page}
	    {include file='user/show.tpl'}
        {/if}
        {if $followees}
	    {include file='user/followees.tpl'}
        {/if}

    </div>
{include file='footer.tpl'}

