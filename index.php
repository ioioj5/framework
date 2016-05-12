<?php
// 提取Zend_Cache,Zend_Db,Zend_Load,Zend_View
//自动加载类
function __autoload($class) {
	if (class_exists($class)) return ;
	$path = str_replace('_', DIRECTORY_SEPARATOR, $class);
	if(! @require_once $path . '.php'){
		Zend_Loader::loadClass($class);
	}
}
//require_once './library/Zend/Db/Table/Abstract.php';
//require_once './library/Zend/Db/Adapter/Pdo/Mysql.php';
//require_once './library/Zend/Db/Adapter/Pdo/Abstract.php';
//require_once './library/Zend/Db/Adapter/Abstract.php';

//实例化视图类
$view   = new Zend_View();

//初始化缓存
$frontendOptions = array(
   'lifeTime' => 7200, // 两小时的缓存生命期
   'automatic_serialization' => true // 自动序列化
);

$backendOptions = array(
    'cache_dir' => './cache/' // 缓存文件的目录
);

/* - 数据库配置 - */
$params = array ('host'     => 'localhost',
                 'username' => 'root',
                 'password' => '123456',
                 'dbname'   => 'test');
$db = Zend_Db::factory('PDO_MYSQL', $params);
//为所有的Zend_Db_Table对象设定默认的adapter
Zend_Db_Table::setDefaultAdapter($db);

//$db = Zend_Db_Table_Abstract::getDefaultAdapter();
//require_once './models/Pic.php';
//$user    = new Model_User();

//$view->users = $db->fetchAll('SELECT * FROM `user`');




// 取得一个Zend_Cache_Core 对象
$cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);

$view->setScriptPath('./template');
if(! $view->one = $cache->load('one')){
    $view->one  = array('name'=>'ioioj5', 'age'=>'22');
    $cache->save($view->one, 'one');
}else{
    echo 'this is a test for cache';
}
echo $view->render('view.phtml');
?>