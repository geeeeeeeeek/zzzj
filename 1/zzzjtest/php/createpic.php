<?php
    session_start();
    require("getques.php");  //计算题号$id, 题目$str,答案$ans,时限time
    header("Content-type: image/png");

    $num=rand(0,1);
    $strsplit=[];
    $each=24;
    $eachheight=28;
    $j=0;
    $_SESSION['ans']=$ans;
    $_SESSION['time']=$time;
    
   
    $line=(int)(mb_strlen($str,"utf-8")/$each)+1;
    $height=26*$line+40;
    $image=imagecreate(520,$height);
    $grey=  imagecolorallocate($image, 238 ,238, 238);
    $grey2=  imagecolorallocate($image, 77 ,77, 77);
    $black = imagecolorallocate($image, 0,0,0);
    $green= imagecolorallocate($image,33,66,0);
    $str=($count+1).". ".$str;
    imagefill($image,0,0,$grey);
    for ($i=0;$i<$line;$i++){
            $strsplit[$i]=mb_substr($str,$i*$each,$each,"utf-8");
        imagettftext($image, 14, 0, 0, $eachheight*$i+40, $grey2, dirname(__FILE__) . "/msyhbd.ttc", $strsplit[$i]);
    }
    //echo var_dump($strsplit[0]);
   
   
    imagepng($image);

?>