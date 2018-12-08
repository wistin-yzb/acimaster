<?php 
include 'mmysql.php';
$postjson = $_REQUEST['json'];
$appid = $_REQUEST['appid'];

if(!$postjson||!$appid){
	return -1;
}

$postdata = json_decode($postjson);

//连接数据库
$configArr = array(
		'host'=>'119.23.201.162',
		'port'=>'3306',
		'user'=>'root',
		'passwd'=>'admin888!@#$4',
		'dbname'=>'aci',
);
$mysql = new MMysql($configArr);

//插入
$arr = array(
		'subscribe'=>$postdata->subscribe,
		'openid'=>$postdata->openid,
		'nickname'=>$postdata->nickname,
		'sex'=>$postdata->sex,
		'language'=>$postdata->language,
		'city'=>$postdata->city,
		'province'=>$postdata->province,
		'country'=>$postdata->country,
		'headimgurl'=>$postdata->headimgurl,
		'subscribe_time'=>$postdata->subscribe_time,
		'remark'=>$postdata->remark
);
return $mysql->insert('t_sys_users_'.$appid,$arr);
?>