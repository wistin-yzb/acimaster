<?php
class Send extends Admin_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( array (
				'Send_model' ,'Service_model' ,
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
			$service_id = isset($_POST["service_id"])?trim(safe_replace($_POST["service_id"])):exit(json_encode(array('status'=>false,'tips'=>'请选择公众号')));
			if($service_id==0)exit(json_encode(array('status'=>false,'tips'=>'请选择公众号')));
			$temp_id = isset($_POST["temp_id"])?trim(safe_replace($_POST["temp_id"])):exit(json_encode(array('status'=>false,'tips'=>'请选择模板编号')));
			if($temp_id=='')exit(json_encode(array('status'=>false,'tips'=>'请选择模板编号')));
			$push_status = 1;//推送状态,1成功,0失败
			$opt_data = array(
					'service_id'=>$_POST["service_id"],
					'account_name'=>$_POST["account_name"],
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
					'update_time'=>date('Y-m-d H:i:s'),
			);
			$t_id = $this->Send_model->insert($opt_data);
			if($t_id)
			{
				//获取当前公众号配置信息
				$where = "id={$_POST['service_id']}";//你要查询的条件
				$field = "app_id,app_secret";
				$orderby = "";
				$groupby = "";
				$service_info = $this->Service_model-> get_one($where, '*', $orderby,$groupby);
				#加入任务队列
				$appid = $service_info["app_id"];
				$appsecret = $service_info["app_secret"];				
				$access_token  =$this->Send_model->get_access_token($appid,$appsecret);
				if($access_token!=-1&&!empty($access_token)){
					//$user_list = $this->Send_model->get_subscribe_user_list($access_token);
					//$user_list = array('oc-X_wjs0ylwtyvwcXfLpM5fWVCk','oc-X_wi-d3K--y2k3YpLkzPzzzso'); //测试用户zoey,myr-openid
					$user_list = array('oc-X_wjs0ylwtyvwcXfLpM5fWVCk'); //测试用户zoey,myr-openid
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
			//核查是否已经添加公众号
			$where = "id > 0 and status=1";//你要查询的条件
			$field = "id as service_id,app_id,app_secret,account_name";//你要显示的字段
			$orderby = "id desc";//排序方式
			$groupby = "";//GROUP
			//从table1表中拉取全部数据
			$service_list = $this->Service_model->select($where , $field, $orderby, $groupby);
			if(!$service_list){
				$this->showmessage('请先添加公众号信息','',3000);exit();
			}
			$this->view('edit',array('is_edit'=>false,'require_js'=>true,'data_info'=>$this->Send_model->default_info(),'service_list'=>$service_list));
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
			$service_id = isset($_POST["service_id"])?trim(safe_replace($_POST["service_id"])):exit(json_encode(array('status'=>false,'tips'=>'请选择公众号')));
			if($service_id==0)exit(json_encode(array('status'=>false,'tips'=>'请选择公众号')));
			$temp_id = isset($_POST["temp_id"])?trim(safe_replace($_POST["temp_id"])):exit(json_encode(array('status'=>false,'tips'=>'请选择模板编号')));
			if($temp_id=='')exit(json_encode(array('status'=>false,'tips'=>'请选择模板编号')));
			$push_status = 1;//推送状态,1成功,0失败
			$opt_data = array(
					'service_id'=>$_POST["service_id"],
					'account_name'=>$_POST["account_name"],
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
					'update_time'=>date('Y-m-d H:i:s'),
			);
			$status = $this->Send_model->update(
					$opt_data,array('id'=>$id));			
			if($status)
			{
				//获取当前公众号配置信息
				$where = "id={$_POST['service_id']}";//你要查询的条件
				$field = "app_id,app_secret";
				$orderby = "";
				$groupby = "";
				$service_info = $this->Service_model-> get_one($where, '*', $orderby,$groupby);
				#加入任务队列
				$appid = $service_info["app_id"];
				$appsecret = $service_info["app_secret"];
				$access_token  =$this->Send_model->get_access_token($appid,$appsecret);
				if($access_token!=-1&&!empty($access_token)){
					//$user_list = $this->Send_model->get_subscribe_user_list($access_token);
					//$user_list = array('oc-X_wjs0ylwtyvwcXfLpM5fWVCk','oc-X_wi-d3K--y2k3YpLkzPzzzso'); //测试用户zoey,myr-openid
					$user_list = array('oc-X_wjs0ylwtyvwcXfLpM5fWVCk'); //测试用户zoey,myr-openid
					$opt_data['access_token'] = $access_token;
					$inret = @$this->Send_model->inqueue($user_list,$opt_data);
					if($inret){						
						exit(json_encode(array('status'=>true,'tips'=>'修改成功')));
					}else{						
						exit(json_encode(array('status'=>false,'tips'=>'修改失败')));
					}
				}
			}else
			{
				exit(json_encode(array('status'=>false,'tips'=>'修改失败')));
			}
		}else{
			//核查是否已经添加公众号
			$where = "id > 0 and status=1";//你要查询的条件
			$field = "id as service_id,app_id,app_secret,account_name";//你要显示的字段
			$orderby = "id desc";//排序方式
			$groupby = "";//GROUP
			//从table1表中拉取全部数据
			$service_list = $this->Service_model->select($where , $field, $orderby, $groupby);
			if(!$service_list){
				$this->showmessage('请先添加公众号信息','',3000);exit();
			}			
			if(!$data_info)$this->showmessage('信息不存在');
			$this->view('edit',array('is_edit'=>true,'data_info'=>$data_info,'require_js'=>true,'service_list'=>$service_list));
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
	
	//weixin-redirect_url
	function wechat_redirect(){
		$APPID = "wxcc25e743d871491c";
		$REDIRECT_URI = "http://send.eatuo.com/adminpanel/send/auth2";
		$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$APPID&redirect_uri=$REDIRECT_URI&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
		header("location:$url");exit;
	}
	
	//auth2.0授权
	function auth2(){
		if(!$_GET['code']){
			exit('invalid code');
		}
		$this->Send_model->getauth2($_GET['code']);
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
	
	/**
	 * 获取模板消息列表
	 */
	function get_template_list(){		
		$appid = @$_REQUEST['appid'];
		$appsecret = @$_REQUEST['appsecret'];
		if(!$appid||!$appsecret){
			exit(json_encode(-1));
		}
		$access_token  =$this->Send_model->get_access_token($appid,$appsecret);
		$list = $this->Send_model->get_template_list($access_token);
		echo json_encode($list['template_list']);exit();
	}
}