<?php
class Send_model extends Base_Model {
	var $page_size = 10;
	
	var $appid= 'wxcc25e743d871491c';
	var $appsecret= 'cf25c60d878bbba24e1ef768908c2add';	
	public function __construct() {
		$this->db_tablepre = 't_sys_';
		$this->table_name = 'send';
		
		
		parent::__construct ();
	}
	public function rows() {
		return array (
				array (
						'name' => '这' 
				),
				array (
						'name' => '是' 
				),
				array (
						'name' => '一' 
				),
				array (
						'name' => '个' 
				),
				array (
						'name' => '演' 
				),
				array (
						'name' => '示' 
				),
				array (
						'name' => '模' 
				),
				array (
						'name' => '块' 
				) 
		);
	}
	
	#拉取一条数据
	public function get_one_fun(){		
		$where = "id = 1";//你要查询的条件
		$field = "*";//你要显示的字段
		$orderby = "id desc";//排序方式
		$groupby = "";//GROUP
		//从table1表中拉取 id=1的数据
		$data_info = $this->Send_model->get_one($where , $field, $orderby, $groupby);
		//如果拉取到了
		if($data_info){
			return $data_info;
		}else{
			return;
		}
	}
		
	#拉取多条数据
	public function get_select_fun(){		
		//从table1表中拉取多条数据		
		$where = "id > 0 or temp_id >= 0";//你要查询的条件
		$field = "temp_id,`send_time` as fieldTWO ";//你要显示的字段
		$orderby = "id desc,temp_id asc";//排序方式
		$groupby = "";//GROUP
		//从table1表中拉取全部数据
		$data_list = $this->Send_model->select($where , $field, $orderby, $groupby);
		//如果拉取到了，这个结果是一个多维数组
		if($data_list){
			return $data_list;
		}else{
			return;
		}
	}
	
	#拉取多条数据带分页
	public  function get_page_list(){
		//从table1表中拉取多条数据		
		$where = "id > 0 or temp_id >= 0";//你要查询的条件
		$field = "temp_id,`send_time` as fieldTWO ";//你要显示的字段
		$orderby = "temp_id desc,send_time asc";//排序方式
		$groupby = "";//GROUP
		$page_no = 1;
		$page_size = 10;//一页显示10条数据
		$page_url_format = page_list_url('adminpanel/send/index',true);

		//从table1表中拉取全部数据
		$data_list = $this->Send_model->listinfo($where , $field, $orderby,$page_no,$page_size, $groupby,$page_url_format);

		//如果拉取到了，这个结果是一个多维数组
		if($data_list){
			print_r($data_list);
			echo $this->Send_model->pages;//打印分页控件
		}else{
			die("信息不存在");
		}
	}
	
	function default_info(){
		return array(
				'id'=>0,
				'temp_id'=>'',
				'first'=>'',
				'keyword1'=>'',
				'keyword2'=>'',
				'keyword3'=>'',
				'keyword4'=>'',
				'keyword5'=>'',
				'invest_style'=>'',
				'invest_profit'=>'',
				'remark'=>'',
				'url'=>'',
				'push_status'=>0,
		);
	}
	
	//入队
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
	
	//出队#!/usr/bin/php
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
	
	//获取access_token
	function get_access_token(){
		$token_url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->appid.'&secret='.$this->appsecret;
		$access_token = @file_get_contents('access_token.txt');
		$expire_time = @file_get_contents('expire_time.txt');
		$template_id = "sUroer1rqkwvMVL4pQK2GYk4itRb_qLacN_FzAZ5i5E";
		//get access_token
		if(!$access_token||$expire_time<time()){ //过期重新获取
			$json = $this->Send_model->https_request($token_url);
			$arr = json_decode($json,true);
			if($arr['access_token']){
				$access_token = $arr['access_token'];
				//将创新获取的access_token存到txt
				file_put_contents('access_token.txt',$access_token);
				file_put_contents('expire_time.txt',time()+7000);
			}else{
				return -1;
			}
		}
		return $access_token;
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