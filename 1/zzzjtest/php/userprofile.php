<?php
	session_start();
	$result=$_GET['result'];
	$fail=false;
	$appsecret='69bda099d725db3f6a014797ae4fbd4260035b8fe2941184639d7df7240471bf';
	if($result==1){
		if(isset($_GET['stuid']))
			$stuid=$_GET['stuid'];
		else
			$stuid="";
		if(isset($_GET['email']))
			$email=$_GET['email'];
		else
			$email="";
		if(isset($_GET['sign']))
			$sign=$_GET['sign'];
		else
			$sign="";
		if(isset($_GET['uid']))
			$uid=$_GET['uid'];
		else
			$uid="";
		if(isset($_GET['token']))
			$token=$_GET['token'];
		else
			$token="";
		if(isset($_GET['username']))
			$username=$_GET['username'];
		else
			$username="";
		if($sign==strtolower(hash("sha256",$token."|".$uid."|".$username."|".$stuid."|".$email."|".$appsecret))){
			$_SESSION['userid']=$stuid;
		}
		else
			$fail=true;
	}
	else
		$fail=true;
	if($fail==true){
		$url = "http://stu.fudan.edu.cn/";
	}
	else{
		$url="http://stu.fudan.edu.cn/ztalents/main.html";
	}
	echo "<script language='javascript' type='text/javascript'>";
	echo "window.location='".$url."'";
	echo "</script>";
	
?>