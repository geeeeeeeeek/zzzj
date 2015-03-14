<meta charset="utf8">
<?php
	require_once("connectsql.php");
	header(" charset=utf-8");
	$f = fopen ("data//17.txt", "r");
	echo 1;
	$linenum=0;
	while(!feof($f)){
	    $line= fgets ($f);
	    $line= iconv("gbk","utf-8",$line);
	    preg_match_all("/./u",$line,$temp);
	    $ln=0;
	    $qn=0;
	    $tag=0;
	   
	    
	    $ansj=0;
	    $ansi=0;
	    if(count($temp)>0)
	   		$temp=$temp[0];
	    //echo $a;
	    if($linenum%2==0){
	    	$que=[];
	    	while($ln<count($temp)){
	    		if(($temp[$ln]=="（")||($temp[$ln]=="(")){
	    			$tag=2;

	    		}
	    		if($tag==1){
	    			$que[$qn]=$temp[$ln];
	    			$qn++;
	    		}
	    		if($tag==2){
	    			$que[$qn]="_";
	    			$qn++;
	    			if($temp[$ln]=="A"||$temp[$ln]=="B"||$temp[$ln]=="C"||$temp[$ln]=="D")
	    				$answer=$temp[$ln];

	    		}
	
	    		if($temp[$ln]=="、"){
	    			$tag=1;
	    		}
	    		if(($temp[$ln]=="）")||($temp[$ln]==")")){
	    			$tag=1;
	    		}
	    		
	    		$ln++;
	    	}
	    	echo implode($que);
	    	echo "<br/>";

	    }
	    else{
	    	$ans=[];
	   		 $ans[0]=[];
	    	while($ln<count($temp)){
	    		//echo $temp[$ln];
	    		
	    		if((($temp[$ln]==" ")||($temp[$ln]=="	"))&&($tag==1)){
	    			$tag=0;
	    			$ansi++;
	    			$ans[$ansi]=[];
	    			$ansj=0;
	    		}

	    		if($tag==1){
	    			$ans[$ansi][$ansj]=$temp[$ln];
	    			$ansj++;
	    		}
	    		if($temp[$ln]=="、"){
	    			$tag=1;
	    		}
	    		$ln++;
	    	}
	    	if(count($ans)>3){
	    		echo implode($ans[0]);
	    		echo "   ";
	    		echo implode($ans[1]);
	    		echo "   ";
	    		echo implode($ans[2]);
	    		echo "   ";
	    		echo implode($ans[3]);
	    		echo "   ";
	    		echo $answer;
	    		$string="insert into questions (question,category,answer,ansa,ansb,ansc,ansd) values('".implode($que)."',2,'".$answer."','".implode($ans[0])."','".implode($ans[1])."','".implode($ans[2])."','".implode($ans[3])."')";
	    		$result=mysqli_query($con, $string);
	    		echo $result;
	    		//echo $string;
	    	}
	    	echo "</br>";
	    	

	    }
	    $linenum++;

	}
	fclose ($f);
	mysqli_close($con);
?>