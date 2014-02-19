<?php require_once("./header.php");

if(isset($_SESSION['name'])){
	if(time()<$start_time){
		$sys_info= "競技時間前です。";
	}
	elseif(time()>$end_time){
		$sys_info= "競技は終了しました。お疲れさまでした。";
	}
	?>

	<div class="row" id=my_layout>
		<div class=col-md-8> 
<?php 	if(empty($sys_info)||MAINTENANCE_MODE){?>
			<div class="panel-heading">Never Give Up!!</div>
			  <table class="table table-condensed">
			  <thead><tr><th>No.</th><td></td><th>question</th><th>category</th><th>point</th></tr></thead>
<?php 
	$mysqli = new mysqli(MySQL_Server, MySQL_User, MySQL_Password, MySQL_Table);
	if ($mysqli->connect_errno) {
		printf("Connect failed: %s\n", $mysqli->connect_error);
		exit();
	}if ($result = $mysqli->query("SELECT * FROM questions ;")) {
		$result2 = $mysqli->query("SELECT * FROM ans_log ;"); 

		$k=0;
		while($answer_log[$k] = $result2->fetch_assoc()){
			$k++;
		}
		
		while($result->num_rows!=0&&$row = $result->fetch_assoc()){
			$check_mark="";$k=0;
			while($answer_log[$k]){
				//正解者が自分で一番
				if($answer_log[$k]['q_no']==$row['no']&&$answer_log[$k]['id']==$_SESSION['id']&&$answer_log[$k]['q_point']%100!==0){
					$check_mark="<span class=\"glyphicon glyphicon-star\"></span>";
					break;
					
				}
				//正解者が自分
				elseif($answer_log[$k]['q_no']==$row['no']&&$answer_log[$k]['id']==$_SESSION['id']){
					$check_mark="<span class=\"glyphicon glyphicon-ok form-control-feedback\"></span>";
					break;
					
				}//正解者が自チーム
				elseif($answer_log[$k]['q_no']==$row['no']&&$answer_log[$k]['team']==$decode_team){
					$check_mark="<span class=\"glyphicon glyphicon-flag\"></span>";

					break;
	
				}//正解者が他チーム
				elseif($answer_log[$k]['q_no']==$row['no']&&$answer_log[$k]['team']!=$decode_team){
				$check_mark="<span class=\"glyphicon glyphicon-exclamation-sign\"></span>";

				
				}
				$k++;
				
			}
		
		echo "<tr><th>{$row['no']}</th><td>{$check_mark}</td><td><a href=\"/q{$row['no']}/\">{$row['title']}</a></td><td>{$row['category']}</td><td>{$row['point']} pt</td></tr>";
			
		}
	}

?>

			  </table>
			  
			  <p><span class="glyphicon glyphicon-star"></span> あなたが最初に問題を解きました！</p>
			  <p><span class="glyphicon glyphicon-ok form-control-feedback"></span> あなたが問題を解きました！</p>
			  <p><span class="glyphicon glyphicon-flag"></span> チームメイトが問題を解きました！</p>
			  <p><span class="glyphicon glyphicon-exclamation-sign"></span> 他チームが問題を解きました！</p>
<?php		}else{
				echo $sys_info;
			}

?>
		</div>
		<div class=col-md-3>
		<script src="http://<?php echo $_SERVER["HTTP_HOST"]; ?>:3000/socket.io/socket.io.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="/client.js"></script>
			
			<form id="chat"><input id="message"></form><div id="chat_log"></div>
		</div>
	</div>



<?php 
	
}else{
 ?>
<div class="jumbotron">
  <h1>Hello, CTF world!</h1>
  <p>Tokai univ</p>
  <p>Takanawa</p>
  <p>Campus CTF</p>
  <p><a href="startup.php" class="btn btn-primary btn-lg" role="button">Start UP!</a></p>
</div>



<?php } 


require_once("./footer.php");?>
