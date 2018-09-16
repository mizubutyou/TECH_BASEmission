<?php

	$dsn = 'mysql:dbname=tt_93_99sv_coco_com;host=localhost';
	$user = 'tt-93.99sv-coco.';
	$password = 'T2jrKm4Z';

	try{
		$pdo = new PDO($dsn,$user,$password);		
	}catch(PDOException $e){
		echo 'Error:'.$e->getMessage();
	}

	$e_number = $_POST['edit_number'];
	$h_number = $_POST['hidden_number'];
	$e_pass = $_POST['edit_pass'];

//**編集選択**//
	if(!empty($e_number)){
		$sql = 'SELECT * FROM abc';
		$record = $pdo -> query($sql);
		foreach($record as $value){
			if($value['id']==$e_number){
				$confirm = $value['pass'];
			}
		}
		if($confirm == $e_pass){
			$sql = 'SELECT * FROM abc';
			$records = $pdo -> query($sql);
			foreach($records as $edit){
				if($edit['id']==$e_number){
					$old_name = $edit['name'];
					$old_comment = $edit['comment'];
					$old_number = $edit['id'];
				}
			}
		}
	}


	$pdo =null;
?>

<!DOCTYPE html>
<html lang = 'ja'>
   <head>
		<meta charset = "UTF-8">
   </head>
   <body>

		<form action="mission4.php" method="post">
			<input type="text" name="name" value="<?php echo $old_name; ?>" placeholder="名前" size="30">	
			<br>
			<input type="text" name="comment" value="<?php echo $old_comment; ?>" placeholder="コメント" size="30">
			<br>
			<input type="text" name="password" placeholder="pass"  size="30">
			<input type="submit">
			<input type="hidden" name="hidden_number" value="<?php echo $old_number; ?>">
		</form>

		<form action="mission4.php" method="post">
			<input type="text" name="delete_number" placeholder="削除対象番号" size="30">
			<br>
			<input type="text" name="delete_pass" placeholder="pass" size="30">
			<input type="submit" value="削除">
		</form>

		<form action="mission4.php" method="post">
			<input type="text" name="edit_number" placeholder="編集対象番号" size="30">
			<br>
			<input type="text" name="edit_pass" placeholder="pass" size="30">
			<input type="submit" value="編集">
		</form>

<?php
//****メイン****//
	$dsn = 'mysql:dbname=tt_93_99sv_coco_com;host=localhost';
	$user = 'tt-93.99sv-coco.';
	$password = 'T2jrKm4Z';

	try{
		$pdo = new PDO($dsn,$user,$password);		
	}catch(PDOException $e){
		echo 'Error:'.$e->getMessage();
	}

	//変数宣言
	$timestamp = time();
	$name = $_POST['name'];
	$comment = $_POST['comment'];
	$date = date("Y/n/j H:i:s",$timestamp);
	$d_number = $_POST['delete_number'];
	$e_number = $_POST['edit_number'];
	$h_number = $_POST['hidden_number'];
	$pass = $_POST['password'];
	$d_pass = $_POST['delete_pass'];
	$e_pass = $_POST['edit_pass'];


	//**テーブルへのデータ(レコード)挿入**//
	if(!empty($name) and !empty($comment) and empty($h_number)){
		$sql = $pdo -> prepare("INSERT INTO abc (id,name,comment,date,pass) VALUES(id,:name,:comment,:date,:pass)");
		$sql -> bindParam(':name',$name,PDO::PARAM_STR);
		$sql -> bindParam(':comment',$comment,PDO::PARAM_STR);
		$sql -> bindParam(':date',$date,PDO::PARAM_STR);
		$sql -> bindParam(':pass',$pass,PDO::PARAM_STR);

		$sql -> execute();
	}

	//**レコードの削除**//
	if(!empty($d_number)){
		$sql = 'SELECT * FROM abc';		//特定のテーブルからレコードを取得する
		$record = $pdo -> query($sql);
		foreach($record as $value){
			if($value['id']==$d_number){
				$confirm = $value['pass'];
			}
		}
		if($confirm == $d_pass){
			$id = $d_number;
			$sql = "delete from abc where id=$id";
			$result = $pdo -> query($sql);
		}
	}

	//**レコードの編集**//
	if(!empty($h_number)){
		$sql = 'SELECT * FROM abc';
		$record = $pdo -> query($sql);
		foreach($record as $value){
			if($value['id']==$h_number){
				$id = $h_number;
				$new_name = $name;
				$new_comment = $comment;
				$new_date = $date;
				$new_pass = $pass;
				$stmt = "update abc set name='$new_name', comment='$new_comment', date='$new_date', pass='$new_pass' where id=$id";
				$result = $pdo ->query($stmt);
			}
		}
	}

	//**レコード表示**//
	echo "<hr>";
	$sql = 'SELECT * FROM abc ORDER BY id ASC ';
	$results = $pdo -> query($sql);
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['date'].",";
		echo $row['pass']."<br>";
	}



	$pdo = null;
?>

	</body>
</html>
	