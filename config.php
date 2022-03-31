<?php
define('DB_SERVER', 'Server');
define('DB_NAME', 'Name');
define('DB_USERNAME', '');
define('DB_PASSWORD', '');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("Couldn't connect. " . mysqli_connect_error());
}
?>