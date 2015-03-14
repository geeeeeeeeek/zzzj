<?php
	session_start();
	require_once("connectsql.php");
	$string = "update user set quesnum=100 where id= (".$_SESSION['userid'].")";
	mysqli_query($con, $string);
	$scoretemp= $_SESSION['score']+5;
	$string = "select count(*) from user where score > $scoretemp ";
	$result=mysqli_query($con, $string);
	$percent=mysqli_fetch_array($result);
	$string = "select count(*) from user ";
	$result=mysqli_query($con, $string);
	$usernum=mysqli_fetch_array($result);
	$datawrap['score'] = $_SESSION['score'];
	$datawrap['percent'] = $percent[0];
	$datawrap['usernum'] = $usernum[0];
	echo json_encode($datawrap);
?>