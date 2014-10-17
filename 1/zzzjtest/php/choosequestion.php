<?php
	require_once("connectsql.php");
	if(isset($_GET['type']))
		$category=$_GET['type'];
	$string="select id from questions where category=".$category;
	$result=mysql_query($string);
	$return=[];
	$id=[];
	$num=0;
	while($row = mysql_fetch_array($result)){
		$id[$num]=$row['id'];
		$num++;
	}
	for($i=0;$i<5;$i++){
		$j=rand($i+1,$num-1);
		$temp=$id[$i];
		$id[$i]=$id[$j];
		$id[$j]=$temp;
		$return[$i]=$id[$i];

	}
	$string="select id from questions where category=0";
	$result=mysql_query($string);
	$id=[];
	$num=0;
	while($row = mysql_fetch_array($result)){
		$id[$num]=$row['id'];
		$num++;
	}
	
	for($i=0;$i<15;$i++){
		$j=rand($i+1,$num-1);
		$temp=$id[$i];
		$id[$i]=$id[$j];
		$id[$j]=$temp;
		$return[$i+5]=$id[$i];

	}
	
	$datatemp["wrap"]=$return;
	session_start();
	$_SESSION['score']=0;

	$string="select * from user where id= (".$_SESSION['userid'].")";
	$result=mysql_query($string);
	$result=mysql_fetch_array($result);
	if($result==null){
		$string="insert into user(id,quesnum,score,category) values (".$_SESSION['userid'].",0,0,".$category.")";
		mysql_query($string);
	}
	else{
		$string="update user set quesnum=0, score=0 ,category=".$category." where id= (".$_SESSION['userid'].")";
		mysql_query($string);
	}
	echo json_encode($datatemp);
?>