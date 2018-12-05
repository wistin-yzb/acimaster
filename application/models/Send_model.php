<?php
class Send_model extends Base_Model {
	var $page_size = 10;
	
	public function __construct() {
		$this->db_tablepre = 't_sys_';
		$this->table_name = 'send';		
		parent::__construct ();
	}
	
	//default
	function default_info(){
		return array(
				'id'=>0,
				'temp_id'=>'',
				'first'=>'',
				'keyword1'=>'',
				'key_field1'=>'',
				'keyword2'=>'',
				'key_field2'=>'',
				'keyword3'=>'',
				'key_field3'=>'',
				'keyword4'=>'',
				'key_field4'=>'',
				'keyword5'=>'',
				'key_field5'=>'',
				'invest_style'=>'',
				'invest_profit'=>'',
				'remark'=>'',
				'url'=>'',
				'push_status'=>0,
				'account_name'=>'',
		);
	}
	
	//inqueue
	function inqueue($data,$opt_data){
		if(empty($data))return false;
		$redis = new redis();
		$redis->connect('127.0.0.1',6379);
		$redis->auth('admin888');
		$redis -> select('0');
		$i=0;
		while(true){
		     if($i>count($data)){
		     	file_put_contents('/usr/local/etc/groupdata.txt', json_encode($opt_data));
		        $redis ->close();
				return true;
			}
			$redis->rpush('groupsend',$data[$i]);						
			$i++;
		}		
	}
	
	//outqueue
	function outqueue()
	{
		$redis = new redis();
		$redis->connect('127.0.0.1',6379);
		$redis->auth('admin888');		
		$redis -> select('0');
		$value = $redis->lpop('groupsend');
		$value = json_decode($value,true);
		echo '<pre>';
		var_dump($value);
	}
	
	//获取队列中所有数据
	function getlistqueue(){
		$redis = new redis();
		$redis->connect('127.0.0.1',6379);
		$redis->auth('admin888');
		$redis -> select('0');
		$list = $redis->lrange('groupsend',0,-1);
		var_dump($list);
	}
	
	//单条发送模板消息
	function send_template_msg($openid='',$opt_data){				
		if($openid||!$opt_data){
			return -1;
		}
		$opt_json = json_encode($opt_data);
		$template_url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$opt_json->access_token";		
		$post_arr = array(
				"touser"=>$openid,
				"template_id"=>"{$opt_json->temp_id}",
				"url"=>"{$opt_json->url}",
				"data"=>array(
						"first"=>array(
								"value"=>"{$opt_json->first}",
								"color"=>"#173177"
						),						
						"keyword1"=>array(
								"value"=>"{$opt_json->keyword1}",
								"color"=>"#173177"
						),
						"keyword2"=>array(
								"value"=>"{$opt_json->keyword2}",
								"color"=>"#173177"
						),
						"keyword3"=>array(
								"value"=>"{$opt_json->keyword3}",
								"color"=>"#173177"
						),
						"keyword4"=>array(
								"value"=>"{$opt_json->keyword4}",
								"color"=>"#173177"
						),
						"keyword5"=>array(
								"value"=>"{$opt_json->keyword5}",
								"color"=>"#173177"
						),
						"remark"=>array(
								"value"=>"{$opt_json->remark}",
								"color"=>"#173177"
						),
				),
		);
		$post_json = json_encode($post_arr);		
		return self::https_request($template_url,$post_json);
	}
	
	//get:access_token-废弃掉
	function get_access_token($appid,$appsecret){
		if(!$appid||!$appsecret)return;
		$token_url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
		$access_token = @file_get_contents('access_token.txt');
		$expire_time = @file_get_contents('expire_time.txt');
		//get access_token
		if(!$access_token||$expire_time<time()){ //过期重新获取
			$json = $this->https_request($token_url);		
			$arr = @json_decode($json,true);
			if($arr['access_token']){
				$access_token = $arr['access_token'];
				//将创新获取的access_token存到txt
				file_put_contents('access_token.txt',$access_token);
				file_put_contents('expire_time.txt',time()+3600);
			}else{
				return -1;
			}
		}
		return $access_token;
	}
	
