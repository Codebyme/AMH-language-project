<?php include('header.php'); ?>
<script>
var mysql_password_submit = function ()
{
	if (G('user_action').value == 'pass')
	{
		if(G('user_password1').value == '')
			return confirm('確認更改用戶為無密碼嗎?');
	}
	else
	{
	    return confirm('確認刪除用戶嗎?');
	}
	return true;
}
var user_action_show = function ()
{
	var tr = getElementByClassName('mysqlPW', 'tr');
	for (var k in tr)
		tr[k].className = (G('user_action').value == 'pass') ? 'mysqlPW':'mysqlPW none';
}
</script>

<div id="body">
<?php 
$c_name = 'mysql';
include('category_list.php'); 
?>

<?php
	if (!empty($notice)) echo '<div style="margin:5px 2px;width:500px;"><p id="' . $status . '">' . $notice . '</p></div>';
?>
<p>修改MySQL數據庫用戶密碼:</p>
<form action="" method="POST"  id="mysql_password" onsubmit="return mysql_password_submit();">
<table border="0" cellspacing="1"  id="STable" style="width:auto;">
	<tr>
	<th width="130"></th>
	<th width="280">值</th>
	<th>說明</td>
	</tr>
	
	<tr>
	<td>選擇用戶 - 鏈接地址</td>
	<td>
	<select name="user_name" id="user_name" style="width: 190px;">
	<?php
	foreach ($mysql_user_list as $key=>$val)
	{?>
		<option value="<?php echo $key;?>"><?php echo $val['User'];?> - <?php echo $val['Host'];?></option>
	<?php } ?>
	</select>
	<script>G('user_name').value = '<?php echo isset($_POST['user_name']) ? $_POST['user_name'] : '0';?>';</script>
	</td>
	<td class="description">選擇需要操作的MySQL用戶</td>
	</tr>
	<tr>
	<td>修改密碼或刪除</td>
	<td>
	<select name="user_action" id="user_action" style="width: 190px;" onchange="user_action_show()">
	<option value="pass">修改用戶密碼</option>
	<option value="del">刪除用戶</option>
	</select>
	<script>G('user_action').value = '<?php echo isset($_POST['user_action']) ? $_POST['user_action'] : 'pass';?>';</script>
	</td>
	<td class="description">選擇修改用戶密碼或是刪除用戶</td>
	</tr>
	<tr class="mysqlPW">
	<td>新密碼</td>
	<td><input type="password" name="user_password1" id="user_password1" class="input_text" value="<?php echo isset($_POST['user_password1']) ? $_POST['user_password1'] : '';?>"></td>
	<td class="description">填寫新密碼，不填即無密碼</td>
	</tr>
	<tr class="mysqlPW">
	<td>確認新密碼</td>
	<td><input type="password" name="user_password2" id="user_password2" class="input_text" value="<?php echo isset($_POST['user_password2']) ? $_POST['user_password2'] : '';?>"></td>
	<td class="description">再次輸入新密碼</td>
	</tr>
	</table>
	<input type="hidden" value="<?php echo base64_encode(json_encode($mysql_user_list));?>" name="mysql_user_list" />
<button type="submit" class="primary button" name="submit"><span class="check icon"></span>确认提交</button> 
</form>
<script>
user_action_show();
</script>

<div id="notice_message" style="width:660px;">
<h3>» MySQL 用戶密碼修改</h3>
1) 新密碼如果不填寫密碼，即更改用戶為無密碼。 <br />
2) 面板配置如果開啟面板數據私有保護，面板將不可更改MySQL root 賬號密碼。 <br />
</div>

</div>
<?php include('footer.php'); ?>
