<?php 
//$connect= new mysqli_connect("localhost","project","project","project")


$connect = mysqli_connect("database","project","project","project");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?> 
