<?php
class Service_model extends Base_Model {
	var $page_size = 10;
	public function __construct() {
		$this->db_tablepre = 't_sys_';
		$this->table_name = 'service';				
		parent::__construct ();
	}
	
	function default_info(){
		return array(
				'id'=>0,
				'wx_number'=>'',
				'first'=>'',
				'app_id'=>'',
				'app_secret'=>'',
				'account_name'=>'',
				'remark'=>'',
				'status'=>1,				
		);
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