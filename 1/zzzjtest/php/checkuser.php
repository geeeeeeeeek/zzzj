
<?php
	require_once("connectsql.php");
	session_start();
	$string="select id from userin where id=(".$_SESSION['userid'].")";
	$result=mysqli_query($con, $string);
	$return=[];
	$id=[];
	$num=0;
	while($row = mysqli_fetch_array($result)){
		$id[$num]=$row['id'];
		$num++;
	}
	if($num!=0){
		echo 1;
	}
	else
		echo 0;
?>