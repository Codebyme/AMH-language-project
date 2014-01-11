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

<script>
var submit_backup = function (type)
{
	if(type == 'button' )
		G('backup_now_form').submit();
	G('submit_backup_button').innerHTML = '備份提交中…';
	G('submit_backup_button').disabled = true;
}
</script>

<?php
	if (!empty($notice)) echo '<div style="margin:5px 2px;width:500px;"><p id="' . $status . '">' . $notice . '</p></div>';
?>
<p>即时備份:</p>
<table border="0" cellspacing="1"  id="STable" style="width:800px;">
	<tr>
	<th>立刻創建數據備份</th>
	</tr>
	<tr>
	<td class="td_block">
	<form action="index.php?c=backup&a=backup_now" method="POST"  id="backup_now_form" onsubmit="return submit_backup('submit')" />
	本地或遠程備份選擇  <?php echo $_SESSION['amh_config']['DataPrivate']['config_value'] == 'on' ? '(當前已開啟面板數據私有保護/ 面板遠程備份功能已關閉)' : '' ?><br />
	<select id="backup_retemo" name="backup_retemo">
<option value="n">只備份到本地</option>
<option value="Y">只備份到遠程</option>
<option value="y">同時備份到本地與遠程</option>
	</select><br />
	<script> 
	G('backup_retemo').value = '<?php echo isset($_POST['backup_retemo']) ? $_POST['backup_retemo'] : 'n';?>';
	</script>
	備份选项<br />
	<select id="backup_options" name="backup_options">
<option value="y">面板數據全面備份</option>
<option value="N">不備份數據庫數據(MySQL)</option>
<option value="n">不備份網站數據文件(wwwroot)</option>
	</select>
	<script>
	G('backup_options').value = '<?php echo isset($_POST['backup_options']) ? $_POST['backup_options'] : 'y';?>';
	</script>
	<br /><br />
	備份文件加密設置密碼<br />
	<input type="password" class="input_text" name="backup_password" value="<?php echo isset($_POST['backup_password']) ? $_POST['backup_password'] : '';?>" /> (留空即不設置密碼) <br />
確認密碼<br />
	<input type="password" class="input_text" name="backup_password2" value="<?php echo isset($_POST['backup_password2']) ? $_POST['backup_password2'] : '';?>" /> <br />

	添加備註<br />
	<input type="text" class="input_text" name="backup_comment" value="<?php echo isset($_POST['backup_comment']) ? $_POST['backup_comment'] : '';?>" /> (備註可不填寫) <br /> 
	<button type="button" class="primary button" onclick="submit_backup('button');" id="submit_backup_button" ><span class="check icon"></span>備份</button> 
	<input type="hidden" name="backup_now" value="y"/>
	</form>
	</td>
	</tr>
</table>
<br />

<div id="notice_message" style="width:660px;">
<h3>» 即時備份</h3>
1) 如使用遠程備份數據同時會傳輸至遠程設置的FTP/SSH服務器(需設置開啟狀態)。 <br />
2) 建議設置密碼備份數據，同時密碼不可找回，請牢記備份密碼。 <br />
3) 面板配置如果開啟面板數據私有保護，面板遠程備份功能將自動關閉。 <br />

<h3>» SSH 即時備份</h3>
<ul>
<li>查看備份文件: amh ls_backup </li>
<li>備份命令: amh backup [n/Y/y 遠程備份] [y/N/n 備份選項] [密碼/n] [備註]</li>
<li>遠程備份參數說明：n 只備份到本地、Y 只備份到遠程、y 同時備份到本地與遠程
<li>備份選項參數說明：y 面板數​​據全面備份、N 不備份數據庫數據(MySQL)、n 不備份網站數據文件(wwwroot)
</ul>
使用示例:<br />
本地備份: amh backup<br />
本地與遠程備份: amh backup y<br />
只遠程備份與不備份網站文件: amh backup Y n<br />
本地與遠程全面數據備份並設置密碼: amh backup yy amh_password<br />
本地備份與添加備註: amh backup nyn 2012backup<br />
</div>
</div>
<?php include('footer.php'); ?>
