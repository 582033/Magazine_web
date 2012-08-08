<!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
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