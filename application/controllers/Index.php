<?php
class IndexController extends Yaf_Controller_Abstract {
	//自动调用，类似于构造方法
	public function init(){}

	public function indexAction() {//默认Action
		$userModel = new models_user(); //实例化一个数据库对象
		//$getData = $userModel->getData(); //查询一条数据
		//$userModel->updateData(); //更新数据
		//$userModel->deleteData(); //删除数据

		//插入数据
		/*$result = $userModel->insertData(array('username'=>'asdas','password'=>md5('1921765483'))); 
		if($result > 0){
			echo 'ok';
		}else{
			echo 'no';
		}*/

		//查询多条数据
		/*$userResult = $userModel->getDataAll('',array('username'=>'yang'),5); 
		echo '<pre>';
		var_dump($userResult);*/


		//查询全部数据
		$userAllResult = $userModel->getAllData();
		echo '<pre>';
		var_dump($userAllResult);

		//var_dump(Sendmail::send('<h3>明天周六</h3>', 'xxx@xx.com','email测试'));
		
		$str = 'Hello Yaf';
    		$this->getView()->assign('content',$str);
    		exit;
   	}
}
?>
