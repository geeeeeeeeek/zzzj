<?php
	header('content-type:text/html;charset=utf-8');
	$con = mysqli_connect("localhost","zzzj","zzzj", "questions");
	mysqli_query($con, "SET NAMES 'UTF8'");
	$num=null;
	if (!$con)
	{
	    die('Could not connect: ' . mysqli_error());
	}
?>