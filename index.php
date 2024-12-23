<?php

session_start();

if(isset($_SESSION['user_id']) && isset($_SESSION['role'])){
    header("/panel/index.php");
}else{
    header("/panel/login.php");

}


?>

