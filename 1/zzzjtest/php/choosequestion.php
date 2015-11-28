<?php
	require_once("connectsql.php");
	if(isset($_GET['type']))
		$category=$_GET['type'];
    else
        $category=0;
    $category=(intval($category));
    if (!isset($_SESSION['userid']))
        die("Error.");
    $result=[];
    $ca=mysqli_real_escape_string($con,$category);
    $string="(SELECT id FROM questions WHERE category={$ca} ORDER BY RAND() LIMIT 5) UNION ALL (SELECT id FROM questions WHERE category=0 ORDER BY RAND() LIMIT 15)";
    $fet=mysqli_query($con, $string);
    while($row = mysqli_fetch_array($fet)){
        $result[]=$row[0];
        if($row[0]===null)
            die("Error.");
    }
    $datatemp["wrap"]=$result;
    $_SESSION["questions"]=$result;
    $_SESSION['score']=0;
    $string="INSERT INTO user(id,quesnum,score,category) VALUES ('{$_SESSION['userid']}',0,0,$ca) ON DUPLICATE KEY UPDATE quesnum=0,score=0, category={$ca};";
    mysqli_query($con, $string);
    echo json_encode($datatemp);
?>