	<div class="set_main base">
		<h2>填写基本资料</h2>
		<form>
			<p><label for="name">昵称：</label><input type="text" id="name" name="nickname" value="{$user_info.nickname}" size="25" /></p>
			<p><label for="sex">性别：</label>
				<select id="sex" name="gender">
					<option {if $user_info.gender == 'male'}selected="selected"{/if}>男</option>
					<option {if $user_info.gender == 'female'}selected="selected"{/if}>女</option>
				</select>
			</p>
			<p><label for="bri">生日：</label>
				<select id="bri" name="year">
					<option>1990</option>
					<option selected="selected">1989</option>
				</select>年
				<select name="month">
					<option>12</option>
					<option>11</option>
					<option selected="selected">10</option>
				</select>月
				<select name="year">
					<option>30</option>
					<option selected="selected">29</option>
					<option>28</option>
					<option>27</option>
					<option>26</option>
				</select>日
			</p>
			<p>
				<label>星座：</label><span>射手座</span>
			</p>
			<p>
				<label for="city">所在地：</label>
				<select id="city">
					<option>上海</option>
					<option selected="selected">北京</option>
				</select>
				<select>
					<option selected="selected">北京</option>
				</select>
			</p>
			<p>
				<button class="btn_set" type="submit"><span>完成</span></button>
			</p>
		</form>
	</div>
