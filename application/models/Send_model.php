<?php
class Send_model extends Base_Model {
	var $page_size = 10;
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
	function inqueue($data){
		if(empty($data))return false;
		$redis = new redis();
		$redis->connect('127.0.0.1',6379);
		$redis->auth('admin888');
		$redis -> select('0');
		$data = json_encode($data);
		$in = $redis->rpush('groupsend',$data);
		if($in){
			return true;
		}
		return false;
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
	
}