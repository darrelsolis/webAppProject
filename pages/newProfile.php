<?php 
	require ("sql_connect.php");
	$newProfileName = $_POST['newProfileName'];
	$currentDate = date("Y-m-d");
	$query = "INSERT INTO players 
			  VALUES (NULL, '{$newProfileName}', 0, '{$currentDate}', 0, 0)";

	$result = $conn->query($query);

	if($result === TRUE)
	{
		$newProfileId = $conn->insert_id;
		echo $newProfileId;
	}
 ?>