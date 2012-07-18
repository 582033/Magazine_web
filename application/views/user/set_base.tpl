	<div class="set_main base">
		<h2>填写基本资料</h2>
		<form name="set_base" action="/user/me/set_base" method="post">
			<p><label for="name">昵称：</label><input type="text" id="name" name="nickname" value="" size="25" /></p>
			<p><label for="sex">性别：</label>
				<select id="sex" name="gender">
					<option {if !$user_info.gender}selected="selected"{/if} value="">无</option>
					<option {if $user_info.gender == 'male'}selected="selected"{/if} value="male">男</option>
					<option {if $user_info.gender == 'female'}selected="selected"{/if} value="female">女</option>
				</select>
			</p>
			<p><label for="bri">生日：</label>
					{$i=1970}
				<select id="bri" name="year">
					{section name="a" loop=60}
					<option selected="selected" value="{$i}">{$i++}</option>
					{/section}
				</select>年
				<select name="month">
					{$i=1}
					{section name="a" loop=12}
					<option selected="selected" value="{if $i < 10}0{/if}{$i}">{$i++}</option>
					{/section}
				</select>月
				<select name="day">
					{$i=1}
					{section name="a" loop=31}
					<option selected="selected" value="{$i}">{$i++}</option>
					{/section}
				</select>日
			</p>
<!--
			<p>
				<label>星座：</label><span>射手座</span>
			</p>
-->
			<p>
				<label for="city">所在地：</label>
				<select id="province" name="province"></select>
				<select id="city" name="city"></select>
			</p>
			<input type="hidden" name="true_province" value="">
			<input type="hidden" name="true_city" value="">
			<p>
				<button class="btn_set" type="submit"><span>完成</span></button>
			</p>
		</form>
	</div>

<script src="/sta/js/area.js"></script>	
{literal}
<script>
	$(function(){
		get_user_info();
	});

	function get_user_info (){
		var $data = {
						url:"/user/get_user_info",
						dataTyle:'json',
						success:function(result){
							$("[name='nickname']").val(result.nickname);
							$("[name='gender']").val(result.gender);
							$("[name='year']").val(result.birthday[0]);
							$("[name='month']").val(result.birthday[1]);
							$("[name='day']").val(result.birthday[2]);
							$.initProv("#province", "#city", result.province, result.city);
						}
					};
		$.ajax($data);
	}
</script>
<script>
	$(function(){
		var pro = $("[name='province']");
		var cty = $("[name='city']");
		pro.change(function(){
			$("[name='true_province']").val($("[name='province'] :selected").text());
		});
		cty.change(function(){
			$("[name='true_city']").val($("[name='city'] :selected").text());
		});
	});

	$(function(){
		$(".btn_set").click(function(){
			var options = {
				dataType : 'json',
				success:    function(result) {
					alert(result);
					get_user_info();
				},
			};
			$('[name="set_base"]').ajaxSubmit(options);
			return false;
		});
	});
</script>
{/literal}
