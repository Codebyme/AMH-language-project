<?php include('header.php'); ?>

<style>
#STable td.td_block {
	padding:10px 20px;
	text-align:left;
	line-height:23px;
}
td i {
	font-style: normal;
	color: rgb(152, 156, 158);
}
</style>
<div id="body">
<?php 
$c_name = 'backup';
include('category_list.php'); 
?>

<script src="View/js/backup_remote.js"></script>
<?php
	if (!empty($top_notice)) echo '<div style="margin:5px 2px;width:500px;"><p id="' . $status . '">' . $top_notice . '</p></div>';
?>

<p>遠程備份設置:</p>
<table border="0" cellspacing="1"  id="STable" style="width:1080px;">
	<tr>
	<th>&nbsp;ID&nbsp;</th>
	<th>類型</th>
	<th>狀態</th>
	<th>遠程IP域名 / 目地</th>
	<th>保存路徑 / 位置</th>
	<th>帳號 / ID</th>
	<th>帳號驗證</th>
	<th>密碼 / 密匙</th>
	<th>說明備註</th>
	<th>添加時間</th>
	<th>操作</th>
	</tr>
	<?php 
	if(!is_array($remote_list) || count($remote_list) < 1)
	{
	?>
		<tr><td colspan="11" style="padding:10px;">暂无遠程備份設置</td></tr>
	<?php	
	}
	else
	{
		$remote_pass_type_arr = array(
			'1'	=> '密碼',
			'2' => '<font color="green">密匙</font>',
			'3' => '<i>无</i>'
		);
		foreach ($remote_list as $key=>$val)
		{
	?>
			<tr>
			<th class="i"><?php echo $val['remote_id'];?></th>
			<td><?php echo $val['remote_type'];?></td>
			<td><?php echo $val['remote_status'] == '1' ? '<font color="green">已開啟</font>' : '<font color="red">已關閉</font>';?></td>
			<td><?php echo $val['remote_ip'];?></td>
			<td><?php echo !empty($val['remote_path']) ? $val['remote_path'] : '<i>无</i>';?></td>
			<td><?php echo !empty($val['remote_user']) ? $val['remote_user'] : '<i>无</i>';?></td>
			<td><?php echo $remote_pass_type_arr[$val['remote_pass_type']];?></td>
			<td><?php echo $val['remote_pass_type'] != '3' ? '******' : '<i>无</i>';?></td>
			<td><?php echo !empty($val['remote_comment']) ? $val['remote_comment'] : '<i>无</i>';?></td>
			<td><?php echo $val['remote_time'];?></td>
			<td>
			<?php if (in_array($val['remote_type'], array('FTP', 'SSH'))) { ?>
			<a href="index.php?c=backup&a=backup_remote&check=<?php echo $val['remote_id'];?>" class="button" onclick="return connect_check(this);"><span class="loop icon"></span>連接測試</a>
			<a href="index.php?c=backup&a=backup_remote&edit=<?php echo $val['remote_id'];?>" class="button"><span class="pen icon"></span>編輯</a>
			<a href="index.php?c=backup&a=backup_remote&del=<?php echo $val['remote_id'];?>" class="button" onclick="return confirm('確認删除遠程備份設置ID:<?php echo $val['remote_id'];?>?');"><span class="cross icon"></span>刪除</a>
			<?php } else { ?>
				<a href="javascript:;" class="button disabled"><span class="loop icon"></span>連接測試</a>
				<a href="javascript:;" class="button disabled"><span class="pen icon"></span>編輯</a>
				<a href="javascript:;" class="button disabled"><span class="cross icon"></span>删除</a>
			<?php } ?>
			</td>
			</tr>
	<?php
		}
	}
	?>
</table>
<br /><br />


<?php
	if (!empty($notice)) echo '<div style="margin:5px 2px;width:500px;"><p id="' . $status . '">' . $notice . '</p></div>';
?>

