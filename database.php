<?php
if(!isset($_SESSION['databaseFileLocker']))
    header('Location: index.php?info=nice_try_hacker');
$host = "127.0.0.1";
$db_user = "pbieniek_gsidkdatabase";
$db_password = "Szuberwlustrze123";
$db_name = "pbieniek_gsidkdatabase";
?>