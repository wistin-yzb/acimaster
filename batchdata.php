<?php
$redis = new redis();
$redis->connect('127.0.0.1',6379);
$redis->auth('admin888');
$redis -> select('1');
$list = $redis->lrange('batchdata',0,-1);
$batchtoken = $redis->lrange('batchtoken',0,-1);
$batchappid = $redis->lrange('batchappid',0,-1);
if($list){
    $i=0;
    $len = $redis->lLen('batchdata');
    while(true){
       	if($i>=$len){	
	       $redis->lpop('batchtoken');
	       $redis->lpop('batchappid'); 	
	       $redis ->close();
	       file_put_contents('/usr/local/etc/batchdatacok.txt',1);
	       exit();
	 }
	 $subuserinfo = $redis->lpop('batchdata');
	 if($subuserinfo){	    
	    get_user_info($batchtoken[0],$subuserinfo,$batchappid[0]);
	 }
	 $i++;
    }	
}else{
  $redis ->close();
}

//get-user_info
function get_user_info($access_token,$openid,$appid){
        if(!$access_token||!$openid||!$appid){
	    return -1;
	} 
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
        $ret = https_request($url);	

	$batchinsert_url = "http://send.eatuo.com/batch.php?json=$ret&appid=$appid";
	https_request($batchinsert_url);	
}

//remote-post
function https_request($url,$data = NULL)
{
	$curl = curl_init();
	curl_setopt($curl,CURLOPT_URL,$url);
	curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
	curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
	if (!empty($data))
	{
		curl_setopt($curl,CURLOPT_POST,1);
		curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
		//curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query($data));
	}
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
	$output = curl_exec($curl);
	curl_close($curl);
	return $output;
}
?>