 <?php 
    require('sql_connect.php');

    if(!isset($_GET['playerId']))
    {
        header('Location: home.php');
    }

    $playerId = $_GET['playerId'];

    $query = "SELECT * FROM players WHERE playerId={$playerId}";
    $result = $conn->query($query);

    $row = $result->fetch_assoc();
    $playerHighestHp = $row['highestWinningHp'];

    $currentDate = date("Y-m-d");
    $updateQuery = "UPDATE players SET lastDatePlayed = '{$currentDate}' WHERE playerId={$playerId}";
    $updateResult = $conn->query($updateQuery);
 ?>

<!DOCTYPE html>
<html>
<head>
    <title>Hearthstone - ICT 141 Project</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/animate.css"> 

    <style type="text/css">
        html, body 
        {margin: 0; height: 100%; /*overflow: hidden*/}
        html
        {
             zoom: 70%;   
        }
        body
        {
            margin-top: 20px;
            background-image: url("../images/background.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }
        body,input
        {
            font-family: Trebuchet MS;
            color: white;
        }
        label
        {
            font-size: 2em;
        }
        .playerDetails
        {
            display: inline; 
            margin-left: 30px;
        }
        #playerDetails-inline
        {
            display: inline;
        }
        .hp
        {
            border: 3px solid #660000;
            background-image: url('../images/hp.jpg');
            background-repeat: repeat;
            background-size: cover;            
        }
        .buttonStyle
        {
            border: 3px solid #fa8f04;
            background-image: url('../images/hpBackground.jpg');
            background-repeat: no-repeat;
            background-size: cover;            
        }
        .trans
        {
            background-color: transparent;
        }
        .playerDeck
        {
            margin-top: -5em;
        }
        .enemyDeck
        {
            margin-top: -5em;
        }
        .rep
        {
            width: 100%;
        }
        .damage
        {
            color: red;
        }
        .startDuel:hover
        {
           /* opacity: */
        }
        .endTurn
        {
            width: 5em; 
            font-size: 2em; 
            border: 3px solid orange;
            display: none;
        }
        #enemyEndTurn
        {
            border: 3px solid gold;
        }
        .status, .inviTriggerButton, #playAgain
        {
            display: none;
        }
        .bonus
        {
            font-size: 1.5em; margin-left: 12px;
            display: none;
        }
        #loading
        {
            margin-top: 150px;
            width: 500px;
        }
        #playerRep, #enemyRep
        {
            width: 75%; 
            margin-left: -0px;
        }
        #startDuel, #playAgain
        {
            width: 10em; 
            font-size: 2em; 
            border: 3px solid orange;
        }
       .modalStyle
       	{
       		position: fixed;
            width: 100%;
            height: 100%;
            top: 0px;
            left: 0px;
            background-color: rgba(47, 29, 0, 0.83);
            overflow-y: auto;
            z-index: 9999;
            opacity: 1;
            animation-duration: 0.6s;
            background-image: url("../images/modalBg.jpg"); background-repeat: no-repeat; background-size: cover;
       	}
       	.cardInModal
       	{
       		width:250px;
       	}
       	.modalTable
       	{
       		border-spacing: 50px;
       	}
        .atkBonus
        {
            color: gold; 
            text-align: center;
        }
        .cardLabel
        {
            text-align: center;
        }
        .battleInfo-h1
        {
            font-size: 3em;
        }
        .battleInfo-box
        {
            width: 1500px; 
            height: 400px;
            padding: 30px;
            border: 2px double #cc9900;
        }
        .battleInfo-line
        {
            width: 70%; 
            border: 1px solid #cc9900;
        }
        .button-backToMainMenu
        {
            width: 10em; 
            font-size: 1.5em; 
            color: white; 
            border: 3px solid orange;
        }
        .button-backToMainMenu:hover, .endTurn:hover, #startDuel:hover, #playAgain:hover
        {
            border: 3px solid gold;
        }
        .link-backToMainMenu
        {
            display: inline; 
            float: right;
        }
    </style>
</head>
<body>
    <br> 
    <center> 
        <img id="loading" src="../images/loading.gif">
    </center>
    <main class="container">     
        <input type='hidden' id='playerId' value='<?php echo $playerId; ?>'>       
        <input type='hidden' id='playerHighestHp' value='<?php echo $playerHighestHp; ?>'>
        <h1 id='playerDetails-inline' class='playerDetails-Name'> Player: <span id='playerName'><?php echo $row['playerName']; ?></span> </h1>
        <h2 class='playerDetails'> W: <span id='wins'> <?php echo $row['wins']; ?> </span> | L: <span id='losses'><?php echo $row['losses']; ?></span> </h2>
        <h2 class='playerDetails'> Highest Winning HP: <span id='highestHp'> <?php echo $row['highestWinningHp']; ?> </span></h2>

        <!--Invisible Button-->
        <button type='button' class='inviTriggerButton' id='trigger' href="#animatedModal"></button>
         <!--//Invisible Button-->
        <a class='link-backToMainMenu' href='home.php'> <button class='buttonStyle button-backToMainMenu' id='backToMain' type='button'> Back to Main Menu </button> </a>
        

        <!--ENEMY SIDE-->
        <div class="trans row panel panel-default">
            <div class="container">
                <br>
                <div>
                    <div class="row spells-magics enemyCards"> 
                        <!--ENEMY'S DECK HOLDER-->
                        <div class="enemyDeckHolder col-xs-1 col-md-1">                                                     
                            <a href="#" class="thumbnail">
                                <img src="../images/cardCover.png">
                            </a>
                            <div class='enemyDeck'>
                                <center>
                                    <strong><label id="enemyDeckCount"></label></strong>
                                </center>   
                            </div>

                        </div>
                        <!--//ENEMY'S DECK HOLDER-->

                        <!--ENEMY'S HAND-->
                        <div class="col-xs-1 col-md-1 col-md-offset-1">
                            <a href="#" class="thumbnail">
                                <img id="enemyCard1" class="enemy" src="" data-enemyCardNum="" data-elem='' data-atk='' data-cardIndex="0">
                            </a>
                        </div>
                        <?php 
                            for ($e=2, $f=1; $e <= 5; $e++,$f++) 
                            { 
                                echo "<div class='col-xs-1 col-md-1'>
                                            <a href='#' class='thumbnail'>
                                                <img id='enemyCard{$e}' class='enemy' src='' data-enemyCardNum='' data-elem='' data-atk='' data-cardIndex='{$f}'>
                                            </a>
                                      </div>";
                            }
                        ?>
                        <!--//ENEMY'S HAND-->
                    </div>
                </div>
                
                <br>
                <!--ENEMY'S BATTLEFIELD -->                 
                    <div class="row spells-magics enemyBattlefield">
                        <!--ENEMY'S GRAVEYARD-->
                        <div class="col-xs-1 col-md-1">
                            <a href="#" class="thumbnail">
                                <img id='eGrave' src="../images/exit.jpg">
                            </a>
                        </div>
                        <!--//ENEMY'S GRAVEYARD-->

                        <!--ENEMY'S END TURN BUTTON-->                            
                        <div class="col-xs-1 col-md-1 col-md-offset-1">
                            <div class='enemyEndTurn'>
                                    <button class='buttonStyle endTurn' id='enemyEndTurn' type='button'> END TURN </button>
                             </div> 
                        </div>                           
                        <!--//ENEMY'S END TURN BUTTON-->

                        <!--ENEMY'S CARD REPRESENTATIVE-->
                        <div class="col-xs-1 col-md-1 col-md-offset-1" id='enemyMonster'>
                            <div class='front'>                            
                                <a href="#" class="thumbnail">
                                    <img id="enemyRep" src="../images/cardHolder.png" data-atk="">
                                </a>
                            </div>
                            <div class='back'>                               
                                <a href="#" class="thumbnail">
                                    <img id='enemyRepBack' src="">
                                </a>
                                <small id='eBonus' class='bonus'> (+1000) </small>
                            </div>
                        </div>

                        <!--//ENEMY'S CARD REPRESENTATIVE-->

                        <!--ENEMY'S HP-->
                        <div class="hp col-xs-1 col-md-1 col-md-offset-1">
                            <h1> HP </h1>
                            <h1 id="enemyHp"></h1>
                            <h1 class='damage' id='dmgToEnemy'></h1>
                        </div>
                        <!--//ENEMY'S HP-->
                    </div>
                
                <!--//ENEMY'S BATTLEFIELD -->
            </div>
             <br>
        </div>

        <!--//ENEMY SIDE-->

        <!--PHASE/STATUS SIDE-->
        <div class="trans row panel panel-default well">
            <center>                
                <strong>
                    <button class='buttonStyle' id='startDuel' type='button'> Start Duel </button>
                    <button class='buttonStyle' id='playAgain' type='button'> Play Again </button>
                </strong>
                <h1 class='status' id='statusPlayerPick'> PLAYER'S TURN </h1>
                <h1 class='status' id='statusEnemyPick'> CPU'S TURN </h1>
                <h1 class='status' id='statusBattle'> BATTLE PHASE </h1>
                <h1 class='status' id='endRound'> END OF ROUND </h1>
                <h1 class='status' id='gameOver'>GAME OVER</h1>
                <h1 class='status' id='winner'> </h1>
            </center>
        </div>
        <!--// PHASE/STATUS SIDE-->

        <!--PLAYER SIDE-->
        <div class="trans row panel panel-default">
            <div class="container">
                <!--PLAYER'S BATTLEFIELD-->
                
                    <br>                    
                    <div class="row spells-magics playerBattlefield">                                                
                            <!--PLAYER'S HP-->
                            <div class="hp col-xs-1 col-md-1 col-md-offset-2">
                                 <h1> HP </h1>
                                 <h1 id="playerHp"></h1>  
                                 <h1 class='damage' id='dmgToPlayer'> </h1>                               
                            </div>
                            <!--//PLAYER'S HP-->
                        
                            <!--PLAYER'S CARD REPRESENTATIVE-->                            
                                <div class="col-xs-1 col-md-1 col-md-offset-1" id="playerMonster">
                                    <div class='front'>                                        
                                        <a href="#" class="thumbnail">
                                            <img id='playerRep' data-atk="" data-lastPosition="">
                                        </a>
                                    </div>

                                     <div class='back'>
                                        <small id='pBonus' class='bonus'> (+1000)</small>
                                        <a href="#" class="thumbnail">
                                            <img id='playerRepBack' src="">
                                        </a>
                                     </div> 
                                </div>                           
                            <!--//PLAYER'S CARD REPRESENTATIVE-->

                                <!--PLAYER'S END TURN BUTTON-->                            
                                    <div class="col-xs-1 col-md-1 col-md-offset-1">
                                        <div class='playerEndTurn'>
                                                <button class='hp endTurn' id='playerEndTurn' type='button'> END TURN </button>
                                         </div> 
                                    </div>                           
                                <!--//PLAYER'S END TURN BUTTON-->                          

                            <!--PLAYER'S GRAVEYARD-->
                            <div class="col-xs-1 col-md-1 col-md-offset-1">
                                <a href="#" class="thumbnail">
                                    <img id='pGrave' src="../images/exit.jpg">
                                </a>
                            </div> 
                            <!--//PLAYER'S GRAVEYARD-->                
                    </div>
                <br>

                <!--PLAYER'S HAND-->
                <div>
                    <div class="row spells-magics">
                        <div class='col-xs-1 col-md-1 col-md-offset-2'>
                            <a href='#' class='thumbnail'>
                                <img class='player' id='playerCard1' src='' data-playerCardNum='' data-playerCardName='' data-elem='' data-atk='' data-cardIndex='0'>
                            </a>
                        </div>

                        <?php 
                            for($p = 2, $q = 1; $p <= 5; $p++, $q++)
                            {
                                echo "<div class='col-xs-1 col-md-1'>
                                            <a href='#' class='thumbnail'>
                                                <img class='player' id='playerCard{$p}' src='' data-playerCardNum='' data-playerCardName='' data-elem='' data-atk='' data-cardIndex='{$q}'>
                                            </a>
                                      </div>";
                            }
                        ?>
                        <!--PLAYER'S DECK HOLDER-->
                        <div class="deck playerDeckHolder col-xs-1 col-md-1 col-md-offset-1">
                            <center>
                            <strong><label id="playerDraw"> </label></strong>                                    
                            </center>                             
                            <a id='playerDeck' href="#" class="thumbnail">
                                <img src="../images/cardCover.png">                        
                            </a>
                            <div class="playerDeck">
                               <center>
                                    <strong><label id="playerDeckCount">  </label></strong>
                                </center> 
                            </div>                            
                        </div>
                         <!--//PLAYER'S DECK HOLDER-->
                    </div>
                </div>
            </div>
        </div>
    </main>


    <!--BPM - BATTLE PHASE MODAL-->
    <div id="animatedModal">
        <div class="close-animatedModal fadeOut" id="modalClose"> 
        </div>
            
        <div class="modal-content modalStyle">
    		<center>
    	      	<table class='modalTable'>
    	        	<tr>
    	          		<td>
                            <h1 class='cardLabel'>PLAYER</h1>
                            <img src="" id='playerCardInModal' class='cardInModal'>
                        </td>
    	          		<td><img src="../images/vs.png" class='cardInModal'> </td>
    	          		<td>
                            <h1 class='cardLabel'>CPU</h1>
                            <img src="" id='enemyCardInModal' class='cardInModal'>
                        </td>
    	          	</tr>

                    <tr>    
                        <td><h2 class='atkBonus' id='playerAtkBonus'>+1000 ATK</h2> </td>
                        <td></td>
                        <td><h2 class='atkBonus' id='enemyAtkBonus'>+1000 ATK</h2> </td>
                    <tr>
    	      	</table>

                <br>
                <div id='battleInfoBox' class='battleInfo-box'>
                    <h1 class='battleInfo battleInfo-h1' id='battleInfoHeader'> BATTLE INFO </h1>
                    <hr class='battleInfo battleInfo-line' id='battleInfoLine'>
        	      	<h1 class='battleInfo' id='resistanceInModal'></h1>
        	      	<h1 class='battleInfo' id='outcomeInModal'></h1>
        	      	<h1 class='battleInfo' id='damageGivenInModal'></h1>
                </div>
          	</center>
        </div>
    </div>
    <!--//BATTLE PHASE MODAL-->
</body>
</html>

<script type="text/javascript" src="../assets/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="../assets/jquery/jquery-ui.min.js"></script>
<script type="text/javascript" src="../assets/jquery/jquery.flip.min.js"></script>
<script type="text/javascript" src="../assets/jquery/jquery.bighover-master/jquery.bighover.js"></script>
<script type="text/javascript" src="../assets/js/animatedModal.min.js"></script>

<script>
    $("#trigger").animatedModal({
        animatedIn: 'zoomIn',
        animatedOut: 'bounceOut'
    });    
    var playerDeckCount = 20;
    var enemyDeckCount = 20; 
    // var thread_id = null;
    
    var pTurn = 1;
    var pPick = 1;

    var eTurn = 1;

    var playerDraw = 1;
    var enemyDraw = 0;

    var enemyCardOrder = []; 
    while(enemyCardOrder.length < 20)
    {
        var randomnumber = Math.ceil(Math.random()*20);
        if(enemyCardOrder.indexOf(randomnumber) > -1) continue;
        enemyCardOrder[enemyCardOrder.length] = randomnumber;
    }

    var playerCardOrder = [];
    while(playerCardOrder.length < 20)
    {
        var randomnumber = Math.ceil(Math.random()*20);
        if(playerCardOrder.indexOf(randomnumber) > -1) continue;
        playerCardOrder[playerCardOrder.length] = randomnumber;
    }
    var emptyCards = 0;
    var playerHand = [];
    var enemyHand = [];

    var playerHp = 4000;
    var enemyHp = 4000;

    var pEmptyCardId = 0;
    var eEmptyCardId = 0;

    var playerChoice;
    var enemyChoice;

    var indexEnemy = 0;

    var eAtrReturned = 0;
    var pAtrReturned = 0;

    $(document).ready(function(){
        $("#enemyMonster").flip({
          axis: 'y',
          trigger: 'manual'
        });
        $("#playerMonster").flip({
          axis: 'y',
          trigger: 'manual'
        });

        $("main").hide();
        $("#playAgain").click(function(){
            window.location.reload();
        });
        setTimeout(function(){
            $("#loading").fadeOut();             
        }, 3000);
        setTimeout(function(){
            $("main").fadeIn();            
        }, 3500);
        
        $(".player").attr("src", "../images/cardHolder.png");        
        $(".enemy").attr("src", "../images/cardHolder.png");

        $("#playerRep").attr("src", "../images/cardHolder.png");
        $("#enemyRep").attr("src", "../images/cardHolder.png"); 

        $("#enemyDeckCount").text(enemyDeckCount);
        $("#playerDeckCount").text(playerDeckCount);

        $("#enemyHp").text(enemyHp);
        $("#playerHp").text(playerHp);

        $("#startDuel").click(function(){
            $("#startDuel").fadeOut();
            $("#statusPlayerPick").fadeIn("slow");

            var ctrEnemy = 1;
            enemyHand = enemyCardOrder.slice(-5);
            enemyHand.reverse();
            enemyCardOrder.splice(-5);
            enemyHand.forEach(function(card){
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "getCards.php",
                        data: {cardId: card},
                        success: function(data){
                            $("#enemyCard"+ctrEnemy).attr("src", "../images/cardCover.png");
                            $("#enemyCard"+ctrEnemy).attr("data-enemyCardNum", data.cardId);
                            $("#enemyCard"+ctrEnemy).attr("data-enemyCardName", data.name);
                            $("#enemyCard"+ctrEnemy).attr("data-elem", data.element);
                            $("#enemyCard"+ctrEnemy).attr("data-atk", data.attack);
                            $("#enemyCard"+ctrEnemy).attr("data-image", data.image);
                            ctrEnemy++;
                        }
                    });
            });
            enemyDeckCount -= 5;
            $("#enemyDeckCount").text(enemyDeckCount);
            playerTurn();
        });
        // enemyHand = enemyCardOrder.slice(-5);
        // enemyCardOrder.splice(-5);  
    });

    function playerTurn()
    {                  
        
        playerDraw = 1;
        if(pTurn == 1 || pTurn == 2)
        {
            setInterval(function(){
                //Player's Hand Zoom Effect
                for (var i = 1; i <= 5; i++) 
                {
                    if($("#playerCard"+i).attr("src") != "../images/cardHolder.png")
                    {
                        $("#playerCard"+i).mouseover(function(){
                            $(this).css("border", "3px solid gold");
                        });

                        $("#playerCard"+i).mouseout(function(){
                            $(this).css("border", "none");
                        });
                        
                        $("#playerCard"+i).bighover({
                            height: "550",
                            position: "top"
                        });

                    }
                }   

                if($("#pGrave").attr("src") != "../images/exit.jpg")
                {
                    $("#pGrave").bighover({
                        height: "400",
                        position: "right"
                    });
                }

                if($("#eGrave").attr("src") != "../images/exit.jpg")
                {
                    $("#eGrave").bighover({
                        height: "400",
                        position: "left"
                    });   
                }
                //Player's Hand Zoom Effect - End 
            }, 500);
        } 
        var playerHand = [];
        $("#playerDeck").css("border","3px solid gold");
        $(".playerDeckHolder").css("margin-top","-40px");
        $("#playerDraw").text("DRAW");
        
           $("#playerDeck").click(function(){            
                if(playerDraw == 1 && pTurn == 1)
                {                            
                    var ctrPlayer = 1;
                    playerHand = playerCardOrder.slice(-5);
                    playerHand.reverse();
                    playerCardOrder.splice(-5);
                    playerHand.forEach(function(card){
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: "getCards.php",
                            data: {cardId: card},
                            success: function(data){
                                $("#playerCard"+ctrPlayer).attr("src", data.image);
                                $("#playerCard"+ctrPlayer).attr("data-playerCardNum", data.cardId);
                                $("#playerCard"+ctrPlayer).attr("data-playerCardName", data.name);
                                $("#playerCard"+ctrPlayer).attr("data-elem", data.element);
                                $("#playerCard"+ctrPlayer).attr("data-atk", data.attack);
                                ctrPlayer++;
                            }
                        });
                    });
                    playerDeckCount -= 5;
                }
                if(playerDraw == 1 && pTurn == 2)
                {
                    playerHand.push(playerCardOrder.slice(-1));
                    playerCardOrder.splice(-1);
                    var card = parseInt(playerHand[4]);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "getCards.php",
                        data: {cardId: card},
                        success: function(data){
                            $("#"+pEmptyCardId).attr("src", data.image);
                            $("#"+pEmptyCardId).attr("data-playerCardNum", data.cardId);
                            $("#"+pEmptyCardId).attr("data-playerCardName", data.name);
                            $("#"+pEmptyCardId).attr("data-elem", data.element);
                            $("#"+pEmptyCardId).attr("data-atk", data.attack);
                        }
                    });
                    playerDeckCount -= 1;
                }
                playerDraw = 0;     
                $("#playerDeckCount").text(playerDeckCount);
                $("#playerDeck").css("border","none");
                $(".playerDeckHolder").css("margin-top","9px");
                $("#playerDraw").text("");
           }); 
           $("#playerDeck").click();

        $(".player").click(function(){
            if(pPick == 1 && playerDraw == 0)
            {              
                $("#playerRep").attr("data-playerCardNum", $(this).attr("data-playerCardNum"));
                $(this).attr("data-playerCardNum", "");

                $("#playerRep").attr("data-playerCardName", $(this).attr("data-playerCardName"));
                $(this).attr("data-playerCardName", "");

                $("#playerRep").attr("data-atk", $(this).attr("data-atk"));
                $(this).attr("data-atk", "");

                $("#playerRep").attr("data-elem", $(this).attr("data-elem"));
                $(this).attr("data-elem", "");

                $("#playerRep").attr("src", "../images/cardCover.png");
                $("#playerRep").attr("data-lastPosition", $(this).attr("id"));
                $("#playerRep").attr("data-cardIndex", $(this).attr("data-cardIndex"));
                $("#playerRep").attr("data-image", $(this).attr("src"));
                $(this).attr("src", "../images/cardHolder.png");

                $("#playerEndTurn").fadeIn();                
                pPick = 0;
                pAtrReturned = 0;                
            }
        }); 

        $("#playerRep").click(function(){
            if(pTurn == 1 && playerDraw == 0 || pTurn == 2 && playerDraw == 0)
            {  

                pTurn = 1;   
                pPick = 1;         
                var backToHand = $(this).attr("data-lastPosition");
                
                $(this).attr("src", "../images/cardHolder.png");

                if(pAtrReturned == 0)
                {
                    //Places the card and its attributes set by the player in the battlefield back to his/her hand
                    $("#"+backToHand).attr("src", $(this).attr("data-image"));        

                    $("#"+backToHand).attr("data-playerCardNum", $(this).attr("data-playerCardNum"));
                    $(this).attr("data-playerCardNum", "");

                    $("#"+backToHand).attr("data-playerCardName", $(this).attr("data-playerCardName"));
                    $(this).attr("data-playerCardName", "");

                    $("#"+backToHand).attr("data-atk", $(this).attr("data-atk"));
                    $(this).attr("data-atk", "");

                    $("#"+backToHand).attr("data-elem", $(this).attr("data-elem"));
                    $(this).attr("data-elem", "");

                    pAtrReturned = 1;
                }
                $("#playerEndTurn").fadeOut();
            }
        });  

        $("#playerEndTurn").click(function(){
            $("#playerRepBack").attr("src", $("#playerRep").attr("data-image"));            
            $("#playerEndTurn").fadeOut();
            var deleteCardFromHand = parseInt($("#playerRep").attr("data-cardIndex"));
            playerHand.splice(deleteCardFromHand, 1);
            pTurn = 0;
            $("#statusPlayerPick").fadeOut();
            $("#statusEnemyPick").fadeIn();
            enemyTurn();
        });     
    }

    function enemyTurn()
    {
        if(enemyDraw == 1)
        {
            enemyHand.push(enemyCardOrder.slice(-1));
            enemyCardOrder.splice(-1);
            var enemyCard = parseInt(enemyHand[4]);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "getCards.php",
                data: {cardId: enemyCard},
                success: function(data){
                    $("#"+eEmptyCardId).attr("src", "../images/cardCover.png");
                    $("#"+eEmptyCardId).attr("data-enemyCardNum", data.cardId);
                    $("#"+eEmptyCardId).attr("data-enemyCardName", data.name);
                    $("#"+eEmptyCardId).attr("data-elem", data.element);
                    $("#"+eEmptyCardId).attr("data-atk", data.attack);
                    $("#"+eEmptyCardId).attr("data-image", data.image);
                }
            });
            enemyDeckCount -= 1;
            $("#enemyDeckCount").text(enemyDeckCount);
            enemyDraw = 0;
        }

        if(enemyDraw == 0 && eTurn == 1)
        {
            enemyChoice = enemyHand[Math.floor(Math.random() * enemyHand.length)];
            indexEnemy = enemyHand.indexOf(enemyChoice);
            // alert(enemyHand.join("\n"));
            // alert("Enemy choice: "+enemyChoice);
            setTimeout(function(){
               $("#enemyRep").attr("src", "../images/cardCover.png");
               $("#enemyCard"+(indexEnemy+1)).attr("src", "../images/cardHolder.png");

               var eCnum = $("#enemyCard"+(indexEnemy+1)).attr("data-enemyCardNum");
               var eCname = $("#enemyCard"+(indexEnemy+1)).attr("data-enemyCardName");
               var eAtk = $("#enemyCard"+(indexEnemy+1)).attr("data-atk");
               var eElem = $("#enemyCard"+(indexEnemy+1)).attr("data-elem");
               var eImage = $("#enemyCard"+(indexEnemy+1)).attr("data-image");

               $("#enemyRep").attr("data-lastPosition", "enemyCard"+(indexEnemy+1));
               $("#enemyRep").attr("data-enemyCardNum", eCnum);
               $("#enemyRep").attr("data-enemyCardName", eCname);
               $("#enemyRep").attr("data-atk", eAtk);
               $("#enemyRep").attr("data-elem", eElem);
               $("#enemyRep").attr("data-image", eImage);

               eEmptyCardId = $("#enemyRep").attr("data-lastPosition");
               enemyHand.splice(indexEnemy, 1);
               

               $("#enemyEndTurn").fadeIn();
               setTimeout(function(){
                    $("#enemyRepBack").attr("src", $("#enemyRep").attr("data-image"));
                    $("#enemyEndTurn").fadeOut();
                    battlePhase();
                }, 3000);
           }, 5000);  
           eTurn = 0;  
        }
        
    }

    function battlePhase()
    {
        $(".modalTable").hide();
        $(".atkBonus").hide();
        $("#battleInfoBox").hide();
        $(".battleInfo").hide();

        $("#statusEnemyPick").fadeOut();
        $("#statusBattle").fadeIn();
        $("#playerMonster").flip(true);
        $("#enemyMonster").flip(true);
        $("#playerRepBack").bighover({
            height: "700",
            position: "top"
        });
        $("#enemyRepBack").bighover({
            height: "700",
            position: "bottom"
        }); 

        var playerCard = $('#playerRep').attr('data-playerCardName');
        var enemyCard = $('#enemyRep').attr('data-enemyCardName');

        var enemyAtk = parseInt($("#enemyRep").attr("data-atk"));
        var enemyElem = $("#enemyRep").attr("data-elem");

        var playerAtk = parseInt($("#playerRep").attr("data-atk"));        
        var playerElem = $("#playerRep").attr("data-elem");

        var resistance = "";
        var outcome = "";        
        var damageGiven = "";
        var damaged = 0;
        var strongElem = 0;

        if((playerElem == "Fire" && enemyElem == "Earth") || 
            (playerElem == "Earth" && enemyElem == "Thunder") || 
            (playerElem == "Thunder" && enemyElem == "Water") || 
            (playerElem == "Water" && enemyElem == "Fire") )
        {
            playerAtk += 1000;
            strongElem = 1;
            resistance = "Player ("+playerCard+") has been given 1000 ATK. | "+playerElem+" > "+enemyElem;            
        }

        if((enemyElem == "Fire" && playerElem == "Earth") || 
            (enemyElem == "Earth" && playerElem == "Thunder") || 
            (enemyElem == "Thunder" && playerElem == "Water") || 
            (enemyElem == "Water" && playerElem == "Fire") )
        {
            enemyAtk += 1000;
            strongElem = 2;
            resistance = "CPU ("+enemyCard+") has been given 1000 ATK. | "+enemyElem+" > "+playerElem;            
        }    

        
        if(playerAtk == enemyAtk)
        {
            outcome = "Player ("+playerCard+") and CPU ("+enemyCard+") has equal ATK.";
            damageGiven = "No damage given to both sides.";
        }
        else
        {
            if(playerAtk > enemyAtk) 
            {
                outcome = "Player ("+playerCard+")("+playerAtk+" ATK) defeats CPU ("+enemyCard+")("+enemyAtk+" ATK)";
                damageGiven = "CPU receives "+(playerAtk-enemyAtk)+" damage";                              
                damaged = 2;
            }
            else
            {
                outcome = "CPU ("+enemyCard+")("+enemyAtk+" ATK) defeats Player ("+playerCard+")("+playerAtk+" ATK)";
                damageGiven = "Player receives "+(enemyAtk-playerAtk)+" damage";                                
                damaged = 1;    
            }
        }

        if(resistance != "")
        {
            $("#resistanceInModal").text(resistance);
        }
        $("#outcomeInModal").text(outcome);
        $("#damageGivenInModal").text(damageGiven);

        //SET IMG SRC TO CARDS INSIDE MODAL
        $("#playerCardInModal").attr("src", $("#playerRepBack").attr("src"));
        $("#enemyCardInModal").attr("src", $("#enemyRepBack").attr("src"));
        //END - SET IMG SRC TO CARDS INSIDE MODAL
        var delay = 0;
        setTimeout(function(){
            $("#trigger").click();
        }, 3000);
        
        setTimeout(function(){
            $(".modalTable").fadeIn( "slow", function(){});
        }, 5000);
        setTimeout(function(){
            $("#battleInfoBox").fadeIn( "slow", function(){});
            $("#battleInfoHeader").fadeIn( "slow", function(){});
            $("#battleInfoLine").fadeIn( "slow", function(){});
        }, 7000);
        if(resistance != "")
        {
            setTimeout(function(){
                $("#resistanceInModal").fadeIn();
                if(strongElem == 1)
                {
                    $("#playerAtkBonus").fadeIn();
                }
                else if(strongElem == 2)
                {
                    $("#enemyAtkBonus").fadeIn();
                }
            }, 9000);
            setTimeout(function(){
                $("#outcomeInModal").fadeIn();
            }, 11000);
            setTimeout(function(){
                $("#damageGivenInModal").fadeIn();
            }, 13000);
            setTimeout(function(){
                $("#modalClose").click();
            }, 18000);
            delay = 1;
        }
        else
        {
            setTimeout(function(){
                $("#outcomeInModal").fadeIn();
            }, 9000);
            setTimeout(function(){
                $("#damageGivenInModal").fadeIn();
            }, 11000);
            setTimeout(function(){
                $("#modalClose").click();
            }, 16000);
            delay = 2;
        }

        if(delay == 1)
        {
            var duration = 18000;
        }
        else
        {
            var duration = 16000;
        }

        //TAKE HP TO LOSING SIDE        
        if(damaged == 1)
        {
            if((enemyAtk-playerAtk) != 0)
            {                
                setTimeout(function(){
                    $("#playerRepBack").effect( "shake", {times:4}, 200 );
                    $("#dmgToPlayer").text("(-"+(enemyAtk-playerAtk)+")");
                    $("#dmgToPlayer").fadeIn();
                }, duration+2000);
            }
            if((playerHp - (enemyAtk-playerAtk)) <= 0)
            {
                playerHp = 0;
            }
            else
            {
                playerHp -= (enemyAtk-playerAtk); 
            }
            setTimeout(function(){
                $("#playerHp").text(playerHp); 
            }, duration+4000);                 
        }
        else
        {
            if((playerAtk-enemyAtk) != 0)
            {                
                setTimeout(function(){
                    $("#enemyRepBack").effect( "shake", {times:4}, 200 );
                    $("#dmgToEnemy").text("(-"+(playerAtk-enemyAtk)+")");
                    $("#dmgToEnemy").fadeIn();
                }, duration+2000);
            }
            if((enemyHp - (playerAtk-enemyAtk)) <= 0)
            {
                enemyHp = 0;
            }
            else
            {
            enemyHp -= (playerAtk-enemyAtk); 
            } 
            setTimeout(function(){
                $("#enemyHp").text(enemyHp);
            }, duration+4000);
        }
        setTimeout(function(){
            $(".damage").fadeOut();
        }, duration+4000);  
                    
        if((playerHp == 0 || enemyHp == 0) || (playerDeckCount == 0 && enemyDeckCount == 0))
        {                        
            setTimeout(function(){
                $("#statusBattle").fadeOut();
                setTimeout(function(){
                    $("#gameOver").fadeIn();
                }, 500);
            }, duration+6000);
        }
        else
        {
            setTimeout(function(){
                $("#statusBattle").fadeOut();
                setTimeout(function(){
                    $("#endRound").fadeIn();
                }, 500);
            }, duration+6000);
        }

        setTimeout(function(){
            $("#playerRep").attr("src", "../images/cardCover.png");
            $("#enemyRep").attr("src", "../images/cardCover.png");

            $("#playerMonster").flip(false);
            $("#enemyMonster").flip(false);
            $("#playerRepBack").attr("src", "../images/cardHolder.png");
            $("#enemyRepBack").attr("src", "../images/cardHolder.png");

            
            setTimeout(function(){
                //SEND BOTH MONSTERS TO GRAVEYARD
                $("#eGrave").attr("src", $("#enemyRep").attr("data-image"));
                $("#pGrave").attr("src", $("#playerRep").attr("data-image"));

                $("#playerRep").attr("src", "../images/cardHolder.png");
                $("#enemyRep").attr("src", "../images/cardHolder.png");

                $("#playerRep").removeAttr("data-playerCardNum");
                $("#playerRep").removeAttr("data-playerCardName");
                $("#playerRep").removeAttr("data-image");
                $("#playerRep").removeAttr("data-atk");
                $("#playerRep").removeAttr("data-elem");


                $("#enemyRep").removeAttr("data-playerCardNum");
                $("#enemyRep").removeAttr("data-playerCardName");
                $("#enemyRep").removeAttr("data-image");
                $("#enemyRep").removeAttr("data-atk");
                $("#enemyRep").removeAttr("data-elem");
            }, 1000);
            
        }, duration+8000);        
        
        var gameResult = 0;
        var newRecord = 0;
        var wins = 0;
        var losses = 0;
        if((playerHp == 0 || enemyHp == 0) || (playerDeckCount == 0 && enemyDeckCount == 0))
        { 
            var playerId = $("#playerId").val();
            var playerHighestHp = $("#playerHighestHp").val();
            if(playerHp == enemyHp)
            {
                $("#winner").text("TIED!");
            }
            else if((playerHp == 0) || (playerDeckCount == 0 && enemyDeckCount == 0 && enemyHp > playerHp))
            {
                $("#winner").text("YOU LOSE!");
                $.ajax({
                    type: "POST",
                    url: "playerLoss.php",
                    data: {
                        playerId : playerId
                    },
                    success: function(data)
                    {
                        if(data == "Success!")
                        {
                            losses = parseInt($("#losses").text());
                            losses += 1;
                            gameResult = 2;
                        }
                    }
                });
            }
            else if((enemyHp == 0) || (playerDeckCount == 0 && enemyDeckCount == 0 && playerHp > enemyHp))
            {
                $("#winner").text("YOU WIN!");
                if(playerHp > playerHighestHp)
                {
                    $.ajax({
                        type: "POST",
                        url: "playerWinNewRecord.php",
                        data: {
                            playerId : playerId,
                            playerHp : playerHp
                        },
                        success: function(data)
                        {                                
                            if(data == "Success!")
                            {
                                wins = parseInt($("#wins").text());
                                wins += 1;
                                gameResult = 1;
                                newRecord = 1;
                            }
                        }
                    });
                }
                else
                {
                    $.ajax({
                        type: "POST",
                        url: "playerWin.php",
                        data: {
                            playerId : playerId,
                        },
                        success: function(data)
                        {                                
                            if(data == "Success!")
                            {
                                wins = parseInt($("#wins").text());
                                wins += 1;
                                gameResult = 1;
                            }
                        }
                    });
                }   
            }
            

            setTimeout(function(){
                $("#gameOver").fadeOut();
                setTimeout(function(){
                    $("#winner").fadeIn();
                    if(gameResult == 1)
                    {
                        $("#wins").text(wins);
                        if(newRecord == 1)
                        {
                            $("#highestHp").text(playerHp);
                        }
                    }
                    else
                    {
                        $("#losses").text(losses);
                    }
                }, 500);
            }, duration+10000);

            setTimeout(function(){
                $("#winner").fadeOut();
                setTimeout(function(){
                    $("#playAgain").fadeIn();
                }, 500);
            }, duration+15000);
        }
        else
        {
            pEmptyCardId = $("#playerRep").attr("data-lastPosition");
            $("#playerRep").removeAttr("data-lastPosition");
            pTurn = 2;
            eTurn = 1;
            enemyDraw = 1;
            pPick = 1;
            setTimeout(function(){
                $("#endRound").fadeOut();
                setTimeout(function(){
                    $("#statusPlayerPick").fadeIn();
                }, 500);
                playerTurn();
            }, duration+10000);
        }
        //PLAYER'S TURN
    }
</script>