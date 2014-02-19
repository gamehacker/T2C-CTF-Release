<?php require_once($_SERVER["DOCUMENT_ROOT"]."/header.php");

if(isset($_SESSION['name'])){
	if($_SESSION['id']===ADMIN_ID){
?>
		<div class="row" id=my_layout>
			<div class="span11">
				<div class=col-md-8> 
					<div class="panel-heading">Never Give Up!!</div>
					  <table class="table table-condensed" id="score_table">
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
			}if ($result = $mysqli->query("SELECT * FROM ans_log where team!=\"\" order by time desc;")) {
				$score_log="";
				while($result->num_rows!=0&&$row = $result->fetch_assoc()){
					$team_name=htmlspecialchars($row['team'], ENT_QUOTES, 'UTF-8');
					$score_log.="チーム「{$team_name}」が{$row['q_point']} pt 獲得しました！{$row['time']}<hr>";
						
					}
			}

		?>

					  </table>
					  
					  <div id="score_log"><?php echo $score_log;?></div>
					
				</div>
			
				<div class=col-md-3>
				<script src="http://<?php echo $_SERVER["HTTP_HOST"]; ?>:3000/socket.io/socket.io.js"></script>
				<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
				<script src="/client.js"></script>
					<script>
					$(function() {
					  var socket = io.connect("http://"+location.hostname+":3000");
		

					  socket.on('score_update', function(data) {
						var score_tr = $("#score_table tr");
						for(var i=0;i<data.length;i++){
							var cells = score_tr.eq(i+1).children();
								data[i].name=$('<div/>').text(data[i].name).html()
									cells.eq(1).html(data[i].name);
									cells.eq(2).html(data[i].points+" pt");
								}
					  });
					  socket.on('hit', function(data) {
							var name;var i=1;
							//data = $('<div/>').text(data).html();
							data[0].team=$('<div/>').text(data[0].team).html()
							$('#score_log').prepend("チーム「"+data[0].team +"」が"+data[0].q_point+" pt 獲得しました！"+data[0].time+'<br><hr>');
							if(data[0].q_point%100===0){
								var audio = new Audio("http://"+location.hostname+":80/mp3/atari.mp3");
								audio.volume=1;
								//for(var i=0;i<data[0].q_point/100;i++){
									setTimeout(function () { audio.play(); }, i*1000);
									audio.addEventListener("ended", function(){
											if(i<data[0].q_point/100){audio.play();i++;}
										}, false);
								//}
							}else{

								var audio = new Audio("http://"+location.hostname+":80/mp3/first.mp3");
								audio.volume=1;
								audio.play();	
									//setTimeout(function () { audio.load();audio.play(); }, i*1700);
									audio.addEventListener("ended", function(){
										if(i<data[0].q_point%100){audio.play();i++;}
									}, false);

							}
							//var query = connection.query('SELECT * FROM team order by points desc ;', function (err, results) {
							
							
								

							//});
					  });
					});
					</script>
					<form id="chat"><input id="message"></form><div id="chat_log"></div>
				</div>
			</div>
		</div>



<?php
	}else{?>
	<div class=\"alert alert-success\">Permission Denied.</div>
<?php	}

}else{
 ?>
<div class="jumbotron">
  <h1>Hello, CTF world!</h1>
  <p>Tokai univ</p>
  <p>Takanawa</p>
  <p>Campus CTF</p>
  <p><a href="register.php" class="btn btn-primary btn-lg" role="button">Register</a></p>
</div>



<?php } 


require_once($_SERVER["DOCUMENT_ROOT"]."/footer.php");?>
