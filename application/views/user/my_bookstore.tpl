<div class="right_main">
	<dl class="mag_list clearfix">
		{if $is_me}
		<dt><a href="/user/me/published" {if $type=='published'}class="sel"{/if}>已发布的杂志<span>({$bookstore[0].pub_total})</span></a>　|　<a href="/user/me/unpublished" {if $type=='unpublished'}class="sel"{/if}>未发布的杂志<span>({$bookstore[0].unpub_total})</span></a></dt>
		{/if}
		{foreach from=$bookstore.items item=item}
		{include file="magazine/lib/magcover.tpl" cover_show_status=$is_me}
		{/foreach}
	</dl>
	{$page_list}
</div>
{literal}
<script>
	$(".new_upload").click(function(){
		val = $(this).next().val();
		$(this).colorbox({href:"/user/appc_mag?mag_id="+val});
	});
	$(".passed").click(function(){
		val = $(this).next().val();
		$html = "<div style='width:200px;height:100px;margin:20px'><center>确认发布杂志？</center><br / ><center><button onclick='pub_mag("+val+")'>确定</button></center></div>";
		$(this).colorbox({html:$html});
	});
	function pub_mag (val) {
		var options = {
			type : 'GET',
			url : "/user/pub_mag?mag_id="+val,
			success : function(result){showMsgbox(result, 'current')},
			}
		$.ajax(options);
	}
</script>
{/literal}
