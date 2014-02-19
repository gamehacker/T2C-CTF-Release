<?php require_once($_SERVER["DOCUMENT_ROOT"]."/header.php");

?>

	<div class="row" id=my_layout>

		<div class=col-md-8> 
<?php	if(time()<$hidden_time||MAINTENANCE_MODE){?>
			<div class="panel-heading">Never Give Up!!</div>
			  <table class="table table-condensed">
			  <thead><tr><th>Rank</th><th>Team</th><th>Points</th></tr></thead>
<?php 
	$mysqli = new mysqli(MySQL_Server, MySQL_User, MySQL_Password, MySQL_Table);
	if ($mysqli->connect_errno) {
		printf("Connect failed: %s\n", $mysqli->connect_error);
		exit();
	}if ($result = $mysqli->query("SELECT * FROM team order by points desc ;")) {
		$j=0;
		while($result->num_rows!=0&&$row = $result->fetch_assoc()){
		++$j;
		$team_name=htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
		echo "<tr><th>{$j}</th><td>{$team_name}</td><td>{$row['points']} pt</td></tr>";
			
		}
	}

?>

			  </table>
			  
<?php	}else{
		echo "最後まで頑張れ！<br>Never Give Up!!";
}?>
		</div>
		
<?php if(isset($_SESSION['name'])){?>
		<div class=col-md-3>
		<script src="http://<?php echo $_SERVER["HTTP_HOST"]; ?>:3000/socket.io/socket.io.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="/client.js"></script>
			<form  id="chat"><input id="message"></form><div id="chat_log"></div>
		</div>
		<?php }?>
	</div>



<?php



require_once($_SERVER["DOCUMENT_ROOT"]."/footer.php");?>