<p>
<?php echo isset($edit_remote) ? '編輯' : '新增';?>遠程備份設置:<?php echo isset($edit_remote) ? 'ID' . $_POST['remote_id'] : '';?>
</p>
<form action="index.php?c=backup&a=backup_remote" method="POST"  id="remote_edit" onsubmit="return remote_pass_type_fun(G('remote_pass_type_dom'));"/>
<table border="0" cellspacing="1"  id="STable" style="width:700px;">
	<tr>
	<th> &nbsp; </th>
	<th>值</th>
	<th>說明 </th>
	</tr>

	<tr><td>類型</td>
	<td>
	<select id="remote_type_dom" name="remote_type" onchange="remote_type_fun(this);">
	<option value="FTP">FTP</option>
	<option value="SSH">SSH</option>
	</select>
	<?php if(isset($_POST['remote_type'])) {?>
	<script>G('remote_type_dom').value = '<?php echo $_POST['remote_type'];?>';</script>
	<?php }?>
	</td>
	<td><p> &nbsp; <font class="red">*</font> 遠程備份類型</p></td>
	</tr>

	<tr><td>是否啟用	</td>
	<td>
	<select id="remote_status_dom" name="remote_status">
	<option value="1">開啟</option>
	<option value="2">關閉</option>
	</select>
	<?php if(isset($_POST['remote_status'])) {?>
	<script>G('remote_status_dom').value = '<?php echo $_POST['remote_status'];?>';</script>
	<?php }?>
	</td>
	<td><p> &nbsp; <font class="red">*</font> 是否启用</p></td>
	</tr>

	<tr><td>IP/域</td>
	<td><input type="text" name="remote_ip" class="input_text" value="<?php echo $_POST['remote_ip'];?>" /></td>
	<td><p> &nbsp; <font class="red">*</font> 備份主機的IP或是域名</p></td>
	</tr>

	<tr><td>保存路徑	</td>
	<td><input type="text" name="remote_path" class="input_text" value="<?php echo $_POST['remote_path'];?>" /></td>
	<td><p> &nbsp; <font class="red">*</font> 傳送至遠程保存的路徑</p></td>
	</tr>

	<tr><td>帳號	</td>
	<td><input type="text" name="remote_user" class="input_text" value="<?php echo $_POST['remote_user'];?>" /></td>
	<td><p> &nbsp; <font class="red">*</font> 帳號</p></td>
	</tr>

	<tr><td>帳號驗證	</td>
	<td>
	<select id="remote_pass_type_dom" name="remote_pass_type" onchange="remote_pass_type_fun(this)">
	</select>
	</td>
	<td><p> &nbsp; <font class="red">*</font> 帳號驗證方式</p></td>
	</tr>

	<tr><td>密碼/密匙</td>
	<td>
		<input id="remote_password1" type="password" class="input_text" name="remote_pass1" value="<?php  echo isset($_POST['remote_pass1']) ? $_POST['remote_pass1'] : '';?>" />
		<textarea id="remote_password2" name="remote_pass2"><?php  echo isset($_POST['remote_pass2']) ? $_POST['remote_pass2'] : '';?></textarea>
		<textarea id="remote_password" name="remote_password" style="display:none;"></textarea>
		<script>remote_type_fun(G('remote_type_dom'));</script>
		<?php if(isset($_POST['remote_pass_type'])) {?>
		<script>G('remote_pass_type_dom').value = '<?php echo $_POST['remote_pass_type'];?>';</script>
		<?php }?>
		<script>remote_pass_type_fun(G('remote_pass_type_dom'));</script>
	</td>
	<td>
		<?php if (!isset($edit_remote)) { ?>
			<p> &nbsp; <font class="red">*</font> 驗證帳號使用的密碼或密匙</p> 
		<?php } else {?> 
			<p> &nbsp; 密碼/密匙劉空將不做更改</p>
		 <?php }?>
	</td>
	</tr>

	<tr><td>說明備註	</td>
	<td><input type="text" name="remote_comment" class="input_text" value="<?php echo $_POST['remote_comment'];?>" /></td>
	<td><p> &nbsp;  添加說明備註</p></td>
	</tr>
	
</table>

<?php if (isset($edit_remote)) { ?>
	<input type="hidden" name="save_edit" value="<?php echo $_POST['remote_id'];?>" />
<?php } else { ?>
	<input type="hidden" name="save" value="y" />
<?php }?>

<button type="submit" class="primary button" name="submit"><span class="check icon"></span>保存</button> 
</form>


<div id="notice_message" style="width:660px;">
<h3>» 遠程備份</h3>
1) 建議使用SSH密匙方式遠程備份，數據加密傳輸、與不需使用明文密碼。 <br />
2) 設置完成點擊連接測試進行檢測，可測試遠程賬號、網絡是否能正常連接。 <br />
<br />
SSH密匙獲取方法：<br />
<ul>
<li>1) SSH登錄到用於遠程備份的Linux主機。 </li>
<li>2) 執行命令ssh-keygen -t rsa &nbsp; (按三次回車使用默認配置完成生成密鑰文件)</li>
<li>3) 執行命令cd /root/.ssh/ &nbsp; (進入密鑰目錄，本示例命令為root賬號，如用其它賬號進對應的密鑰目錄即可)
<li>3) 執行命令mv id_rsa.pub authorized_keys &nbsp; (完成公匙重命名)</li>
<li>4) 執行命令more id_rsa &nbsp; (查看id_rsa密鑰，選中文件中的所有內容複製)</li>
<li>5) 回到面板，添加遠程設置，粘貼到密碼/密匙文本框即完成。 </li>
</ul>


<h3>» SSH 遠程備份</h3>
<ul>
<li>FTP連接測試: amh BRftp check [ID] </li>
<li>FTP傳輸遠程數據: amh BRftp post [/home/backup 文件名] </li>
<li>SSH連接測試: amh BRssh check [ID] </li>
<li>SSH傳輸遠程數據: amh BRssh post [/home/backup 文件名] </li>
</ul>
</div>
</div>
<?php include('footer.php'); ?>