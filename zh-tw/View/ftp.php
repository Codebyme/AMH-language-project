<?php include('header.php'); ?>
<script src="View/js/ftp.js"></script>


<div id="body">
<?php 
$c_name = 'ftp';
include('category_list.php'); 
?>

<?php
	if (!empty($top_notice)) echo '<div style="margin:5px 2px;width:500px;"><p id="' . $status . '">' . $top_notice . '</p></div>';
?>
<p>FTP賬號列表:</p>
<table border="0" cellspacing="1"  id="STable" style="width:auto;min-width: 700px;">
	<tr>
	<th>&nbsp;ID&nbsp;</th>
	<th>賬號</th>
	<th width="60">密碼</th>
	<th>根目录</th>
	<th width="60">目錄所屬<br />權限用户</th>
	<th width="60">FTP賬號<br />權限用户</th>
	<th>所屬组</th>
	<th width="125">添加時間</th>
	<th>操作</th>
	</tr>
	<?php 
	if(!is_array($ftp_list) || count($ftp_list) < 1)
	{
	?>
		<tr><td colspan="9" style="padding:10px;">暂无FTP賬號</td></tr>
	<?php	
	}
	else
	{
		foreach ($ftp_list as $key=>$val)
		{
	?>
			<tr>
			<th class="i"><?php echo $val['ftp_id'];?></th>
			<td><?php echo $val['ftp_name'];?></td>
			<td>******</th>
			<td><?php echo $val['ftp_root'];?></td>
			<td><?php echo $val['ftp_directory_uname'];?></td>
			<td><?php echo $val['ftp_uid_name'];?></td>
			<td><?php echo $val['ftp_type'];?></td>
			<td><?php echo $val['ftp_time'];?></td>
			<td>
			<?php if($val['ftp_type'] == 'ssh') { ?>
			<a href="javascript:" class="button disabled"><span class="pen icon disabled"></span> 編輯</a>
			<a href="javascript:" class="button disabled"><span class="key icon disabled"></span> 重寫目錄權限</a>
			<a href="javascript:" class="button disabled"><span class="cross icon disabled"></span> 刪除</a>
			<?php } else {?>
			<a href="index.php?c=ftp&a=ftp_list&edit=<?php echo urlencode($val['ftp_name']);?>" class="button"><span class="pen icon"></span> 編輯</a>
			<a href="index.php?c=ftp&a=ftp_list&chown=<?php echo urlencode($val['ftp_name']);?>&uidname=<?php echo $val['ftp_uid_name'];?>" class="button"  onclick="return confirm('確認遞歸重寫目錄:<?php echo $val['ftp_root'];?>\n\n为FTP賬號的<?php echo $val['ftp_uid_name'];?>用戶權限嗎？?');"><span class="key icon"></span> 重寫目錄權限</a>
			<a href="index.php?c=ftp&a=ftp_list&del=<?php echo urlencode($val['ftp_name']);?>" class="button" onclick="return confirm('確認刪除FTP賬號:<?php echo $val['ftp_name'];?>?');"><span class="cross icon"></span> 刪除</a>

			<?php } ?>
<a title="AMFTP-2.0" href="./AMFTP-2.0/index.php?ftp_user=<?php echo $val['ftp_name'];?>" class="button" title="AMFTP" target="_blank"><span class="cog icon"></span> 管理</a>
			</td>
			</tr>
	<?php
		}
	}
	?>
</table>
<br />
<br />

<?php
	if (!empty($notice)) echo '<div style="margin:5px 2px;width:500px;"><p id="' . $status . '">' . $notice . '</p></div>';
?>

