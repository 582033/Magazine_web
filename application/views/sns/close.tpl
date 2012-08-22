<!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
<script type="text/javascript" src="http://sta.in1001.com/lib/jquery/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="http://sta.in1001.com/lib/jquery/jquery.cookie.js"></script>
<script type="text/javascript" src="/sta/js/main.js"></script>
<script>
{if $close}
window.close();
{elseif $window}
window.opener.location = '{$url}';
window.close();
{else}
window.location = '{$url}';
{/if}
</script>
</head>
</html>
