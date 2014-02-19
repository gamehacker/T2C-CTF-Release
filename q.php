<?php require_once("./header.php");

if(isset($_SESSION['name'])&&isset($_GET['q'])){
if(preg_match("/^[0-9]+$/", $_GET['q'])){ $q_no = $_GET['q']; }else{exit;}
?>
		<script src="http://<?php echo $_SERVER["HTTP_HOST"]; ?>:3000/socket.io/socket.io.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<div class="row">
		<div class=col-md-8> 

<?php 
	$mysqli = new mysqli(MySQL_Server, MySQL_User, MySQL_Password, MySQL_Table);
	$safe_name = mysqli_real_escape_string($mysqli,htmlspecialchars_decode($_SESSION['name'],ENT_QUOTES));
	$safe_team = mysqli_real_escape_string($mysqli,htmlspecialchars_decode($_SESSION['team'],ENT_QUOTES));
	if ($mysqli->connect_errno) {
		printf("Connect failed: %s\n", $mysqli->connect_error);
		exit();
	}if ($result = $mysqli->query("SELECT * FROM questions where no={$q_no} ;")) {
		if($result->num_rows!=0&&$row = $result->fetch_assoc()){
	
		}else{exit;}
	}
?>
	<div class="page-header">
	<?php echo "<h1>{$row['title']}		<small>{$row['point']}pt</small></h1>";?>
	</div>
	<div class="panel panel-primary">
		<?php echo "<div class=\"panel-body\">{$row['sentence']}</div>";
		//正解判定
		if(isset($_POST['flag'])&&!is_null($_POST['flag'])&&!empty($_POST['flag'])&&FLAG_LENGTH>=strlen($_POST['flag'])){
			if($row['flag']===$_POST['flag']){
				$get_points=$row['point'];
				
				//重複処理
				if ($result = $mysqli->query("SELECT * FROM ans_log where id='{$_SESSION['id']}'&&q_no='{$q_no}';")) {
					if($result->num_rows==0){
						$result1 = $mysqli->query("SELECT * FROM ans_log where q_no='{$q_no}';");
						$get_points=$row['point'];
						if($result1->num_rows==0&&$row['category']!=="練習問題"){$get_points=$get_points+($get_points/100);}
						if($mysqli->query("insert into ans_log (id,name,q_no,q_point,team) values('{$_SESSION['id']}','{$safe_name}','{$q_no}','{$get_points}','{$safe_team}');")){
							if($mysqli->query("update user set points =points + {$get_points} where id='{$_SESSION['id']}';")){}
							else{printf("Errormessage: %s\n", $mysqli->error);}
							if ($result = $mysqli->query("SELECT * FROM ans_log where id!='{$_SESSION['id']}'&& team='{$safe_team}'&&q_no='{$q_no}';")) {
								if($result->num_rows==0){
									if($mysqli->query("update team set points =points + {$get_points} where name='{$safe_team}';")){}
									else{printf("Errormessage: %s\n", $mysqli->error);}
								}
							}
						}else{printf("Errormessage: %s\n", $mysqli->error);}
					}
				}else{printf("Errormessage: %s\n", $mysqli->error);}
			
			
				?><div class="alert alert-success">Congratulation!! You get <?php echo $get_points; ?>pt!</div>
				<script>
					$(function() {
					  var socket = io.connect("http://"+location.hostname+":3000");
					  //socket.emit('name', );
					  socket.json.emit('atari', { 'id': "<?php echo $_SESSION['id'];?>" , 'name': "<?php echo $_SESSION['name'] ;?>", 'q_no': "<?php echo $q_no ;?>"});

					});
				</script>				
				<?php	
			}else{
				$ans = htmlspecialchars($_POST["flag"],ENT_QUOTES);
				if($mysqli->query("insert into false_log (id,name,q_no,ans,team) values('{$_SESSION['id']}','{$safe_name}','{$q_no}','{$ans}','{$safe_team}');")){}
				else{printf("Errormessage: %s\n", $mysqli->error);}
			
				?><div class="alert alert-danger">Oops! Incorrect Answer.
				</div><?php			
			}
		}
		
		if(!empty($row['hint1'])){
		echo "<div class=\"alert alert-info\"><b>Hint.</b><br>{$row['hint1']}</div>";
		}
		?>
		
		<form method=post>
		<input type="text" class="form-control small" name="flag" placeholder="Enter flag" size="10">
		<button type="submit" class="btn btn-primary">Submit</button>
		</form>
		
	</div>



		</div>
		<div class=col-md-3>

			<script src="/client.js"></script>
			<form id="chat"><input id="message"></form><div id="chat_log"></div>
		</div>
	</div>



<?php }else{
 ?>
<div class="jumbotron">
  <h1>Hello, world!</h1>
  <p>...</p>
  <p><a href="register.php" class="btn btn-primary btn-lg" role="button">Register</a></p>
</div>


<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">Panel heading</div>

  <!-- Table -->
  <table class="table">
    ...
  </table>
</div>
<?php } 


require_once("./footer.php");?>
