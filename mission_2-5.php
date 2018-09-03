<!DOCTYPE html>
<html lang = 'ja'>
   <head>
		<meta charset = "UTF-8">
   </head>
   <body>


<?php

//変数宣言
	$filename = 'mission_2-5_(uchiyama).txt';		//ファイル
	$e_number = $_POST['edit_number'];
	$h_number = $_POST['hidden_number'];
	$e_pass = $_POST['edit_pass'];

//****編集番号取得****//
	if(!empty($e_number)){
 		$str = file($filename);
		$str1 = file($filename,FILE_IGNORE_NEW_LINES);

		//配列の中身を全部見る→指定した配列を探す．最後$index[4]がpassと一致するか
		for($i=0; $i<count($str); $i++){
			$index = explode("<>",$str1[$i]);
			if($index[0] == $e_number){
				$confirm=$index[4];
			}
		}
/*		echo $e_pass."パス<br>";
		echo $confirm."コンファーム"; */
			if($confirm == $e_pass){
				for($i=0; $i<count($str); $i++){
					$edit = explode("<>",$str[$i]);			//区切り<>ごとに新しい配列editに1つずつ格納.str[$i]ごとに
					if($edit[0] == $e_number){					//配列の先頭番号が編集番号と一緒かで分岐
						$old_name = $edit[1];
						$old_comment = $edit[2];
						$old_number = $edit[0];
					}

				}
			}
	}

?>


		<form action="mission_2-5.php" method="post">
			<input type="text" name="name" value="<?php echo $old_name; ?>" placeholder="名前" size="30">	
			<br>
			<input type="text" name="comment" value="<?php echo $old_comment; ?>" placeholder="コメント" size="30">
			<br>
			<input type="text" name="password" placeholder="pass"  size="30">
			<input type="submit">
			<input type="hidden" name="hidden_number" value="<?php echo $old_number; ?>">
		</form>

		<form action="mission_2-5.php" method="post">
			<input type="text" name="number" placeholder="削除対象番号" size="30">
			<br>
			<input type="text" name="delete_pass" placeholder="pass" size="30">
			<input type="submit" value="削除">
		</form>

		<form action="mission_2-5.php" method="post">
			<input type="text" name="edit_number" placeholder="編集対象番号" size="30">
			<br>
			<input type="text" name="edit_pass" placeholder="pass" size="30">
			<input type="submit" value="編集">
		</form>

<?php
//変数宣言
	$timestamp = time();		//現在時刻取得
	$filename = 'mission_2-5_(uchiyama).txt';		//ファイル
	$name = $_POST['name'];
	$comment = $_POST['comment'];
	$date = date("Y/n/j H:i:s",$timestamp);
	$e_number = $_POST['edit_number'];
	$d_number = $_POST['number'];
	$h_number = $_POST['hidden_number'];
	$pass = $_POST['password'];
	$d_pass = $_POST['delete_pass'];
	$e_pass = $_POST['edit_pass'];

//****実際に編集****//
	if(!empty($h_number)){
 		$str = file($filename);
		$str1 = file($filename,FILE_IGNORE_NEW_LINES);

			$fp3 = fopen($filename,'w');
			for($i=0; $i<count($str); $i++){
				$edit = explode("<>",$str[$i]);			//区切り<>ごとに新しい配列editに1つずつ格納.str[$i]ごとに
				if($edit[0] == $h_number){
					$edit[1] = $name;
					$edit[2] = $comment;
					$edit[3] = $date;
					$edit[4] = $pass."\n";
				}
				for($j=1; $j<count($edit); $j++){
					fwrite($fp3,$edit[$j-1]."<>");
				}
				fwrite($fp3,$edit[count($edit)-1]);
			}
			fclose($fp3);

			//**ファイルの中身表示**//
			$new_filename = 'mission_2-5_(uchiyama).txt';
			$new_str = file($new_filename);
			echo "テキストの中身<br>";
				foreach($new_str as $value1){
					$print_str = explode("<>",$value1);
					foreach($print_str as $value2){
						echo $value2." ";
					}
					echo '<br>';
				}
		
	}


//****送信文字処理****//
	if(!empty($comment) and !empty($name) and empty($h_number)){

		//ファイルに追記
		$str = file($filename);
		$count = count($str);
		$fp1 = fopen($filename,'a');

		if($count != 0){								//配列があるとき
			//explodeで先頭の大きな文字をみつける
			for($i=0; $i<$count; $i++){
				$b = explode("<>",$str[$i]);
				
				//配列の最後の次が何番か
				if($i == $count-1){
					$last_number = $b[0]+1;
				}
			}
			
			$txt = $last_number."<>".$name."<>".$comment."<>".$date."<>".$pass."\n";
			fwrite($fp1,$txt);
		}else{
			$txt = "1"."<>".$_POST['name']."<>".$_POST['comment']."<>".date("Y/n/j H:i:s",$timestamp)."<>".$pass."\n";
			fwrite($fp1,$txt);
		}
		fclose($fp1);
	//**ファイルの中身表示**//
		$new_filename = 'mission_2-5_(uchiyama).txt';
		$new_str = file($new_filename);
		echo "テキストの中身<br>";
			foreach($new_str as $value1){
				$print_str = explode("<>",$value1);
				foreach($print_str as $value2){
					echo $value2." ";
				}
				echo '<br>';
			}
	}
//****------------****//

//****指定行の削除****//
	if(!empty($d_number)){
 		$str = @file($filename);
		$str1 = @file($filename,FILE_IGNORE_NEW_LINES);
		
		//配列の中身を全部見る→指定した配列を探す．最後$index[4]がpassと一致するか
		for($i=0; $i<count($str); $i++){
			$index = explode("<>",$str1[$i]);
			if($index[0] == $d_number){
				$confirm=$index[4];
			}
		}
		if($confirm != $d_pass){
			echo "パスワードが違います<br>";
		}else{
			$fp2 = fopen($filename,'w');

			for($i=0; $i<count($str); $i++){
				$a = explode("<>",$str[$i]);			//区切り<>ごとに新しい配列aに1つずつ格納.str[$i]ごとに
			
				if($a[0] != $d_number){					//配列の先頭番号が削除番号と一緒かで分岐

					//削除後のものをテキストに新規書き込み
					for($j=1; $j<count($a); $j++){
						fwrite($fp2,$a[$j-1]."<>");					
					}
					fwrite($fp2,$a[count($a)-1]);
				}
			}
			fclose($fp2);

			//**ファイルの中身表示**//
			$new_filename = 'mission_2-5_(uchiyama).txt';
			$new_str = file($new_filename);
			echo "テキストの中身<br>";
				foreach($new_str as $value1){
					$print_str = explode("<>",$value1);
					foreach($print_str as $value2){
						echo $value2." ";
					}
					echo '<br>';
				}
		}
	}

//****----------****//

?>

	</body>
</html>