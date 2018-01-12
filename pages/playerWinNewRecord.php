<?php
	require ("sql_connect.php"); 
	$playerId = $_POST['playerId'];
	$playerNewWinningHp = $_POST['playerHp'];


	$query = "UPDATE players 
			  SET wins = wins + 1, highestWinningHp = {$playerNewWinningHp} 
			  WHERE playerId={$playerId}";
	
	$result = $conn->query($query);
	if($result === TRUE)
	{
		echo "Success!";
	}
 ?>