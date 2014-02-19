<?php
	if (isset($_POST["reg_id"])) {
		$id = htmlspecialchars($_POST["reg_id"],ENT_QUOTES);
		//$name = htmlspecialchars($_POST["reg_name"],ENT_QUOTES);
		$pass = htmlspecialchars($_POST["reg_pass"],ENT_QUOTES);
		//$cpass = htmlspecialchars($_POST["reg_cpass"],ENT_QUOTES);
		$team = htmlspecialchars_decode($_POST["team"],ENT_QUOTES);

		
		//----------------------
		//空ならエラー
		//----------------------
		if ($id==""){ $error .= '<p class="error">IDが入力されていません</p>'; }
		//if ($name==""){ $error .= '<p class="error">ニックネームが入力されていません</p>'; }
		if ($pass==""){ $error .= '<p class="error">パスワードが入力されていません</p>'; }
		
		//if ($pass!=$cpass){ $error .= '<p class="error">同じパスワードを入力してください</p>'; }
		
		
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
		//if (preg_match("/^[a-zA-Z0-9]+$/", $pass)){ $pass = $pass; }else{
		// $error .= '<p class="error">パスワードは半角英数で登録してください。</p>'; }
		if (preg_match("/^[a-zA-Z0-9]+$/", $id)){ $id = $id; }else{
		 $error .= '<p class="error">IDは半角英数で登録してください。</p>'; }
		//---------------------
		//重複チェック
		//---------------------
		$mysqli = new mysqli(MySQL_Server, MySQL_User, MySQL_Password, MySQL_Table);

		/* 接続状況をチェックします */
		if ($mysqli->connect_errno) {
			printf("Connect failed: %s\n", $mysqli->connect_error);
			exit();
		}
		
		if ($result = $mysqli->query("SELECT id name FROM user where id='{$id}'")) {
			if($result->num_rows!==0){
				$error .= '<p class="error">IDが既に登録済みです</p>';
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
				//$password = hash("sha256",$pass);
				//$passw = "hackhack".$pass."anonymous";
				//$passd = hash("sha256",$passw);
				$team_name = mysqli_real_escape_string($mysqli, $team);
			if ($mysqli->query("insert into user (id,name,pass,points,team) values('{$id}','','{$pass}','0','{$team_name}');")){
				$success="登録が完了しました。<a href=/ class=\"alert-link\">トップ画面</a>からログインしてください。";
				//header("Location:/");
				//session_regenerate_id(TRUE);
				//session_start();
				//header("Location:/");
			}else{printf("Errormessage: %s\n", $mysqli->error);}
		}
	}

?>

<?php require_once($_SERVER["DOCUMENT_ROOT"]."/header.php"); ?>

<div class="panel panel-default" id="login_panel">
  <!-- Default panel contents -->
 <?php
 if($success){echo "<div class=\"alert alert-success\">{$success}</div>";}
 else{?>
  <div class="panel-heading">Pre Register</div>
 
<?php if($error){echo "<div class=\"alert alert-danger\">{$error}</div>";}?>

<form role="form" method=post>
  <div class="form-group">
    <label for="exampleInputEmail1">学生証番号(login id)</label>
    <input type="text" name=reg_id class="form-control" id="id" value="<?php echo $id?>" placeholder="Enter student number">
  </div>

  <div class="form-group">
    <label for="exampleInputPassword1">E-mail</label>
    <input type="text" name=reg_pass class="form-control" id="pass" placeholder="E-mail">
  </div>

  
    <div class="form-group">
    <label for="exampleInputPassword1">チーム名</label><br>
	    <select name="team">
	<?php
	if ($result = $mysqli->query("SELECT * FROM team;")) {
		while($row=$result->fetch_assoc()){
		$team_name=htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
			echo "<option value=\"{$team_name}\">{$team_name}</option>";
		}
	}
	
	?>
		</select>
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>

</form>
</div>

<?php } require_once($_SERVER["DOCUMENT_ROOT"]."/footer.php");?>