	//get:last_access_token
	function get_last_access_token($appid,$appsecret){
		if(!$appid||!$appsecret)return;
		$token_url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
			$json = $this->https_request($token_url);
			$arr = @json_decode($json,true);
			if(@$arr['access_token']){
				return $arr['access_token'];
			}else{
				return -1;
			}
	}
	
	//获取指定公众号的关注用户列表[5w以内]
	function get_subscribe_user_list($access_token){
		$remote_url_1 = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$access_token";		
		$ret = $this->https_request($remote_url_1);
		$json = json_decode($ret,true);
		$openid_arr = array();
		$openid_arr = $json['data']['openid'];
		if($json['total']<=10000){ //小于1w
			$total_openid_arr =  $openid_arr;
	    }elseif($json['total']>10000){//小于2w
			$remote_url_2 = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$access_token&next_openid=$openid_arr[9999]";
			$ret_2 = $this->https_request($remote_url_2);
			$json_2 = json_decode($ret_2,true);
			$openid_arr_2 = array();
			$openid_arr_2 = $json_2['data']['openid'];					
			$total_openid_arr = array_merge($openid_arr,$openid_arr_2);		
	    }elseif($json['total']>20000){//小于3w
	    	$remote_url_3 = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$access_token&next_openid=$openid_arr[19999]";
	    	$ret_3 = $this->https_request($remote_url_3);
	    	$json_3 = json_decode($ret_3,true);
	    	$openid_arr_3 = array();
	    	$openid_arr_3 = $json_3['data']['openid'];
	    	$total_openid_arr = array_merge($openid_arr,$openid_arr_2,$openid_arr_3);		
	    }elseif($json['total']>30000){//小于4w
	    	$remote_url_4 = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$access_token&next_openid=$openid_arr[29999]";
	    	$ret_4 = $this->https_request($remote_url_4);
	    	$json_4 = json_decode($ret_4,true);
	    	$openid_arr_4 = array();
	    	$openid_arr_4 = $json_4['data']['openid'];
	    	$total_openid_arr = array_merge($openid_arr,$openid_arr_2,$openid_arr_3,$openid_arr_4);
	    }elseif($json['total']>40000){//小于5w
	    	$remote_url_5 = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$access_token&next_openid=$openid_arr[39999]";
	    	$ret_5 = $this->https_request($remote_url_5);
	    	$json_5 = json_decode($ret_5,true);
	    	$openid_arr_5 = array();
	    	$openid_arr_5 = $json_5['data']['openid'];
	    	$total_openid_arr = array_merge($openid_arr,$openid_arr_2,$openid_arr_3,$openid_arr_4,$openid_arr_5);
	    }
	    file_put_contents('alluserlist.txt', json_encode($total_openid_arr));
		return $total_openid_arr; 
	}
	
	//获取用户基本信息:http请求方式: GET
	function get_user_info($access_token='',$openid=''){
		if(!$access_token&&!$openid){
			return -1;
		}
		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
		$json = $this->https_request($url);
		$ret   = json_decode($json,true);
		return $ret;
	}
	
	//网页授权
	function getauth2($code){
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$this->appid&secret=$this->appsecret&code=$code&grant_type=authorization_code";
		$json = $this->https_request($url);
		echo '<pre>';
		var_dump($json);
		echo '</pre>';
		file_put_contents('myopenid.txt', $json);
	}
	
	//获取所有模板消息列表
	function get_template_list($access_token){
		if(!$access_token)return;
		$url = "https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token=$access_token";
		$json = $this->https_request($url);
		$ret   = json_decode($json,true);
		return $ret;
	}
	
	//远程post请求
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
}