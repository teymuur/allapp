<?php
session_start();
setcookie("username", "", time()-3600);
setcookie("password", "", time()-3600);

session_unset();
session_destroy();

header("Location: login.php");
exit();
?>
