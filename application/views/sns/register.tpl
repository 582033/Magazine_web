<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<script src="/sta/js/thickbox.js"></script>
<script src="/sta/js/jquery-1.7.2.min.js"></script>
</head>
<body>
<script src="/sta/js/thickbox.js"></script>
<script src="/sta/js/jquery-1.7.2.min.js"></script>
{if $errormessage} {$errormessage} {/if}
<form name="form" action="/index.php/sns/bind" method="POST">
username:<input type="text" name="username"><br />
password:<input type="password" name="passwd"><br />
confirm password:<input type="password" name="confirm_passwd"><br />
<input type="hidden" name="new" value="1">
<input type="hidden" name="snsid" value="{$snsid}">
<input type="hidden" name="apptype" value="{$apptype}">
<input type="hidden" name="status" value="{$status}">
<input type="submit" value="创建">
</form>
<a href="/index.php/sns/bind?new=0&snsid={$snsid}&apptype={$apptype}&status={$status}">绑定已有账号</a>
</body>
</html>