<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<script src="/sta/js/thickbox.js"></script>
<script src="/sta/js/jquery-1.7.2.min.js"></script>
</head>
<body>
{if $errormessage} {$errormessage} {/if}
<form name="form" action="/index.php/sns/bind" method="POST">
username:<input type="text" name="username"><br />
password:<input type="password" name="passwd"><br />
<input type="hidden" name="new" value="0">
<input type="hidden" name="snsid" value="{$snsid}">
<input type="hidden" name="apptype" value="{$apptype}">
<input type="hidden" name="status" value="{$status}">
<input type="submit" value="绑定">
</form>
<a href="/index.php/sns/bind?new=1&snsid={$snsid}&apptype={$apptype}&status={$status}">创建新账号</a>
</body>
</html>