<p>
<?php echo isset($edit_ftp) ? '編輯' : '新增';?>FTP賬號:<?php echo isset($edit_ftp) ? $_POST['ftp_name'] : '';?>
</p>
<form action="index.php?c=ftp&a=ftp_list" method="POST"  id="ftp_edit" />
<table border="0" cellspacing="1"  id="STable" style="width:750px;">
	<tr>
	<th> &nbsp; </th>
	<th>參數值</th>
	<th>说明 [<a href="javascript:;" onclick="ShowFtpTop()">打開 / 關閉 高級選項</a>] </th>
	</tr>
	<tr><td>账号</td>
	<td><input type="text" name="ftp_name" class="input_text <?php echo isset($edit_ftp) ? ' disabled' : '';?>" value="<?php echo $_POST['ftp_name'];?>" <?php echo isset($edit_ftp) ? 'disabled=""' : '';?> style="width:298px"/></td>
	<td><p> &nbsp; <font class="red">*</font> 登錄FTP賬號</p></td>
	</tr>
	<tr><td>密碼</td>
	<td><input type="password" name="ftp_password" class="input_text" value="<?php echo $_POST['ftp_password'];?>"  style="width:298px"/></td>
	<td><p> &nbsp; <font class="red">*</font> 登錄FTP密碼 <?php echo isset($edit_ftp) ? ' [不更改密碼請留空]' : '';?></p></td>
	</tr>
	<tr><td>主機根目錄</td>
	<td>
	<select name="ftp_root" id="ftp_root">
	<option value="">请選擇虛擬主機根目錄</option>
	<?php
		foreach ($dirs as $key=>$val)
		{
			if($val != 'index')
				echo '<option value="' . $val . '">/home/wwwroot/' . $val . '/web</option>';
		}
	?>
	</select>
	<script>
	G('ftp_root').value = '<?php echo isset($_POST['ftp_root']) ? $_POST['ftp_root'] : '';?>';
	</script>
	</td>
	<td><p> &nbsp; <font class="red">*</font> FTP根目錄</p></td>
	</tr>
	<tr><td>權限用戶</td>
	<td>
	<select name="ftp_uid_name" id="ftp_uid_name">
	<option value="www">www</option>
	<option value="ftpuser">ftpuser</option>
	</select>
	<script>
	G('ftp_uid_name').value = '<?php echo isset($_POST['ftp_uid_name']) ? $_POST['ftp_uid_name'] : 'www';?>';
	</script>
	</td>
	<td><p> &nbsp; <font class="red">*</font> FTP賬號所屬的權限用户</p></td>
	</tr>
	<tr class="ftptop none"><td>上傳速度限制</td>
	<td><input type="text" name="ftp_upload_bandwidth"  class="input_text" value="<?php echo isset($_POST['ftp_upload_bandwidth']) ? $_POST['ftp_upload_bandwidth'] : '';?>" />
	<input type="checkbox" id="checkbox_ftp_upload_bandwidth"  name="_ftp_upload_bandwidth"/>
	<label for="checkbox_ftp_upload_bandwidth">不限制</label>
	</td>
	<td><p> &nbsp; 限制FTP上傳速度 [KB]</p></td>
	</tr>
	<tr class="ftptop none"><td>下載速度限制</td>
	<td>
	<input type="text" name="ftp_download_bandwidth"  class="input_text" value="<?php echo isset($_POST['ftp_download_bandwidth']) ? $_POST['ftp_download_bandwidth'] : '';?>" />
	<input type="checkbox" id="checkbox_ftp_download_bandwidth"  name="_ftp_download_bandwidth"/>
	<label for="checkbox_ftp_download_bandwidth" >不限制</label>
	</td>
	<td><p> &nbsp; 限制FTP下載速度  [KB]</p></td>
	</tr>
	<tr class="ftptop none"><td>上传比率值</td>
	<td><input type="text" name="ftp_upload_ratio" class="input_text" value="<?php echo isset($_POST['ftp_upload_ratio']) ? $_POST['ftp_upload_ratio'] : '';?>" />
	<input type="checkbox" id="checkbox_ftp_upload_ratio"  name="_ftp_upload_ratio"/>
	<label for="checkbox_ftp_upload_ratio" >不限制</label>
	</td>
	<td><p> &nbsp; 設置上传比率值 </p></td>
	</tr>
	<tr class="ftptop none"><td>下載比率值</td>
	<td>
	<input type="text" name="ftp_download_ratio" id="" class="input_text" value="<?php echo isset($_POST['ftp_download_ratio']) ? $_POST['ftp_download_ratio'] : '';?>" />
	<input type="checkbox" id="checkbox_ftp_download_ratio"  name="_ftp_download_ratio"/>
	<label for="checkbox_ftp_download_ratio" >不限制</label>
	</td>
	<td><p> &nbsp; 設置下载比率值 </p></td>
	</tr>
	<tr class="ftptop none"><td>文件數量</td>
	<td><input type="text" name="ftp_max_files"  class="input_text" value="<?php echo isset($_POST['ftp_max_files']) ? $_POST['ftp_max_files'] : '';?>" />
	<input type="checkbox" id="checkbox_ftp_max_files"  name="_ftp_max_files"/>
	<label for="checkbox_ftp_max_files" >不限制</label>
	</td>
	<td><p> &nbsp; 限制FTP文件个數</p></td>
	</tr>
	<tr class="ftptop none"><td>容量</td>
	<td><input type="text" name="ftp_max_mbytes"  class="input_text" value="<?php echo isset($_POST['ftp_max_mbytes']) ? $_POST['ftp_max_mbytes'] : '';?>" />
	<input type="checkbox" id="checkbox_ftp_max_mbytes"  name="_ftp_max_mbytes"/>
	<label for="checkbox_ftp_max_mbytes" >不限制</label>
	</td>
	<td><p> &nbsp; 限制FTP空間容量 [MB]</p></td>
	</tr>
	<tr class="ftptop none"><td>鏈接數限制</td>
	<td><input type="text" name="ftp_max_concurrent" class="input_text" value="<?php echo isset($_POST['ftp_max_concurrent']) ? $_POST['ftp_max_concurrent'] : '';?>" />
	<input type="checkbox" id="checkbox_ftp_max_concurrent"  name="_ftp_max_concurrent"/>
	<label for="checkbox_ftp_max_concurrent" >不限制</label>
	</td>
	<td><p> &nbsp; 限制同時鏈接FTP数</p></td>
	</tr>
	<tr class="ftptop none"><td>使用時間限制</td>
	<td><input type="text" name="ftp_allow_time"  class="input_text" value="<?php echo isset($_POST['ftp_allow_time']) ? $_POST['ftp_allow_time'] : '';?>" />
	<input type="checkbox" id="checkbox_ftp_allow_time"  name="_ftp_allow_time"/>
	<label for="checkbox_ftp_allow_time">不限制</label>
	</td>
	<td><p> &nbsp; 限制只能在允許時間段内鏈接FTP</p>
	<p> &nbsp; 格式：小時分鐘-小時分鐘</p></td>
	</tr>
