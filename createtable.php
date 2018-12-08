<?php
include 'mmysql.php';
$appid = $_REQUEST['appid'];
if(!$appid){
	exit(10001);
}
create_table("t_sys_users_{$appid}");

//创建数据表
function create_table($table=''){
	if(!$table){return 'please tablename coming';}
	$configArr = array(
			'host'=>'119.23.201.162',
			'port'=>'3306',
			'user'=>'root',
			'passwd'=>'admin888!@#$4',
			'dbname'=>'aci',
	);
	$mysql = new MMysql($configArr);
	
	$sql = "DROP TABLE IF EXISTS `$table`;CREATE TABLE `$table` (
	`user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户表id',
	`subscribe` tinyint(1) DEFAULT NULL COMMENT '是否关注,1关注,0未关注',
	`openid` varchar(255) NOT NULL COMMENT '用户openid',
	`nickname` varchar(255) DEFAULT NULL COMMENT '微信用户昵称',
	`sex` tinyint(1) DEFAULT NULL COMMENT '性别,1男,2女',
	`language` varchar(10) NOT NULL COMMENT '返回语言',
	`city` varchar(100) DEFAULT NULL COMMENT '所在城市',
	`province` varchar(100) DEFAULT NULL COMMENT '所在省份',
	`country` varchar(100) DEFAULT NULL COMMENT '所在国家',
	`headimgurl` text COMMENT '微信头像`',
	`subscribe_time` int(11) DEFAULT NULL COMMENT '关注时间',
	`remark` varchar(255) DEFAULT NULL COMMENT '备注',
	PRIMARY KEY (`user_id`)
	) ENGINE=InnoDB AUTO_INCREMENT=2274 DEFAULT CHARSET=utf8mb4 COMMENT='微信用户表';";
	return $mysql->doSql($sql);
}