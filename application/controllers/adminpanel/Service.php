<?php
class Service extends Admin_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( array (
				'Service_model'
		) );
	}
	
	/**
	 *  default index
	 * @param number $page_no
	 */
	function index($page_no=1) {
		$page_no = max(intval($page_no),1);
		$where_arr = array();
		$orderby = "id desc";
		$keyword="";
		if (isset($_GET['dosubmit'])) {
			$keyword =isset($_GET['keyword'])?safe_replace(trim($_GET['keyword'])):'';
			if($keyword!="") $where_arr[] = "concat(wx_number,app_id,app_secret,account_name,remark) like '%{$keyword}%'";			
		}
		$where = implode(" and ",$where_arr);
		$data_list = $this->Service_model->listinfo($where,'*',$orderby , $page_no, $this->Service_model->page_size,'',$this->Service_model->page_size,page_list_url('adminpanel/service/index',true));		
		$this->view('index',array('data_list'=>$data_list,'pages'=>$this->Service_model->pages,'keyword'=>$keyword,'require_js'=>true));
	}
	
	/**
	 * 添加
	 * @param post data
	 * @return void
	 */
	function add(){
		//如果是AJAX请求
		if($this->input->is_ajax_request())
		{
			//接收POST参数
			$wx_number = isset($_POST["wx_number"])?trim(safe_replace($_POST["wx_number"])):exit(json_encode(array('status'=>false,'tips'=>'微信账号不能为空')));
			if($wx_number=='')exit(json_encode(array('status'=>false,'tips'=>'微信账号不能为空')));
			$app_id = isset($_POST["app_id"])?trim(safe_replace($_POST["app_id"])):exit(json_encode(array('status'=>false,'tips'=>'app_id不能为空')));
			if($app_id=='')exit(json_encode(array('status'=>false,'tips'=>'app_id不能为空')));
			$app_secret = isset($_POST["app_secret"])?trim(safe_replace($_POST["app_secret"])):exit(json_encode(array('status'=>false,'tips'=>'app_secret不能为空')));
			if($app_secret=='')exit(json_encode(array('status'=>false,'tips'=>'app_secret不能为空')));
			$opt_data = array(
					'wx_number'=>$_POST["wx_number"],
					'app_id'=>$app_id,
					'app_secret'=>$_POST["app_secret"],
					'account_name'=>$_POST["account_name"],
					'remark'=>$_POST["remark"],
					'status'=>$_POST["status"],//使用状态,1启用,0禁用
					'update_time'=>date('Y-m-d H:i:s'),
			);
			$t_id = $this->Service_model->insert($opt_data);
			if($t_id)
			{
			   exit(json_encode(array('status'=>true,'tips'=>'添加成功','t_id'=>$t_id)));				
			}else
			{
				exit(json_encode(array('status'=>false,'tips'=>'添加失败','t_id'=>0)));
			}
		}else{
			$this->view('edit',array('is_edit'=>false,'require_js'=>true,'data_info'=>$this->Service_model->default_info()));
		}
	}
	
	/**
	 * 修改
	 * @param post id
	 * @return void
	 */
	function edit($id=0){
		$id = intval($id);
		$data_info =$this->Service_model->get_one(array('id'=>$id));
		//如果是AJAX请求
		if($this->input->is_ajax_request())
		{
			if(!$data_info)exit(json_encode(array('status'=>false,'tips'=>'信息不存在')));
			$wx_number = isset($_POST["wx_number"])?trim(safe_replace($_POST["wx_number"])):exit(json_encode(array('status'=>false,'tips'=>'微信账号不能为空')));
			if($wx_number=='')exit(json_encode(array('status'=>false,'tips'=>'微信账号不能为空')));
			$app_id = isset($_POST["app_id"])?trim(safe_replace($_POST["app_id"])):exit(json_encode(array('status'=>false,'tips'=>'app_id不能为空')));
			if($app_id=='')exit(json_encode(array('status'=>false,'tips'=>'app_id不能为空')));
			$app_secret = isset($_POST["app_secret"])?trim(safe_replace($_POST["app_secret"])):exit(json_encode(array('status'=>false,'tips'=>'app_secret不能为空')));
			if($app_secret=='')exit(json_encode(array('status'=>false,'tips'=>'app_secret不能为空')));			
			$status = $this->Service_model->update(
					array(
							'wx_number'=>$_POST["wx_number"],
							'app_id'=>$app_id,
							'app_secret'=>$_POST["app_secret"],
							'account_name'=>$_POST["account_name"],
							'remark'=>$_POST["remark"],
							'status'=>$_POST["status"],//使用状态,1启用,0禁用
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
	 * 删除选中数据
	 * @param post pid
	 * @return void
	 */
	function delete(){
		if(isset($_POST))
		{
			$pidarr = isset($_POST['pid']) ? $_POST['pid'] : $this->showmessage('无效参数', HTTP_REFERER);
			$where = $this->Service_model->to_sqls($pidarr, '', 'id');
			$status = $this->Service_model->delete($where);
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