<?php include('header.php'); ?>
<script src="View/js/My97DatePicker/WdatePicker.js"></script>

<div id="body">
<?php 
$c_name = 'account';
include('category_list.php'); 
?>

<p>管理員操作記錄:</p>
<form action="" method="GET">
<input type="hidden" value="account_log" name="a"/>
<input type="hidden" value="account" name="c"/>
搜索 <select id="field" name="field" style="width:100px;">
<option value="1">日誌內容</option>
<option value="0">用戶名</option>
<option value="2">IP</option>
</select>
<script>G('field').value = '<?php echo isset($_GET['field']) ? $_GET['field'] : '1';?>';</script>
<input type="text" name="search" class="input_text" style="width:180px;" value="<?php echo isset($_GET['search']) ? $_GET['search'] : '';?>" /> 
&nbsp; 時間 <input class="Wdate" type="text" name="start_time" onFocus="WdatePicker({isShowClear:false})" value="<?php echo isset($_GET['start_time']) ? $_GET['start_time'] : '';?>"/> 至 
<input class="Wdate" type="text" name="end_time"  onFocus="WdatePicker({isShowClear:false})" value="<?php echo isset($_GET['end_time']) ? $_GET['end_time'] : '';?>"/>&nbsp;
<button type="submit" class="primary button" >搜索</button> 
</form>

<table border="0" cellspacing="1"  id="STable" style="width:auto;">
	<tr>
	<th>&nbsp;ID&nbsp;</th>
	<th width="50">用戶</th>
	<th>操作</th>
	<th width="110">操作IP</th>
	<th width="130">操作時間</th>
	</tr>
<?php
	foreach ($log_list['data'] as $key=>$val)
	{
?>
	<tr>
	<th class="i"><?php echo $val['log_id'];?></th>
	<td><?php echo !empty($val['user_name']) ? $val['user_name'] : '<i style="font-size:12px">AMH系統</i>';?></td>
	<td width="500">&nbsp; <?php echo nl2br($val['log_text']);?> &nbsp; </td>
	<td><?php echo $val['log_ip'];?></td>
	<td><?php echo $val['log_time'];?></td>
	</tr>
<?php
	}
?>
</table>
<div id="page_list">总<?php echo $total_page;?>頁 - <?php echo $log_list['sum'];?>記錄 » 頁碼 <?php echo htmlspecialchars_decode($page_list);?> </div>
<br />

</div>
<?php include('footer.php'); ?>