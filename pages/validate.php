<?php
	sleep(3); 
	require ("sql_connect.php");
	// $profileName = $_POST['profileName'];

	if(!isset($_POST['profileName']) || $_POST['profileName'] == "")
	{
		echo "Invalid";
		exit();
	}

	//If profileName is valid...	
	$profileName = $_POST['profileName'];
	$nameTaken = 0;
	$query = "SELECT * FROM players";
	$result = $conn->query($query);

	//FOR FILTERING PLAYER NAME / AVOIDING DUPLICATION
	if ($result->num_rows > 0) 
	{    
	    while($row = $result->fetch_assoc())
	    {
	        if($row["playerName"] == $profileName)
	        {
	            $nameTaken++;
	        }
	    }       
	}

	if($nameTaken == 0)
	{
		echo "Available";
	}
	else
	{
		echo "Unavailable";
	}
 ?>