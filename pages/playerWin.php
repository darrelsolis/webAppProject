<?php
	require ("sql_connect.php"); 
	$playerId = $_POST['playerId'];

	$query = "UPDATE players 
			  SET wins = wins + 1 
			  WHERE playerId={$playerId}";
	
	$result = $conn->query($query);
	if($result === TRUE)
	{
		echo "Success!";
	}
 ?>