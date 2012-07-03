{include file='header.tpl'}
    <div class="current"><a href="#">首页</a> &gt; <a href="#" class="cur">个人中心</a></div>
    <div class="main main_left_line clearfix">
        {include file='user/sidebar_left.tpl'}
        {if $loved_element}
            {include file='user/element.tpl'}
        {/if}
        {if $loved_magazine}
            {include file='user/magazine.tpl'}
        {/if}
        {if $bookstore}
	    {include file='user/my_bookstore.tpl'}
        {/if}
        {if $msg_page}
	    {include file='msg/show.tpl'}
        {/if}
	

    </div>
{include file='footer.tpl'}

