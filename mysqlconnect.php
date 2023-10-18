<?php
$servername="localhost";
$username="root";
$password="";
$dbname="test";
$con = mysqli_connect($servername,$username,$password,$dbname);
if(mysqli_connect_errno()){
    echo "Failed to connect";
    exit();

}
echo "Connected";
?>
<!--check for connection to mysql database-->
