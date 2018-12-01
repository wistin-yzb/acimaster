<?php
class Send extends Admin_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( array (
				'Send_model' 
		) );
	}
	function index($page_no=1) {
		$page_no = max(intval($page_no),1);		
		$where_arr = array();
		$orderby = "id desc";
		$keyword="";
		if (isset($_GET['dosubmit'])) {
			$keyword =isset($_GET['keyword'])?safe_replace(trim($_GET['keyword'])):'';
			if($keyword!="") $where_arr[] = "concat(temp_id,first,keyword1,keyword2,keyword3,keyword4,keyword5) like '%{$keyword}%'";
			
		}
		$where = implode(" and ",$where_arr);
		$data_list = $this->Send_model->listinfo($where,'*',$orderby , $page_no, $this->Send_model->page_size,'',$this->Send_model->page_size,page_list_url('adminpanel/send/index',true));
		$this->view('index',array('data_list'=>$data_list,'pages'=>$this->Send_model->pages,'keyword'=>$keyword,'require_js'=>true));
	}
	
	/**
	 * 立即发送
	 * @param post data
	 * @return void
	 */
	function add(){
		//如果是AJAX请求
		if($this->input->is_ajax_request())
		{
			//接收POST参数
			$send_time = isset($_POST["send_time"])?trim(safe_replace($_POST["send_time"])):exit(json_encode(array('status'=>false,'tips'=>'时间不能为空')));
			if($send_time=='')exit(json_encode(array('status'=>false,'tips'=>'时间不能为空')));
			$temp_id = isset($_POST["temp_id"])?trim(safe_replace($_POST["temp_id"])):exit(json_encode(array('status'=>false,'tips'=>'模板id不能为空')));
			if($temp_id=='')exit(json_encode(array('status'=>false,'tips'=>'模板不能为空')));
			$push_status = 1;//推送状态,1成功,0失败
			$opt_data = array(
					'send_time'=>$_POST["send_time"],
					'temp_id'=>$temp_id,
					'first'=>$_POST["first"],
					'keyword1'=>$_POST["keyword1"],
					'keyword2'=>$_POST["keyword2"],
					'keyword3'=>$_POST["keyword3"],
					'keyword4'=>$_POST["keyword4"],
					'keyword5'=>$_POST["keyword5"],
					'invest_style'=>$_POST["invest_style"],
					'invest_profit'=>$_POST["invest_profit"],
					'remark'=>$_POST["remark"],
					'url'=>$_POST["url"],
					'push_status'=>$push_status,
					'create_time'=>date('Y-m-d H:i:s'),
					'update_time'=>date('Y-m-d H:i:s'),
			);
			$t_id = $this->Send_model->insert($opt_data);
			if($t_id)
			{
				#加入任务队列
				$access_token  =$this->Send_model->get_access_token();
				if($access_token!=-1&&!empty($access_token)){
					$user_list = $this->Send_model->get_subscribe_user_list($access_token);
					$opt_data['access_token'] = $access_token;
					$inret = @$this->Send_model->inqueue($user_list,$opt_data);	
					if($inret){
						exit(json_encode(array('status'=>true,'tips'=>'新增推送消息成功','t_id'=>$t_id)));
					}else{
						exit(json_encode(array('status'=>false,'tips'=>'新增推送消息失败','t_id'=>0)));
					}
				}				
			}else
			{
				exit(json_encode(array('status'=>false,'tips'=>'新增推送消息失败','t_id'=>0)));
			}
		}else{
			$this->view('edit',array('is_edit'=>false,'require_js'=>true,'data_info'=>$this->Send_model->default_info()));
		}
	}

	/**
	 * 重新发送
	 * @param post id
	 * @return void
	 */
	function edit($id=0){
		$id = intval($id);
		$data_info =$this->Send_model->get_one(array('id'=>$id));
		//如果是AJAX请求
		if($this->input->is_ajax_request())
		{
			if(!$data_info)exit(json_encode(array('status'=>false,'tips'=>'信息不存在')));			
			$temp_id = isset($_POST["temp_id"])?trim(safe_replace($_POST["temp_id"])):exit(json_encode(array('status'=>false,'tips'=>'模板id不能为空')));
			$push_status = $_POST["push_status"];//推送状态,1成功,0失败
			$status = $this->Send_model->update(
					array(
							'temp_id'=>$temp_id,
							'first'=>$_POST["first"],
							'keyword1'=>$_POST["keyword1"],
							'keyword2'=>$_POST["keyword2"],
							'keyword3'=>$_POST["keyword3"],
							'keyword4'=>$_POST["keyword4"],
							'keyword5'=>$_POST["keyword5"],
							'invest_style'=>$_POST["invest_style"],
							'invest_profit'=>$_POST["invest_profit"],
							'remark'=>$_POST["remark"],
							'url'=>$_POST["url"],
							'push_status'=>$push_status,
							'create_time'=>date('Y-m-d H:i:s'),
							'update_time'=>date('Y-m-d H:i:s'),
					),array('id'=>$id));			
			if($status)
			{
				exit(json_encode(array('status'=>true,'tips'=>'修改成功')));
			}else
			{
				exit(json_encode(array('status'=>false,'tips'=>'修改失败')));
			}
		}else{
			if(!$data_info)$this->showmessage('信息不存在');
			$this->view('edit',array('is_edit'=>true,'data_info'=>$data_info,'require_js'=>true));
		}
	}
	
	/**
	 * 查看明细
	 * @param get id
	 * @return void
	 */
	function browser($id){		
		header('Content-Type:text/html;charset=utf-8');
		date_default_timezone_set('PRC');
		set_time_limit(30);
		$id = intval($id);
		$data_info =$this->Send_model->get_one(array('id'=>$id));
		if(!$data_info)$this->showmessage('信息不存在');		
		$this->view('browser',array('is_browser'=>true,'data_info'=>$data_info,'require_js'=>true));
	}
	
	/**
	 * 删除选中数据
	 * @param post pid
	 * @return void
	 */
	function delete(){
		if(isset($_POST))
		{
			$pidarr = isset($_POST['pid']) ? $_POST['pid'] : $this->showmessage('无效参数', HTTP_REFERER);
			$where = $this->Send_model->to_sqls($pidarr, '', 'id');
			$status = $this->Send_model->delete($where);
			if($status)
			{
				$this->showmessage('操作成功', HTTP_REFERER);
			}else
			{
				$this->showmessage('操作失败');
			}
		}
	}
}