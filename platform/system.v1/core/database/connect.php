<?php
$connect_error = 'Sorry, we\'re experiencing connection problems.';
mysql_connect($mysql_host, $mysql_user, $mysql_password) or die($connect_error);
mysql_select_db($mysql_database) or die($connect_error);
?>