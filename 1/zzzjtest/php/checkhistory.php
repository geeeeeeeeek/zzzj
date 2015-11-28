<?php
	require_once("connectsql.php");
//	session_start();
$string="select * from user where id=".$_SESSION['userid'];
$result=mysqli_query($con, $string);
if($result){
    $result=mysqli_fetch_array($result);
		$_SESSION['score']=$result['score'];
		echo $result['quesnum'];
	}
	else
		echo 0;
?>