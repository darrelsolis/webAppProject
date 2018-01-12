<?php 
	require ("sql_connect.php"); 
	$playerId = $_POST['playerId'];

	$query = "UPDATE players 
			  SET losses = losses + 1 
			  WHERE playerId={$playerId}";
	$result = $conn->query($query);
	if($result === TRUE)
	{
		echo "Success!";
	}
 ?>