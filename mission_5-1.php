<html>
 <head>
  <title>ミッション5-1</title>
  <meta charset="utf-8">
 </head>

<body>

<!--送信フォーム-->
 <form method = "POST" action = "mission_5-1.php">

  名前　　<input type = "text" name = "namae">
  <br>
  コメント<input type = "text" name = "comment">
  <br>
  <input type = "submit" name = "b1" value = "送信">
  <br>
  <br>

  削除番号<input type = "text" name = "delete">
  <br>
  pass　　<input type = "password" name = "dpass">
  <br>
  <input type = "submit" name = "b2" value = "削除">
  <br>
  <br>

  編集番号<input type = "text" name = "edit" >
  <br>
  名前　　<input type = "text" name = "editnamae">
  <br>
  コメント<input type = "text" name = "editcomment">
  <br>
  pass　　<input type = "password" name = "epass">
  <br>
  <input type = "submit" name = "b3" value = "編集">



<?php

//mission_5-1

$dsn = 'mysql:dbname=**********;host=localhost';
$user = '*********';
$password = '**********';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//テーブル
$sql = "CREATE TABLE IF NOT EXISTS tbtest"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
	. "comment TEXT,"
	. "created DATETIME"
	.");";
$stmt = $pdo->query($sql);

//テーブル一覧表示
$sql = 'SHOW TABLES';
$result = $pdo -> query($sql);
foreach ($result as $row){
	echo $row[0];
	echo '<br>';
}
echo "<hr>";

//投稿フォームに名前とコメントが入力された時実行
if (isset($_POST["namae"]) && isset($_POST["comment"]) && isset($_POST["b1"])) {

 //投稿フォームの名前かテキストが無記入の時を除く
 if ($_POST["namae"] !="" && $_POST["comment"] !="") {

	//insertを行いデータ入力
	$sql = $pdo -> prepare("INSERT INTO tbtest (name, comment, created) VALUES (:name, :comment, :created)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	$sql -> bindParam(':created', $created, PDO::PARAM_STR);

	$name = $_POST['namae'];
	$comment = $_POST['comment'];
	$created = date('Y-m-d H:i:s');


	$sql -> execute();

 }
}


//削除フォームに削除番号(半角)とパスワードが入力され削除ボタンが押された時実行
elseif (isset($_POST["delete"]) && isset($_POST["b2"]) && isset($_POST["dpass"]) && preg_match("/^[0-9]+$/",$_POST["delete"])) {
  //削除フォームが無記入の時を除く
 if ($_POST["delete"] !="") {
	//パスワードを取得
	$pass = "yadon";
	$dpass = $_POST["dpass"];

		//パスワード一致で削除実行
		if($pass == $dpass){

			//対象の投稿を削除
			$id = ($_POST["delete"]);

			$sql = 'delete from tbtest where id=:id';
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
		}else{
 		 echo "パスワードが違います" . "<br>";
		}

 }
}


//編集フォームに編集番号(半角)と編集内容が入力され編集ボタンが押された時実行
elseif (isset($_POST["edit"]) && isset($_POST["editnamae"]) && isset($_POST["editcomment"]) && isset($_POST["b3"]) && preg_match("/^[0-9]+$/",$_POST["edit"])) {

  //編集フォームの名前かテキストが無記入の時を除く
 if ($_POST["edit"] !="" && $_POST["editnamae"] !="" && $_POST["editcomment"] !="") {

	//パスワードを取得
	$pass = "yadon";
	$epass = $_POST["epass"];

		//パスワード一致で削除実行
		if($pass == $epass){

		//対象の投稿を編集
		$id = ($_POST["edit"]);
		$name = ($_POST["editnamae"]);
		$comment = ($_POST["editcomment"]);
		$created = date('Y-m-d H:i:s');

		$sql = 'update tbtest set name=:name,comment=:comment,created=:created where id=:id';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':name', $name, PDO::PARAM_STR);
		$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->bindParam(':created', $created, PDO::PARAM_STR);
		$stmt->execute();
		}else{
 		 echo "パスワードが違います" . "<br>";
		}

 }
}

//以上のデータをselectで表示
$sql = 'SELECT * FROM tbtest';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();

	foreach($results as $row){
 	 echo $row['id']. ',';
 	 echo $row['name']. ',';
 	 echo $row['comment']. ',';
 	 echo $row['created']. '<br>';
 	 echo "<hr>";
	}


/*
//データ全消し（リセット用）
$sql='DROP TABLE tbtest';
$results=$pdo -> query($sql)
*/

?>


 </body>
</html>
