<?php
$con=mysql_connect('dev','root','');
mysql_select_db('magazine');
mysql_set_charset('utf8',$con);
$query=file_get_contents('addmsg.sql');
for($i=0;$i<99$i++){

mysql_query($query);
echo mysql_affected_rows()."<br>";
}


