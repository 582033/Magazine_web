function checkEmail(str) {
	var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
    return reg.test($.trim(str));
}
function isEmpty(str) {
	return $.trim(str) == '';
}
var errMessage = {
	userempty:'邮箱不能为空',
	pwdlength:'密码长度大于6位小于16位',
	pwdempty:'密码不能为空',
	confirmpwd:'两次密码不一样',
	erremail:'邮箱格式错误'
};