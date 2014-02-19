<?php
require_once("./header.php");
	if (isset($_POST["reg_id"])&&isset($_POST["reg_name"])&&isset($_POST["reg_pass"])&&isset($_POST["reg_cpass"])) {
		$id = htmlspecialchars($_POST["reg_id"],ENT_QUOTES);	
		$pass = htmlspecialchars($_POST["reg_pass"],ENT_QUOTES);
		$cpass = htmlspecialchars($_POST["reg_cpass"],ENT_QUOTES);
		
		$name = htmlspecialchars_decode($_POST["reg_name"],ENT_QUOTES);

	
	
		//----------------------
		//空ならエラー
		//----------------------
		if ($id==""){ $error .= '<p class="error">IDが入力されていません</p>'; }
		if ($name==""){ $error .= '<p class="error">ニックネームが入力されていません</p>'; }
		if ($pass==""){ $error .= '<p class="error">パスワードが入力されていません</p>'; }
		
		if ($pass!=$cpass){ $error .= '<p class="error">同じパスワードを入力してください</p>'; }
		
		
		//----------------------
		//文字数確認
		//----------------------
		$sid = strlen($id);
		$spass = strlen($pass);
		if ($sid < 8 ){ $error .= '<p class="error">IDは8文字以上で設定してください</p>'; }
		if ($spass < 8 ){ $error .= '<p class="error">パスワードは8文字以上で設定してください</p>'; }
		//----------------------
		//プレグマッチ
		//----------------------
		if (preg_match("/^[a-zA-Z0-9]+$/", $pass)){ $pass = $pass; }else{
		 $error .= '<p class="error">パスワードは半角英数で登録してください。</p>'; }

		//---------------------
		//重複チェック
		//---------------------
		$mysqli = new mysqli(MySQL_Server, MySQL_User, MySQL_Password, MySQL_Table);
		$name = mysqli_real_escape_string($mysqli, $name);
		/* 接続状況をチェックします */
		if ($mysqli->connect_errno) {
			printf("Connect failed: %s\n", $mysqli->connect_error);
			exit();
		}
		
		if ($result = $mysqli->query("SELECT id name FROM user where name='{$name}';")) {
			if($result->num_rows!==0&&!empty($name)){
				$error .= '<p class="error">ニックネームが既に登録済みです</p>';
			}

		/* 結果セットを開放します */
		$result->close();
		}else{printf("Errormessage: %s\n", $mysqli->error);}
		
			/*
		$stmt = $pdo -> query("SELECT * FROM T2CCTF");
		while($item = $stmt->fetch()) {
		if($item['id'] == $id){
		  $error = '<p class="error">ご希望のメールアドレスは既に使用されています。</p>';
		 }else{
		 $id = $id;
		 }
		}

		//-------------------
		//DBに登録
		//-------------------
		if ($error == "" ) {
		$stmt = $pdo -> prepare("INSERT INTO テーブル名 (dd,id,pass) VALUES ('', :id, :pass)");
		$stmt -> bindParam(':id', $id, PDO::PARAM_STR);
		$stmt -> bindParam(':pass', $passd, PDO::PARAM_STR);
		$stmt -> execute();
		header('Location: login.php');
		 }*/
		if ($error == "" ) {
				//----------------------
				//SHA-2
				//----------------------
				$password = hash("sha256",$pass);
				$passw = "hackhack".$pass."anonymous";
				$passd = hash("sha256",$passw);
			if ($mysqli->query("update user set name = '{$name}', pass ='{$passd}' where id='{$id}';")){
				$success="登録が完了しました。<a href=/ class=\"alert-link\">トップ画面</a>からログインしてください。";
				//header("Location:/");
				//session_regenerate_id(TRUE);
				//session_start();
				//header("Location:/");
			}else{printf("Errormessage: %s\n", $mysqli->error);}
		}
	}


	if (!empty($_POST["reg_id"])&&!empty($_POST["reg_email"])&&empty($success)) {
		$id = htmlspecialchars($_POST["reg_id"],ENT_QUOTES);
		$email = htmlspecialchars($_POST["reg_email"],ENT_QUOTES);
		$id_check=0;
		
		if ($mysqli->connect_errno) {
			printf("Connect failed: %s\n", $mysqli->connect_error);
			exit();
		}
		
		$mysqli = new mysqli(MySQL_Server, MySQL_User, MySQL_Password, MySQL_Table);
		if ($result = $mysqli->query("SELECT * FROM user where id='{$id}' and pass='{$email}';")) {
			if($result->num_rows===0){
				$error .= '<p class="error">idまたはemailアドレスが違います。</p>';
			}else{
			$id_check=1;
				 ?>

				<div class="panel panel-default" id="login_panel">
				
				  <!-- Default panel contents -->
				 <?php

					$row=$result->fetch_assoc();
				 
				 if($error){echo "<div class=\"alert alert-danger\">{$error}</div>";}?>
				  <div class="panel-heading">
				  <h3 class="panel-title">事前登録情報</h3>
				  登録されている情報は次の通りです。
					
				  </div>
				 
				<table class="table table-hover">
					<tr><th>ログインID</th><td><?php echo $row['id'];?></td></tr>
					<tr><th>チーム名</th><td><?php $team_name=htmlspecialchars($row['team'], ENT_QUOTES, 'UTF-8'); echo $team_name;?></td></tr>
				</table>

				<div class="panel panel-primary">
				  <div class="panel-heading">
					<h3 class="panel-title">追加情報</h3>
				  </div>
				<form role="form" method=post>
				  <div class="form-group">
					<label for="exampleInputEmail1">ニックネーム(公開される名前)</label>
					<input type="text" name=reg_name class="form-control" id="id" value="<?php if(!empty($name)){echo $name;}?>"  placeholder="Enter nickname">
				  </div>
					  <div class="form-group">
					<label for="exampleInputPassword1">Password</label>
					<input type="password" name=reg_pass class="form-control" id="pass" placeholder="Password">
				  </div>
				  
				   <div class="form-group">
					<label for="exampleInputPassword1">Confirm Password</label>
					<input type="password" name=reg_cpass class="form-control" id="pass" placeholder="Password">
				  </div>

				<input type="hidden" name=reg_id value="<?php echo $id?>">
				<input type="hidden" name=reg_email value="<?php echo $email?>">
				  <button type="submit" class="btn btn-primary">Submit</button>

				</form>
				</div>
				</div>

				<?php
			}
		}
			

		
	}
	if(empty($id_check)||!$id_check){
	

?>



<div class="panel panel-default" id="login_panel">
  <!-- Default panel contents -->
 <?php
 if($success){echo "<div class=\"alert alert-success\">{$success}</div>";}
 else{?>
  <div class="panel-heading">Start Up!!
	<p>T2C CTFに事前登録して頂いた方は、フォームに登録した"学生証番号"と"メールアドレス"を入力してください。</p>
  </div>
 
<?php if($error){echo "<div class=\"alert alert-danger\">{$error}</div>";}?>

<form role="form" method=post>
  <div class="form-group">
    <label for="exampleInputEmail1">学生証番号(login id)</label>
    <input type="text" name=reg_id class="form-control" id="id" value="<?php echo $id?>" placeholder="Enter student number">
  </div>
   <div class="form-group">
    <label for="exampleInputEmail1">メールアドレス</label>
    <input type="text" name=reg_email class="form-control" id="name" value="<?php echo $name?>" placeholder="Enter nickname">
  </div>


  <button type="submit" class="btn btn-primary">Submit</button>

</form>
</div>

<?php
	}
 } require_once("./footer.php");?>