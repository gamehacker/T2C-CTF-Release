<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/define.php");

if (isset($_COOKIE[session_name()])){
	session_start();
}

$mysqli = new mysqli(MySQL_Server, MySQL_User, MySQL_Password, MySQL_Table);

if(isset($_POST["id"])){
	$id = htmlspecialchars($_POST["id"],ENT_QUOTES);
	$pass = htmlspecialchars($_POST["pass"],ENT_QUOTES);
	
	if ($mysqli->connect_errno) {
		printf("Connect failed: %s\n", $mysqli->connect_error);
		exit();
	}
	$password = hash("sha256",$pass);
	$passw = "hackhack".$pass."anonymous";
	$passd = hash("sha256",$passw);
	if ($result = $mysqli->query("SELECT * FROM user where id='{$id}' and pass='{$passd}';")) {
		if($result->num_rows!=0&&$row = $result->fetch_assoc()){
			session_start();
			$_SESSION['name']=htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
			$_SESSION['id']=$row['id'];
			$_SESSION['team']=htmlspecialchars($row['team'], ENT_QUOTES, 'UTF-8');
			$points=$row['points'];
			
		}else{}
	}
}




if(isset($_SESSION['name'])){
	if($_SERVER['SCRIPT_NAME']==="/register.php"){
		header("Location:/");
	}
	session_regenerate_id(true);
	if ($result = $mysqli->query("SELECT * FROM user where id='{$_SESSION['id']}' ;")) {
		if($result->num_rows!=0&&$row = $result->fetch_assoc()){
		$points=$row['points'];
		}
	}
	//time
	if ($time_result = $mysqli->query("SELECT * FROM game_time ;")) {
		if($time_result->num_rows!=0&&$row = $time_result->fetch_assoc()){
		$start_time=strtotime($row['start']);$end_time=strtotime($row['end']);
		$hidden_time=$end_time-HIDDEN_TIME;
		$date = new DateTime();
		$date->setTimestamp($hidden_time);
		//echo $date->format('U = Y-m-d H:i:s');

		}
	}
	$decode_name=htmlspecialchars_decode($_SESSION['name'],ENT_QUOTES);
	$decode_team=htmlspecialchars_decode($_SESSION['team'],ENT_QUOTES);

}else{
	if (isset($_COOKIE[session_name()])){
		setcookie(session_name(), '', time()-42000, '/');
		$_SESSION = array();
		session_destroy();
	}
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>T2C CTF</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
	<link href="/css/style.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  
  
  <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="container">
	  <div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		  <span class="sr-only">Toggle navigation</span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" <?php $top_url=""; if($_SERVER['SCRIPT_NAME']==="/admin/index.php"){$top_url="admin/";} echo "href=\"/{$top_url}\"";?> >T2C CTF</a>
	  </div>

	  <!-- Collect the nav links, forms, and other content for toggling -->
	  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <li <?php if($_SERVER['SCRIPT_NAME']==="/score.php"){echo "class=\"active\"";} ?>><a href="/score.php">Score Bord</a></li>

            </ul>

		<ul class="nav navbar-nav navbar-right">
		<?php

		if($_SERVER['SCRIPT_NAME']!=="/register.php"&&!isset($_SESSION['name'])){
		?>
			<form class="navbar-form navbar-left" role="search" method="post">
				<div class="form-group">
					<input type="text" class="form-control small" name="id" placeholder="id" size="10">
				</div>
				<div class="form-group">
					<input type="password" class="form-control small" name="pass" placeholder="password" title="password" size=10>
				</div>		
				<button type="submit" class="btn btn-success">Sign in</button>
			</form>
		<?php
			//if(!isset($_SESSION["USERID"])){}
		}else{
			
		}
		if(isset($_SESSION['name'])){
		?>
		  <li class="active"><a href="#"><?php echo $_SESSION['team']." ".$points;?> pt</a></li>
		  <li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['name'];?><b class="caret"></b></a>
			<ul class="dropdown-menu">
			  <li><a href="#"><?php echo "id ".$_SESSION['id'];?></a></li>
			  <li class="divider"></li>
			  <li><a href="/logout.php">logout</a></li>
			</ul>
		  </li>
			<script>
				<?php echo " my_id=\"".$_SESSION['id']."\";"; echo "my_name=\"".$_SESSION['name']."\";";?>
			</script>
		  <?php
		  
		  
		 }
		  ?>
		</ul>
	  </div><!-- /.navbar-collapse -->
  </div>
</nav>

<div class="container">