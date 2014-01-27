<?php

/************************************************
 * Amysql Host - AMH 4.2
 * Amysql.com 
 * @param Object host 主机控制器
 * Update:2013-11-01
 * 
 */

class host extends AmysqlController
{
	public $indexs = null;
	public $hosts = null;
	public $action_name = array('start' => 'Start' , 'stop' => 'Stop' , 'reload' => 'Reload');
	public $notice = null;
	public $top_notice = null;

	// 载入数据模型(Model)
	function AmysqlModelBase()
	{
		if($this -> indexs) return;
		$this -> _class('Functions');
		$this -> indexs = $this ->  _model('indexs');
		$this -> hosts = $this ->  _model('hosts');
	}

	// 默认访问
	function IndexAction()
	{
		$this -> vhost();
	}

	// Virtual Hosts
	function vhost()
	{
		$this -> title = 'Virtual Hosts - AMH';
		$this -> AmysqlModelBase();
		Functions::CheckLogin();

		$this -> status = 'error';
		$error_page_list = array(array('400', 1, 'Error Require Page'), array('401', 0, 'No Permission to explore.'), array('403', 1, 'No Permissions To load'), array('404', 1, 'The Page Not Found'), array('405', 0, 'No Permission'), array('502', 1, 'Unable to respond to the request'), array('503', 0, 'The server is not available'), array('504', 0, 'The request timeout'));
		if (isset($_POST['save']) || isset($_POST['save_edit']))
		{
			$host_error_page = array();
			foreach ($error_page_list as $key=>$val)
			{
				if ($_POST[$val[0]] == 'on') $host_error_page[] = $val[0];
			}
			$_POST['host_error_page'] = count($host_error_page) > 0 ? implode(',', $host_error_page) : 'off';
		}
		

		// 运行维护
		if (isset($_GET['run']))
		{
			$m = isset($_GET['m']) ? $_GET['m'] : '';
			$g = isset($_GET['g']) ? $_GET['g'] : '';
			$domain = str_replace(' ', '', $_GET['run']);
			$cmd = "amh $m $g $domain";
			
			// AMH面板phpReload
			if ($m == 'php' && $g == 'reload' && $domain == 'amh-web' && isset($_GET['confirm']))
				$cmd .= ' y';	

			if (!empty($m) && !empty($g) && in_array($m, array('php', 'host')) && in_array($g, array('start', 'stop', 'reload')) ) 
			{
				$cmd = Functions::trim_cmd($cmd);
				exec($cmd, $tmp, $status);
				if($m == 'php') sleep(1);
				if (!$status)
				{
					$this -> status = 'success';
					$this -> top_notice = "$domain " . $m . $this -> action_name[$g] . 'Success';
				}
				else
				{
					$this -> status = 'error';
					$this -> top_notice = "$domain " .$m . $this -> action_name[$g] . 'Failed.';
				}
			}
		}

		// Deletehost
		if (isset($_GET['del']))
		{
			$del_name = $_GET['del'];
			if(!empty($del_name))
			{
				$result = $this -> hosts -> host_del_ssh($del_name);
				if ($result[0])
				{
					$this -> status = 'success';
					$this -> top_notice = $del_name . ' : Delete Virtual Host Successful.';
				}
				else
					$this -> top_notice = $del_name . ' : Delete Virtual Host Failed.' . implode(',', $result[1]);
			}
		}

		// 保存host
		if (isset($_POST['save']))
		{
			if (empty($_POST['host_domain']))
				$this -> notice = 'Please fill in the primary identifier name.';
			else
			{
				$result = $this -> hosts -> host_insert_ssh($_POST);
				if ($result[0])
				{
					$this -> hosts -> host_insert($_POST);
					$this -> status = 'success';
					$this -> notice = $_POST['host_domain'] . ' : Add Virtual Host Successful.';
					$_POST = array();
				}
				else
					$this -> notice = $_POST['host_domain'] . ' : Add Virtual Hosts Failed.' . implode(',', $result[1]);
			}
		}


		// 编辑host
		if (isset($_GET['edit']))
		{
			$edit_name = $_GET['edit'];
			$_POST = $this -> hosts -> get_host($edit_name);
			foreach ($error_page_list as $key=>$val)
				$error_page_list[$key][1] = (strpos($_POST['host_error_page'], $val[0]) !== false) ? 1 : 0;

			list($_POST['php_fpm_pm'], $_POST['min_spare_servers'], $_POST['start_servers'], $_POST['max_spare_servers'], $_POST['max_children']) = explode(',', $_POST['host_php_fpm']);
			$this -> edit_host = true;
		}

		// 保存编辑host
		if (isset($_POST['save_edit']))
		{
			$_POST['host_domain'] = $host_name = $_POST['save_edit'];
			$this -> status = 'success';
			$result = $this -> hosts -> edit_host();
			if ($result[0])
			{
				$status = true;
				$top_notice = $host_name . ' : Edit Virtual Hosts Config Successful.';
			}
			else
			{
				$this -> status = 'error';
				$top_notice = $host_name . ' : Edit Virtual Hosts Config Failed.' . implode(',', $result[1]);
			}
			
			if(isset($status)) 
				$_POST = array();
			else 
				$this -> edit_host = true;
			$this -> top_notice = $top_notice;
			
		}
			
		$this -> hosts -> host_update();
		$this -> host_list = $this -> hosts -> host_list();

		$Rewrite = trim(shell_exec("amh ls_rewrite"), "\n");
		$this -> Rewrite = explode("\n", $Rewrite);
		$this -> error_page_list = $error_page_list;

		$this -> indexs -> log_insert($this -> top_notice . $this -> notice);
		$this -> _view('host');
	}


	// php参数配置
	function php_setparam()
	{
		$this -> title = 'PHP Parameter settings - Virtual Hosts - AMH';
		$this -> AmysqlModelBase();
		Functions::CheckLogin();

		$param_list = array(
			array('Set PHP Timezone','date.timezone', 'Asia/Hong_Kong'),
			array('Display Errors','display_errors', 'On / Off'),
			array('PHP Memory Limit','memory_limit', '68M'),
			array('POST Max Size','post_max_size', '4M'),
			array('Upload Max FileSize','upload_max_filesize', '2M'),
			array('Max file uploads','max_file_uploads', '10'),
			array('Max execution','max_execution_time', '20'),
			array('socket Timeout','default_socket_timeout', '60'),
			array('SESSION Cache Expire','session.cache_expire', '180'),
			array('Open Short Tag','short_open_tag', 'On / Off'),
			array('Open magic_Quotes_gpc','magic_quotes_gpc', 'On / Off'),
			array('Open Magic_Quotes_Runtime','magic_quotes_runtime', 'On / Off')
		);

		if (isset($_POST['submit']))
		{
			foreach ($param_list as $key=>$val)
			{
				$post_keyname = str_replace('.', '_', $val[1]);
				$cmd = "amh SetParam php $val[1] {$_POST[$post_keyname]}";
				$cmd = Functions::trim_cmd($cmd . ' noreload');		// 只更改参数不Reload
				exec($cmd, $tmp, $status);
			}

			if (!$status)
			{
				$this -> status = 'success';
				$this -> notice = 'PHP Setting  Change Successful.';
			}
			else
			{
				$this -> status = 'error';
				$this -> notice = 'PHP Setting  Change Failed.';
			}
		}
		
		$param_list = $this -> hosts -> get_php_param($param_list);
		$this -> param_list = $param_list;
		$this -> indexs -> log_insert($this -> top_notice . $this -> notice);
		$this -> _view('host_php_setparam');
	}

}

?>