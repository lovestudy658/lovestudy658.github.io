<?php
error_reporting(0);
header("Content-Type: text/html; charset=UTF-8");
$user="admin";//管理员账号
$pass="15007775548";//管理员密码

$config="data.txt";

function aes ($pwd, $data) {
     $key[] ="";
     $box[] ="";  
     $pwd_length = strlen($pwd);
     $data_length = strlen($data);  
     for ($i = 0; $i < 256; $i++) {
      $key[$i] = ord($pwd[$i % $pwd_length]);
      $box[$i] = $i;
     }  
     for ($j = $i = 0; $i < 256; $i++) {
      $j = ($j + $box[$i] + $key[$i]) % 256;
      $tmp = $box[$i];
      $box[$i] = $box[$j];
      $box[$j] = $tmp;
     }  
     for ($a = $j = $i = 0; $i < $data_length; $i++) {
		  $a = ($a + 1) % 256;
		  $j = ($j + $box[$a]) % 256;  
		  $tmp = $box[$a];
		  $box[$a] = $box[$j];
		  $box[$j] = $tmp;  
		  $k = $box[(($box[$a] + $box[$j]) %256)];
		  @$cipher .= chr(ord($data[$i]) ^ $k);  
     }
     	return $cipher;  
    }
 function 加密($string,$key){
   return substr(chunk_split(bin2hex(aes($key,$string))),0,-2);
}
 function 加载(){
 	$datx='{"t4":"\u66f4\u591a\u8f6f\u4ef6","t3":"https:\/\/yz.m.sm.cn","t2":"\u6d4b\u8bd5\u4e00\u4e0b","t1":"true","p":"true","i":"\u6d4b\u8bd5\u5185\u5bb9","f":"1","a":"mqqapi:\/\/card\/show_pslcard?src_type=internal&version=1&uin=123456&card_type=group&source=qrcode","u":"https:\/\/yz.m.sm.cn","b1":"true","b2":"true","b3":"true","b":"\u672c\u56e2\u961f\u5f00\u53d1\u7684\u6240\u6709\u7a0b\u5e8f\u4ec5\u9650\u7528\u4e8e\u4ea4\u6d41\u5b66\u4e60\uff0c\u8bf7\u52ff\u7528\u4e8e\u4efb\u4f55\u975e\u6cd5\u7528\u9014","m":"\u672c\u56e2\u961f\u4fdd\u7559\u4e00\u5207\u8ffd\u7a76\u8d23\u4efb\u7684\u6743\u5229\uff0c\u5728\u4f7f\u7528\u4e4b\u524d\u8bf7\u901a\u8fc7QQ\u5206\u4eab\u5230200\u4eba\u4ee5\u4e0a\u7684QQ\u7fa4"}';
   	if(file_get_contents("data.txt")==""){
     file_put_contents("data.txt", $datx);
  	}
}

if($_GET["my"]=="a"){
 	加载();
echo json_encode(array("cook"=>"1"));
}elseif($_GET["my"]=="b"){
  	加载();
echo json_encode(array("cook"=>"2"));
}elseif($_GET["my"]=="c"){  
 	加载();
  if($user==$_GET['user']){
      if($pass==$_GET['pass']){
       	echo json_encode(array("cook"=>"1","msg"=>str_replace("&card_type=group&source=qrcode","",str_replace("mqqapi:\/\/card\/show_pslcard?src_type=internal&version=1&uin=","",file_get_contents($config)))));
      }else{
   		echo json_encode(array("cook"=>"0"));
      }
      }else{
   		echo json_encode(array("cook"=>"0"));
      }
}elseif($_GET["my"]=="app"){
  	$arr= explode("\n",file_get_contents("off.txt"));
  	$iii="";
  	for ($x=0; $x<=count($arr); $x++) {
  	if ($_GET['pa']==$arr[$x]){
    	$iii="1";
     	break;
    }
	}
  $datax= file_get_contents($config);
  if($iii=="1"){
   $datax=str_replace('"p":"false"','"p":"true"',str_replace('"b3":"true"','"b3":"false"',$datax));
  }
$text = array("data"=>加密($datax,strtoupper(md5($_GET['pa'])))); 
echo strtoupper(str_replace("\\r\\n","",json_encode($text)));  
}elseif($_GET["my"]=="up"){
   if($user==$_GET['user']){
      if($pass==$_GET['pass']){
       file_put_contents($config,json_encode(array("t4"=>$_GET['t4'],"t3"=>$_GET['t3'],"t2"=>$_GET['t2'],"t1"=>$_GET['t1'],"p"=>$_GET['p'],"i"=>$_GET['i'],"f"=>$_GET['f'],"a"=>"mqqapi://card/show_pslcard?src_type=internal&version=1&uin=".$_GET['a']."&card_type=group&source=qrcode","u"=>$_GET['u'],"b1"=>$_GET['b1'],"b2"=>$_GET['b2'],"b3"=>$_GET['b3'],"b"=>$_GET['b'],"m"=>$_GET['m'])));
       echo json_encode(array("cook"=>"1"));
      }else{
   		echo json_encode(array("cook"=>"0"));
      }
      }else{
   		echo json_encode(array("cook"=>"0"));
      }
}

?>