</table>

<?php if (isset($edit_ftp)) { ?>
	<input type="hidden" name="save_edit" value="<?php echo $_POST['ftp_name'];?>" />
	<script>ShowFtpTop();</script>
<?php } else { ?>
	<input type="hidden" name="save" value="y" />
<?php }?>

<button type="submit" class="primary button" name="submit"><span class="check icon"></span>保存</button> 
</form>


<div id="notice_message" style="width:890px">
<h3>» WEB FTP</h3>
1) web添加的FTP賬號根目錄只允許為虛擬主機的根目錄。 <br />
2) ssh添加的FTP賬號web端不可刪除與編輯。 <br />
3) 關於FTP權限用戶: 虛擬主機首次添加FTP賬號時系統會自動重寫FTP目錄為相應的用戶權限。 <br />
面板PHP為www權限用戶。如FTP賬號使用www權限，PHP將擁有FTP賬號根目錄下所有文件的讀寫操作。 <br />
如FTP賬號使用ftpuser權限用戶，PHP將不能寫文件操作，安裝程序時程序要求讀寫的目錄再手動改為www:www用戶或使用FTP改為777權限即可。

<h3>» SSH FTP</h3>
1) 有步驟提示操作: <br />
ssh執行命令: amh ftp <br />
然後選擇對應的1~7的選項進行操作。 <br />

2) 或直接操作: <br />
<ul>
<li>查看FTP列表: amh ftp list </li>
<li>增加FTP用戶: amh ftp add [賬號] [密碼] [根目錄] [上傳速度限制] [下載速度限制] [上傳比率值] [下載比率值] [文件數量] [容量] [連接並發數] [使用時間限制] [權限用戶]</li>
<li>編輯FTP用戶: amh ftp edit [賬號] [-] [根目錄] [上傳速度限制] [下載速度限制] [下載比率值] [下載比率值] [文件數量] [容量] [連接並發數] [使用時間限制] [權限用戶]
<li>更改FTP密碼: amh ftp pass [賬號] [密碼]
<li>重寫FTP目錄權限: amh ftp chown [賬號] [y/n]
<li>刪除ftp用戶: amh ftp del [賬號]</li>
</ul>

溫馨提示:<br />
增加或編輯賬號忽略參更改某一參數請填寫0，不做限制請填寫-符號。 <br />
例如: amh ftp add testftp testpass /home/wwwroot 0 100 <br />
以上命令為增加ftp用戶，賬號為testftp密碼為testpass，ftp根目錄為/home/wwwroot，忽略更改上傳速度參數、限制下載速度為100kb。 <br />
</div>

</div>
<?php include('footer.php'); ?>
