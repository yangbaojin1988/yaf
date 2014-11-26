<?php
/*
 * 示范文件
 * 数据库详细操作类，继承数据库类，在本例中类名必须以models_开头
 * 以什么开头取决于你在bootstrap.php中的设置
 * 一个表一个文件
 */
class models_user extends Database{
	public function __construct(){
		parent::__construct();
		$this->_table = 'user'; //表名
	}

	public function getData(){
		$this->_column = 'username';
		$this->_where = array('id'=>7);
		$data = $this->_getOne();
		var_dump($data);
		echo $this->_sql;
	}

	public function getDataAll($column,$data,$limit){
		$this->_column = $column;
		$this->_where = $data;
		$this->_limit = $limit;
		return $this->_getAll();
	}

	public function getAllData(){
		return $this->_column(['id','username','password'])->_from('user')->_where(['username'=>'yang','password'=>123])->_limit('5')->_order('id desc')->_getDataAll();
	} 

	public function updateData(){
		$this->_value = array('username'=>'aaa');
		$this->_where = 'id=5';
		$rows = $this->_update();
		var_dump($rows);
		echo $this->_sql;
	}

	public function deleteData(){
		$this->_where = 'id=5';
		$rows = $this->_delete();
		var_dump($rows);
		echo $this->_sql;
	}

	public function insertData($data){
		$this->_value = $data;
		return $this->_insert();
		//var_dump($lastId);
		//echo $this->_sql;
	}
}