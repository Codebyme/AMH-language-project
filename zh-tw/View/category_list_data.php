<?php
!defined('_Amysql') && exit; 

$CategoryList = array(
	'home' => array(
		'id' => 'home', 'url' => 'index.php', 'name' => '主頁', 'en' => 'Home', 'son' => array(
		),
	),
	'host' => array(
		'id' => 'host', 'url' => 'index.php?c=host', 'name' => '虛擬主機', 'en' => 'Host', 'son' => array(
			array('id' => 'vhost', 'url' => 'index.php?c=host&a=vhost', 'name' => '虛擬主機'),
			array('id' => 'php_setparam', 'url' => 'index.php?c=host&a=php_setparam', 'name' => 'PHP配置'),
		),
	),
	'ftp' => array(
		'id' => 'ftp', 'url' => 'index.php?c=ftp', 'name' => 'FTP', 'en' => 'FTP', 'son' => array(
		),
	),
	'mysql' => array(
		'id' => 'mysql', 'url' => 'index.php?c=mysql', 'name' => 'MySQL', 'en' => 'MySQL', 'son' => array(
			array('id' => 'mysql_list', 'url' => 'index.php?c=mysql&a=mysql_list', 'name' => '數據庫'),
			array('id' => 'mysql_create', 'url' => 'index.php?c=mysql&a=mysql_create', 'name' => '快速建庫'),
			array('id' => 'mysql_password', 'url' => 'index.php?c=mysql&a=mysql_password', 'name' => '賬號管理'),
			array('id' => 'mysql_setparam', 'url' => 'index.php?c=mysql&a=mysql_setparam', 'name' => '參數配置'),
		),
	),
	'backup' => array(
		'id' => 'backup', 'url' => 'index.php?c=backup', 'name' => '數據備份', 'en' => 'Backup', 'son' => array(
			array('id' => 'mysql_list', 'url' => 'index.php?c=backup&a=backup_list', 'name' => '備份列表'),
			array('id' => 'backup_remote', 'url' => 'index.php?c=backup&a=backup_remote', 'name' => '遠程設置'),
			array('id' => 'backup_now', 'url' => 'index.php?c=backup&a=backup_now', 'name' => '即時備份'),
			array('id' => 'backup_revert', 'url' => 'index.php?c=backup&a=backup_revert', 'name' => '一鍵還原'),
		),
	),
	'task' => array(
		'id' => 'task', 'url' => 'index.php?c=task', 'name' => '任務計劃', 'en' => 'Task', 'son' => array(
		),
	),
	'module' => array(
		'id' => 'module', 'url' => 'index.php?c=module', 'name' => '模塊拓展', 'en' => 'Module', 'son' => array(
			array('id' => 'module_list', 'url' => 'index.php?c=module&a=module_list', 'name' => '管理模塊'),
			array('id' => 'module_down', 'url' => 'index.php?c=module&a=module_down', 'name' => '下載模塊'),
		),
	),
	'account' => array(
		'id' => 'account', 'url' => 'index.php?c=account', 'name' => '管理員', 'en' => 'Account', 'son' => array(
			array('id' => 'account_log', 'url' => 'index.php?c=account&a=account_log', 'name' => '管理日誌'),
			array('id' => 'account_login_log', 'url' => 'index.php?c=account&a=account_login_log', 'name' => '登錄日誌'),
			array('id' => 'account_pass', 'url' => 'index.php?c=account&a=account_pass', 'name' => '更改密碼'),
		),
	),
	'config' => array(
		'id' => 'config', 'url' => 'index.php?c=config', 'name' => '面板配置', 'en' => 'Config', 'son' => array(
			array('id' => 'config_index', 'url' => 'index.php?c=config&a=config_index', 'name' => '面板配置'),
			array('id' => 'config_upgrade', 'url' => 'index.php?c=config&a=config_upgrade', 'name' => '在線升級'),
			array('id' => 'config_about', 'url' => 'index.php?c=config&a=config_about', 'name' => '關於AMH'),
		),
	),
	'logout' => array(
		'id' => 'logout', 'url' => 'index.php?c=index&a=logout', 'name' => '退出', 'en' => 'Logout', 'son' => array(
		),
	),
);

// 已安装的模块
if (is_array($_SESSION['module_available']))
{
	$module_available = 0;
	foreach ($_SESSION['module_available'] as $key=>$val)
	{
		$val['ModuleAdmin'] = trim($val['ModuleAdmin']);
		if (!empty($val['ModuleAdmin']))
		{
			$CategoryList['module']['son'][] = array(
			'OnlyMenu' => true, 
			'class' => 'user_module',
			'id' => $val['ModuleID'], 
			'url' => $val['ModuleAdmin'], 
			'name' => $val['ModuleName'], 
			/*'img' => $val['ModuleIco'], */
			'target' => '_blank'
			);
			++$module_available;
		}
	}
	if($module_available > 0)
		$CategoryList['module']['name'] .= "<i>({$module_available})</i>";
}



?>