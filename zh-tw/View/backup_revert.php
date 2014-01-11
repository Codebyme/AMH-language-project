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

<?php
$revert_file = isset($revert['backup_file']) ? true : false;
$revert_pass = ($revert_file && strpos($revert['backup_file'], 'tar.gz') === false) ? true : false;
?>

<script>
var backup_revert_submit = function (type)
{
	var pass_required = G('pass_required');
	if (pass_required && pass_required.value == '')
	{
		alert('請輸入密碼。');
		return false;
	}

	if (!confirm('確認還原數據嗎?')) return false;
	G('backup_revert_button').innerHTML = '还還原提交中…';
	G('backup_revert_button').disabled = true;
	if(type == 'button')
		G('backup_revert_from').submit();
	return true;
}
</script>

<?php
	if (!empty($notice)) echo '<div style="margin:5px 2px;width:500px;"><p id="' . $status . '">' . $notice . '</p></div>';
?>

<p>一鍵還原數據:</p>
<form action="" method="POST"  id="backup_revert_from" onsubmit="return backup_revert_submit('submit');"/>
<table border="0" cellspacing="1"  id="STable" style="width:800px;">
	<tr>
	<th>一鍵還原數據</th>
	</tr>
	<tr>
	<td class="td_block">
	備份文件： <?php echo $revert_file ? $revert['backup_file']: '<i>未選擇</i>';?><br />
	數據選項： 
	<?php echo $revert_file ? (
				'全面備份 ' . (strpos($revert['backup_file'], 'n-') !== false ? '<i>(無wwwroot數據)</i>' : (strpos($revert['backup_file'], 'N-') !== false ? '<i>(無MySQL數據)</i>' : '')) 
		): '<i>無記錄</i>';?><br />
	備註說明： <?php echo ($revert_file && !empty($revert['backup_comment']) ) ? $revert['backup_comment']: '<i>無記錄</i>';?><br />
	創建時間： <?php echo $revert_file ? $revert['backup_time']: '<i>無記錄</i>';?><br />
	<br />
	输入密码:<br />
	<input type="password" class="input_text" name="backup_password" <?php echo $revert_pass ? 'id="pass_required"' : '';?> /> (<?php echo $revert_pass ? '有設置密碼 請輸入密碼' : '無需密碼';?>) <br /> 

	<button type="button" class="primary button" onclick="backup_revert_submit('button');" <?php echo $revert_file ?  '' : 'disabled' ;?> id="backup_revert_button"><span class="check icon"></span>確認還原</button> 
	<input type="hidden" name="revert_submit" value="y" />
	</td>
	</tr>
</table>
</form>
<br />


<div id="notice_message" style="width:730px;">
<h3>» 一鍵還原</h3>
1) 從數據備份記錄列表選擇需還原的備份文件。 <br />
2) 還原需謹慎操作，當前AMH面板所有數據： <br />
網站數據，MySQL數據，Nginx、PHP、FTP配置數據與任務計劃、模塊擴展程序將還原至您所選的備份文件數據。 <br />
3) 如有必要請先備份當前數據再進行還原操作。 <br />

<h3>» SSH 一鍵還原</h3>
<ul>
<li>一鍵還原命令: amh revert [/home/backup/備份文件] [備份時設置的密碼]</li>
</ul>
使用示例:<br />
20121101-172607.amh 數據文件還原恢復: amh revert 20121101-172607.amh amh_pass
</div>
<?php if (isset($_POST['revert_submit'])) {?>
<script>
// 面板php与所有虚拟主机php重载
Ajax.get('./index.php?c=host&a=host&run=amh-web&m=php&g=reload&confirm=y');
Ajax.get('./index.php?m=php&g=reload');
</script>
<?php } ?>

</div>
<?php include('footer.php'); ?>