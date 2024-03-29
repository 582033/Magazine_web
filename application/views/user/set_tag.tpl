<div class="set_main tag">
		<h2>个人标签</h2>
		<p>添加描述自己职业、兴趣爱好等方面的词语，让更多人找到你，让你找到更多同类</p>
		<form name="tags_form" action="/user/me/set_tag" method="post">
			<input name="tags" type="text" maxlength="8" value="{$tags}"/><button type="submit" class="btn_set"><span>保存</span></button>
		</form>
		
		<dl class="clearfix">
			<dt><a href="javascript:void(0)" class="change">换一组</a>您可能感兴趣的标签：</dt>
			<dd></dd>
		</dl>
		
		<p>关于标签</p>
		<p>·标签是自定义描述自己职业、兴趣爱好的关键词，让更多人找到你，让你找到更多同类。</p>
		<p>·已经添加的标签将显示在"我的微博"页面右侧栏中，方便大家了解你。</p>
		<p>·在此查看你自己添加的所有标签，还可以方便地管理，最多可添加10个标签。</p>
		<p>·点击你已添加的标签，可以搜索到有同样兴趣的人。</p>
		
	</div>
<script>
$(function(){
	change_tag();
	$(".change").click(function(){
		change_tag();
	});
	
	$(".btn_set").click(function(){
		var options = {
			dataType : 'json',
			success : function(result){
				showTipsbox(result, "access");	
			}
		}
		$("[name='tags_form']").ajaxSubmit(options);
		return false;
	});
});

function change_tag(){
	var options = {
		url:"/user/get_tag_list",
		dataType:'json',
		success:function(result){
			var dd_html = "";
			for(i=0;i<=10;i++){
				if (result[i]) dd_html += "<a href='javascript:void(0)'>"+result[i]+"</a>";
			}
			$(".clearfix").find("dd").html(dd_html);
			$(".clearfix").find("dd").children().click(function(){
				val = $("[name='tags']").val();
				if (val==""){
					tag = $(this).text();
				}
				else {
					if (val.length <= 80) { 
						if (val.indexOf($(this).text()) > -1) {
							showTipsbox("您已添加过此标签", "error");	
							tag = val;
						}
						else {
							tag = val +","+$(this).text();
						}
					}
					else {
						showTipsbox("您的标签太多了", "error");	
						tag = val;
					}
				}
				$("[name='tags']").val(tag);
			});
		}
	};
	$.ajax(options);
}
</script>
