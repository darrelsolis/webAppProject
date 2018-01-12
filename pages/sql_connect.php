<?php
//We save this section separately so any page that
//requires to do SQL query can just append this at 
//the beginning of each php page using require();

//Connect to Database and Save Connection to $sql
$conn = mysqli_connect("localhost", "root", "", "webapp_project");

//Check if $sql returns false, meaning connection failed
//Usual causes of failure, wrong spelling, mysql not on
//in XAMPP-Control, wrong username/password
if(!$conn){
	echo "Error Connecting to Database";
	exit();
}
?>