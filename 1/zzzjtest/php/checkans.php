<?php
	require_once("connectsql.php");
	$ans="";
	$string="update user set score=".$_SESSION['score']." where id=".$_SESSION['userid'];
	mysqli_query($con, $string);
	try{
		$ans=$_POST['ans'];
	}
	catch(Exception $e){

	}
	if($ans===$_SESSION['ans']){
		$_SESSION['score']=$_SESSION['score']+5;
		$_SESSION['ans']=null;
		echo 1;
	}
	else
		echo 0;
?>