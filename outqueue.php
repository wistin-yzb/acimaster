<?php
$redis = new redis();
$redis->connect('127.0.0.1',6379);
$redis->auth('admin888');
$redis -> select('0');
$list = $redis->lrange('groupsend',0,-1);
if($list){
	$i=0;
	$len = $redis->lLen('groupsend');
	while(true){
		if($i>=$len){		
			$redis ->close();
			file_put_contents('/usr/local/etc/outqueuecok.txt',1);
			@unlink('/usr/local/etc/groupdata.txt');
			exit();
		}
		$openid = $redis->lpop('groupsend');
		if($openid){
		 //send-msg		 
		 send_template_msg($openid);			
		}
		$i++;
        }
}else{
  $redis ->close();	
}

//send template msg
function send_template_msg($openid){
     if(!$openid){
	return -1;
     }      
             
     $opt_json = json_decode(file_get_contents('/usr/local/etc/groupdata.txt'));       
     $template_url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$opt_json->access_token}";             
    	
     $post_arr = array(
		"touser"=>$openid,
		"template_id"=>$opt_json->temp_id,
		"url"=>$opt_json->url,		
		"data"=>array(
				"first"=>array(
						"value"=>$opt_json->first,
						"color"=>$opt_json->first_color
				),						
				"{$opt_json->key_field1}"=>array(
						"value"=>$opt_json->keyword1,
						"color"=>$opt_json->keyword1_color
				),
				"{$opt_json->key_field2}"=>array(
						"value"=>$opt_json->keyword2,
						"color"=>$opt_json->keyword2_color
				),
				"{$opt_json->key_field3}"=>array(
						"value"=>$opt_json->keyword3,
						"color"=>$opt_json->keyword3_color
				),
				"{$opt_json->key_field4}"=>array(
						"value"=>$opt_json->keyword4,
						"color"=>$opt_json->keyword4_color			
				),
				"{$opt_json->key_field5}"=>array(
						"value"=>$opt_json->keyword5,
						"color"=>$opt_json->keyword5_color			
				),
				"remark"=>array(
						"value"=>$opt_json->remark,
						"color"=>$opt_json->remark_color
				),
		),
		);
         $post_json = json_encode($post_arr);  
	 //file_put_contents('/usr/local/etc/outqueue-debug.txt',$post_json.PHP_EOL,FILE_APPEND);                  
	 $ret = https_request($template_url,$post_json);		
	 //file_put_contents('/usr/local/etc/outqueue-last.txt',$ret.PHP_EOL,FILE_APPEND);
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
