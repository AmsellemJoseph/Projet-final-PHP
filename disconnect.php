<?php
session_start();
session_unset();
session_destroy();
setcookie('log',$user['secret'],time()-365*24*3600,"/",null,false,true);
header("location: index.php");

?>