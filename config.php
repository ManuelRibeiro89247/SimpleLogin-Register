<?php

define('DBSERVER', 'localhost'); 
define('DBPASSWORD', 'ruguinhas'); 
define('DBUSERNAME','root');
define('DBNAME', 'schema_user'); 

$db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);

if ($db === false){
    die("Error: connection error." . mysqli_connect_error());
}



