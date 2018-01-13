<?php
	require ('sql_connect.php');
	$query = "SELECT * FROM players ORDER BY lastDatePlayed DESC";
	$result = $conn->query($query);

	//LEADERBOARD

	//HIGHEST WINNING HP
	$highestHpQuery = "SELECT playerId, playerName, highestWinningHp 
					   FROM players 
					   WHERE highestWinningHp != 0 
					   ORDER BY highestWinningHp 
					   DESC";
	$highestHpResult = $conn->query($highestHpQuery);

	//HIGHEST WINS
	$highestWinsQuery = "SELECT playerId, playerName, wins, losses 
						 FROM players 
						 WHERE wins != 0 
						 ORDER BY wins 
						 DESC";
	$highestWinsResult = $conn->query($highestWinsQuery);
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Hearthstone - ICT 141 Project</title>
	<style type="text/css">
		body{
			background-image: url("../images/background.jpg");
			background-repeat: no-repeat;
			background-size: cover;
			color: white; 
			font-family: "Trebuchet MS";
		}

		#logo{
			display: none;
		}

        .gameButton
        {
        	border: 3px solid #fa8f04;
            background-image: url('../images/hpBackground.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        	width: 10em; 
        	font-size: 1.5em;  
        	color: white; 
        	font-family: "Trebuchet MS";
        }

        .buttons
        {
        	display: none;
        }
        .gameButton:hover
        {
            border: 3px solid gold;	
        }
        button 
        { 
        	cursor: pointer; 
        	cursor: hand; 
        }
        #profileName
        {
        	width: 20em;
        	font-family: "Trebuchet MS";
        	font-size: 1.2em;
        	text-align: center;
        }
        .newGame, .leaderboard, .hw-lb-table
        {
        	display: none;
        }

        .leaderboard
        {
        	width: 60%;
        }

        .playersRegistered
        {
        	width: 60%;
        	display: none;
        	color: white;
        }
        #highestWinningHpButton
        {
        	width: 300px;
        }

        td
        {
        	background-color: transparent;
        }

        #confirm, .validation, #validationLoading
        {
        	display: none;
        }

       	#available
       	{
       		color: green;
       	}
       	#invalid, #unavailable
       	{
       		color: red;
       	}

       	#validationLoading
       	{
       		width: 50px;
       	}
       	table.dataTable tbody tr:hover
       	{
       		background-image: url("../images/hpBackground.jpg");
       	}
       	.datatables-td
       	{
       		width: 200px;
       	}
       	.datatables-td-buttons
       	{
       		width: 100px;
       	}
       	.play
       	{
       		width: 100px; 
       		font-size: 15px;
       	}
	</style>
</head>
<link rel="stylesheet" type="text/css" href="../assets/css/animate.css">
<link rel="stylesheet" type="text/css" href="../assets/datatables.css">
<body>
		
		<center>
			<div class='container'>
				<img id='logo' src='../images/logo.png'><br>

				<div class='buttons'>
					<button type='button' class='gameButton' id='newGame' > New Game </button><br><br><br>
					<button type='button' class='gameButton' id='continue'> Continue </button><br><br><br>
					<button type='button' class='gameButton' id='leaderboard'> Leaderboard </button>
				</div>

				<div class='newGame'>
						<h2> Enter Player Name: </h2><br> 
						<input type='text' id='profileName'> <br>

						<!--Profile Name Validation-->
						<small class='validation' id='invalid'> Invalid input! </small>
						<small class='validation' id='unavailable'> Player name already taken! </small>
						<small  class='validation' id='available'> Player name available! </small><br>
						<!--//Profile Name Validation-->

						<img id='validationLoading' src='../images/loadingDots.gif'><br><br>
						<button type='button' class='gameButton' id='check'> Check </button>
						<button type='button' class='gameButton' id='confirm'> Confirm </button>
						<button type='button' class='gameButton' id='back-new'> Back </button>
				</div>

				<div class='playersRegistered'>
					<table id="players" class="display" cellspacing="0" width="70%">
				        <thead>
				            <tr>
				            	<th>Last Date Played</th>
				                <th>Player Name</th>
				                <th>  </th>
				            </tr>
				        </thead>
				        <tbody>        	
				                <?php 
				                	if($result->num_rows > 0)
				                	{
				                		while($row = $result->fetch_assoc())
				                		{
				                			echo "<tr>";
				                				echo "<td class='datatables-td'>{$row['lastDatePlayed']}</td>";	
					                			echo "<td class='datatables-td'>{$row['playerName']}</td>";
					                			echo "<td class='datatables-td'> <a href='index.php?playerId={$row['playerId']}'><button class='gameButton play' type='button'> Play </button> </a> </td>";	
					                		echo "</tr>";
				                		}
				                	}
				                 ?>	
				        </tbody>
    				</table><br>
    				<button type='button' class='gameButton' id='back-continue'> Back </button>
				</div>

				<div class='leaderboard'>
					<h1> Leaderboard - <span id='lbView'> </span></h1>
					
					<div class='hwh-lb-table'>
						<table class="display dTable" cellspacing="0" width="60%">
							<thead>
								<th> Rank </th>
								<th> Player Name </th>
								<th> Highest Winning Hp </th>
							</thead>

							<tbody>
								<?php
									$highestHpRank = 1;
									$hpContainer = 0; 
									if($highestHpResult->num_rows > 0)
									{
										while($highestHpRow = $highestHpResult->fetch_assoc())
										{
											if($hpContainer != 0)
											{
												if($highestHpRow['highestWinningHp'] != $hpContainer)
												{
													$highestHpRank += 1;
												}
											}
											echo "<tr>";
												echo "<td>{$highestHpRank}</td>";
												echo "<td>{$highestHpRow['playerName']}</td>";
												echo "<td>{$highestHpRow['highestWinningHp']}</td>";
											echo "</tr>";
											$hpContainer = $highestHpRow['highestWinningHp'];
										}
									}
								 ?>
							</tbody>
						</table>
					</div>

					<div class='hw-lb-table'>
						<table class="display dTable" cellspacing="0" width="60%">
							<thead>
								<th> Rank </th>
								<th> Player Name </th>
								<th> Wins </th>
							</thead>

							<tbody>
								<?php
									$highestWinsRank = 1;
									$winsContainer = 0; 
									if($highestWinsResult->num_rows > 0)
									{
										while($highestWinsRow = $highestWinsResult->fetch_assoc())
										{
											if($winsContainer != 0)
											{
												if($highestWinsRow['wins'] != $winsContainer)
												{
													$highestWinsRank += 1;
												}
											}
											echo "<tr>";
												echo "<td>{$highestWinsRank}</td>";
												echo "<td>{$highestWinsRow['playerName']}</td>";
												echo "<td>{$highestWinsRow['wins']}</td>";
											echo "</tr>";
											$winsContainer = $highestWinsRow['wins'];
										}
									}
								 ?>
							</tbody>
						</table>
					</div>
					<br>
					<button type='button' class='gameButton' id='back-leaderboard'> Back </button>
					<button type='button' class='gameButton' id='highestWinningHpButton'> Highest Winning Hp </button>
					<button type='button' class='gameButton' id='highestWinsButton'> Highest Wins </button>
				</div>
			</div>
		</center>
</body>
</html>

<script type="text/javascript" src="../assets/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="../assets/datatables.js"></script>
<script type="text/javascript" src="../assets/js/animatedModal.min.js"></script>

<script>
		$(document).ready(function(){
			$('.dTable').DataTable({
				"columnDefs": [
				{"className": "dt-center", "targets": "_all"}
				],
			});
			$("#players").DataTable({
		      "order":[[0,'desc']],
		      "columnDefs": [
		      	{"className": "dt-center", "targets": "_all"},
			  ]
		    });

			setTimeout(function(){
				$("#logo").fadeIn();
			}, 1000);
			setTimeout(function(){
				$(".buttons").fadeIn();
			}, 2000);

			$("#newGame").click(function(){
				$(".buttons").fadeOut();
				setTimeout(function(){
					$(".newGame").fadeIn();
				}, 500);					
			});

			$("#continue").click(function(){
				$(".buttons").fadeOut();
				setTimeout(function(){
					$(".playersRegistered").fadeIn();
				}, 500);					
			});

			$("#leaderboard").click(function(){
				$(".buttons").fadeOut();
				setTimeout(function(){
					$(".leaderboard").fadeIn();
				}, 500);
				$("#lbView").text("Highest Winning Hp");		
				$("#highestWinningHpButton").hide();			
			});

			$("#highestWinsButton").click(function(){
				$("#lbView").text("Highest Wins");
				$(".hwh-lb-table").fadeOut();
				setTimeout(function(){
					$(".hw-lb-table").fadeIn();
				}, 500);
				$("#highestWinsButton").hide();
				$("#highestWinningHpButton").show();
			});

			$("#highestWinningHpButton").click(function(){
				$("#lbView").text("Highest Winning Hp");
				$(".hw-lb-table").fadeOut();
				setTimeout(function(){
					$(".hwh-lb-table").fadeIn();
				}, 500);
				$("#highestWinningHpButton").hide();
				$("#highestWinsButton").show();
			});

			$("#back-new").click(function(){
				$(".validation").hide();
				$("#confirm").hide();
				$("#check").show();
				$("#profileName").prop('disabled', false);
				$("#profileName").val("");
				$(".newGame").fadeOut();
				setTimeout(function(){
					$(".buttons").fadeIn();
				}, 500);					
			});

			$("#back-continue").click(function(){
				$(".playersRegistered").fadeOut();
				setTimeout(function(){
					$(".buttons").fadeIn();
				}, 500);					
			});

			$("#back-leaderboard").click(function(){
				$(".leaderboard").fadeOut();
				setTimeout(function(){
					$(".buttons").fadeIn();
					$("#highestWinsButton").show();
					$(".hwh-lb-table").show();
					$(".hw-lb-table").hide();
				}, 500);
				
			});

			$("#check").click(function(){
				$(".validation").hide();
				var profileName = $("#profileName").val();
				$("#check").hide();
				$("#validationLoading").show();
				$.ajax({
					type: "POST",
					url: "validate.php",
					data: {profileName: profileName},
					success: function(data)
					{
						$("#validationLoading").hide();
						if(data == "Available")
						{
							$("#available").show();
							$("#confirm").show();
							$("#profileName").prop('disabled', true);
						}
						else if(data == "Unavailable")
						{
							$("#unavailable").show();
							$("#check").show();
						}
						else
						{
							$("#invalid").show();
							$("#check").show();
						}
					}
				});
			});

			$("#confirm").click(function(){
				var newProfileName = $("#profileName").val();
				$.ajax({
					type: "POST",
					url: "newProfile.php",
					data: {newProfileName : newProfileName},
					success: function(data)
					{
						window.location.replace("http://localhost/webAppProject/pages/index.php?playerId="+data);
					}
				});
			});
		});
</script>

