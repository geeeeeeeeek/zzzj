<?php
	require_once("connectsql.php");
	if($_SESSION["userid"]!=null){
		$string="select count(*) from questions";
		$result=mysqli_query($con, $string);
		$num=mysqli_fetch_array($result);
		$count=$num[0];
		try{
			$num=(intval($_GET["id"]));
			$count=(intval($_GET['count']));
		}
		catch(Exception $e){
	
		}
        if($num==0){
            die("Cannot get null thing.");
        }
		$string="update user set actnum = (actnum+1) where id=".$_SESSION['userid'];
		mysqli_query($con, $string);
		$string="select * from questions where id=$num";
		$result=mysqli_query($con, $string);
		$result=mysqli_fetch_array($result);
		$str=$result["question"];
		$id=$result["id"];
		$ansa=$result["ansa"];
		$ansb=$result["ansb"];
		$ansc=$result["ansc"];
		$ansd=$result["ansd"];
		$ans=$result["answer"];
		$time=$result["timelimit"];
		$_SESSION['ans']=$ans;
    	$_SESSION['time']=$time;
    	$_SESSION['ansa']=$ansa;
    	$_SESSION['ansb']=$ansb;
    	$_SESSION['ansc']=$ansc;
    	$_SESSION['ansd']=$ansd;
    	$string="update user set quesnum = (quesnum+1) where id=".$_SESSION['userid'];
		mysqli_query($con, $string);
	}
    
?>