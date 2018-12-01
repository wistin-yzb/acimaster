<?php
$redis = new redis();
$redis->connect('127.0.0.1',6379);
$redis->auth('admin888');
$redis -> select('0');
$list = $redis->lrange('groupsend',0,-1);
$opt_data = $redis->lrange('groupdata',0,-1);

if($list){
	$i=0;
	$len = $redis->lLen('groupsend');
	//file_put_contents('/usr/local/etc/outqueuelen.txt',$len);
	while(true){
		if($i>$len){
			//file_put_contents('/usr/local/etc/outqueueoptdata.txt',$opt_data);
			$redis->lpop('groupdata');
			$redis ->close();
			file_put_contents('/usr/local/etc/outqueuecok.txt',1);
		}
		$openid = $redis->lpop('groupsend');
		if($openid&&$opt_data){
		 //send template msg		 
		 send_template_msg($openid,$opt_data);			
		}
		$i++;
        }
}else{
  $redis ->close();	
}

//send template msg
function send_template_msg($openid,$opt_data){
     if(!$openid||!$opt_data){
	return -1;
     }       
     $post_data = json_decode($opt_data);
     $template_url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$post_data['access_token']}";        
     
     file_put_contents('/usr/local/etc/outqueuec-template_url.txt',$opt_data);
     return 12;
     
     $post_arr = array(
		"touser"=>$openid,
		"template_id"=>"{$opt_data['temp_id']}",
		"url"=>"{$opt_data['url']}",
		"data"=>array(
				"first"=>array(
						"value"=>"{$post_data['first']}",
						"color"=>"#173177"
				),						
				"keyword1"=>array(
						"value"=>"{$post_data['keyword1']}",
						"color"=>"#173177"
				),
				"keyword2"=>array(
						"value"=>"{$post_data['keyword2']}",
						"color"=>"#173177"
				),
				"keyword3"=>array(
						"value"=>"{$post_data['keyword3']}",
						"color"=>"#173177"
				),
				"keyword4"=>array(
						"value"=>"{$post_data['keyword4']}",
						"color"=>"#173177"			
				),
				"keyword5"=>array(
						"value"=>"{$post_data['keyword4']}",
						"color"=>"#173177"			
				),
				"remark"=>array(
						"value"=>"{$post_data['remark']}",
						"color"=>"#173177"
				),
		),
		);
		$post_json = json_encode($post_arr);     
	//$this->https_request($template_url,$post_json);		
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
