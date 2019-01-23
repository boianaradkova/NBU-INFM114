<?php
$past = time() - 100;
/*
 * Премахване на cookies.
 */ 
setcookie(ID_my_site, gone, $past);
setcookie(Key_my_site, gone, $past);
header("Location: login.php");
?> 
