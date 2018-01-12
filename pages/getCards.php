<?php
	require('sql_connect.php');
	if(isset($_POST["cardId"]))
	{ 
		$cardId = $_POST['cardId'];
		$query = "SELECT * FROM cards WHERE cardId={$cardId}";
		$result = mysqli_query($conn, $query);
		$row = $result->fetch_array();
		echo json_encode($row);
	}
	






 ?>