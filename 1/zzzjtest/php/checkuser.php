
<?php
	require_once("connectsql.php");
//$_SESSION['userid']="10300240026";
//$_SESSION['userid']=mysqli_real_escape_string($con,$_SESSION["userid"]);
	$string="select id from userin where id={$_SESSION['userid']}";
	$result=mysqli_query($con, $string);
	$id=[];
	while($row = mysqli_fetch_array($result)){
		$id[]=$row['id'];
	}
	if(count($id)!=0)
		echo 1;
	else
		echo 0;
?>