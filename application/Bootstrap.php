<?php
	/* 引导程序，所有以_init开头的方法都将被自动调用 */
	class Bootstrap extends Yaf_Bootstrap_Abstract{
		//实例化model用
		public function _initNameSpace(){
			Yaf_Loader::getInstance(APP_PATH . '/application/')->registerLocalNamespace('models');
		}
	}