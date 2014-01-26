<?php

/************************************************
 * Amysql Host - AMH 4.2
 * Amysql.com 
 * @param Object config 面板配置控制器
 * Update:2013-11-01
 * 
 */

class config extends AmysqlController
{
	public $indexs = null;
	public $configs = null;
	public $notice = null;
	public $top_notice = null;

	// 载入数据模型(Model)
	function AmysqlModelBase()
	{
		if($this -> indexs) return;
		$this -> _class('Functions');
		$this -> indexs = $this ->  _model('indexs');
		$this -> configs = $this ->  _model('configs');
	}

	// 默认访问
	function IndexAction()
	{
		$this -> config_index();
	}

	// 面板配置
	function config_index()
	{
		$this -> title = 'Panel configuration - AMH';
		$this -> AmysqlModelBase();
		Functions::CheckLogin();

		if (isset($_POST['submit']))
		{
			$this -> status = 'error';

			$_POST['LoginErrorLimit'] = (int)$_POST['LoginErrorLimit'];
			$_POST['AMHListen'] = (int)$_POST['AMHListen'];
			if(empty($_POST['LoginErrorLimit'])) $_POST['LoginErrorLimit'] = 1;
			if(!isset($_POST['HelpDoc'])) $_POST['HelpDoc'] = 'no';
			if(!isset($_POST['VerifyCode'])) $_POST['VerifyCode'] = 'no';
			if(!isset($_POST['OpenCSRF'])) $_POST['OpenCSRF'] = 'no';
			if(!isset($_POST['OpenMenu'])) $_POST['OpenMenu'] = 'no';

			$up_status = $this -> configs -> up_amh_config();
			if($up_status)
			{
				$status = 'success';
				$this -> notice = 'System Configuration Successfully Changed.';
			}
			else
				$this -> notice = 'System Configuration Change failed.';
		}

		$AMHDomain_text = ($_POST['AMHDomain'] == 'Off') ? $_SERVER['SERVER_ADDR'] : $_POST['AMHDomain'];
		if ($_POST['AMHListen'] != $_POST['AMHListen_old'] || ($_POST['AMHDomain'] != 'Off' && $_POST['AMHDomain'] != $_POST['AMHDomain_old']))
			$this -> notice .= "Panel allows domain or port has changed, please use{$AMHDomain_text}:{$_POST['AMHListen']} Access.";
		
		$amh_config = $this -> configs -> get_amh_config();
		if($status == 'success')
		{
			$_SESSION['amh_config'] = $amh_config;
			$this -> status = $status;
		}
		$this -> amh_config = $amh_config;
		$this -> amh_domain_list = $this -> configs -> get_amh_domain_list();
		
		$this -> indexs -> log_insert($this -> notice);
		$this -> category = $category;
		$this -> _view('config_index');
	}

	// 面板升级
	function config_upgrade()
	{
		$this -> title = 'Online Upgrade - AMH';
		$this -> AmysqlModelBase();
		Functions::CheckLogin();

		if (isset($_GET['install']))
		{
			set_time_limit(0);
			$UpgradeName = $_GET['install'];
			$this -> UpgradeName = $UpgradeName;
			$this -> _view('config_upgrade_ing');
			$cmd = "amh upgrade $UpgradeName install";
			$cmd = Functions::trim_cmd($cmd);
			$popen_handle = popen($cmd, 'r');
			$i = 0;
			echo '<div id="show_result">';
			while(!feof($popen_handle))
			{
				$line = fgets($popen_handle);
				echo $line . '<br />';
				if($i%5 == 0) echo "<script>amh_cmd_ing();</script>\n";
				++$i;
			}
			$upgrade_ing_status = json_encode((pclose($popen_handle)));
			$result_status = (!$upgrade_ing_status) ? true : false;
			echo "<script>amh_cmd_ing();upgrade_ing_status = {$upgrade_ing_status};upgrade_end();</script>$line</div>";

			if ($result_status)
			{
				$this -> status = 'success';
				$this -> notice = "$UpgradeName Upgrade updated successfully.";
			}
			else
			{
				$this -> status = 'error';
				$this -> notice = "$UpgradeName Upgrade update failed.";
			}

			$this -> indexs -> log_insert($this -> notice);
			exit();
		}

		$upgrade_list = $this -> configs -> get_upgrade_list();
		$this -> upgrade_list = $upgrade_list;
		$this -> _view('config_upgrade');
	}

	// 更新提示
	function upgrade_notice()
	{
		$this -> AmysqlModelBase();
		Functions::CheckLogin();
		$upgrade_sum = $this -> configs -> get_upgrade_notice();
		echo (int)$upgrade_sum;
	}

}

?>