<?php
echo 123;
printLog(json_encode($_GET));
  $signature = $_GET["signature"];
    $timestamp = $_GET["timestamp"];
    $nonce = $_GET["nonce"];
    $echostr = $_GET["echostr"];
    $token = "jt666";
    $tmpArr = array($token, $timestamp, $nonce);
    sort($tmpArr, SORT_STRING);
    $tmpStr = implode( $tmpArr );
    $tmpStr = sha1( $tmpStr );
    printLog("tmpStr:".$tmpStr);
    printLog("signature:".$signature);
    if( $tmpStr == $signature ){
        echo  $echostr;
    }else{
        echo  false;
    }
    /**
     * 打印数据
     * @param  string $txt  日志记录
     * @param  string $file 日志目录
     * @return 
     */
    function printLog($txt="",$file="ceshi.log"){
    $myfile = fopen($file, "a+");
    $StringTxt = "[".date("Y-m-d H:i:s")."]".$txt."\n";
fwrite($myfile, $StringTxt);
fclose($myfile);
    }
?>