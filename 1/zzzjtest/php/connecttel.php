<?php
	function generate_password( $length = 8 ) {  
		// 密码字符集，可任意添加你需要的字符  
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';  
		$password = '';  
		for ( $i = 0; $i < $length; $i++ )  
		{  
		// 这里提供两种字符获取方式  
		// 第一种是使用 substr 截取$chars中的任意一位字符；  
		// 第二种是取字符数组 $chars 的任意元素  
		// $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);  
		$password .= $chars[ mt_rand(0, strlen($chars) - 1) ];  
		}  
		return $password;  
	} 
	$appid='050921da0e7e0556e87cdc86605ddf05ab6e982ca6fbcbe2744a63835e31deb7';
	$returnurl="http://stu.fudan.edu.cn/ztalents/php/userprofile.php";
	$state=generate_password();
	$appsecret='69bda099d725db3f6a014797ae4fbd4260035b8fe2941184639d7df7240471bf';
	$stringtemp=$returnurl."|".$appid."|".$state."|||".$appsecret;
	$sign=hash('sha256',$stringtemp);
	$url = "http://stu.fudan.edu.cn/teleport/gateway/request?returnurl=".$returnurl."&appid=".$appid."&state=".$state."&sign=".$sign;
	header("Location: {$url}");
?>