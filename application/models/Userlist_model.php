<?php
class Userlist_model extends Base_Model {
	var $page_size = 10;
	
	public function __construct() {		
		$this->db_tablepre = 't_sys_';
		$this->table_name = 'users_'.@$_GET['appid'];
		parent::__construct ();
	}
	
	
}