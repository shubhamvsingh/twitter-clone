<!-- init.php -->
<?php 
include 'database/connection.php';
include 'classes/base.php';
include 'classes/user.php';
include 'classes/tweet.php';
include 'classes/follow.php';
/* code start to display errors */ 
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
/* code end to display errors */
global $pdo;
session_start();
$getFromU = new User($pdo);
$getFromT = new Tweet($pdo);
$getFromF = new Follow($pdo);
define("BASE_URL", "http://localhost/twitter/");
?>
