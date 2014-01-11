<?php include('header.php'); ?>
<script src="View/js/host.js"></script>
<style>
#STable th {
	padding:4px 6px;
}
#STable td {
padding: 4px 5px 3px 5px;
_padding: 2px 3px;
}
</style>

<div id="body">
<?php 
$c_name = 'host';
include('category_list.php'); 
?>

<?php 
if(is_array($host_list) && count($host_list) > 0)
	$list_show = true;
?>


<?php
	if (!empty($top_notice)) echo '<div style="margin:5px 2px;width:500px;"><p id="' . $status . '">' . $top_notice . '</p></div>';
?>
<p>虛擬主機列表:</p>
<table border="0" cellspacing="1"  id="STable"  style="width:<?php echo isset($list_show) ? 'auto':'1111px';?>">
	<tr>
	<th>ID</th>
	<th>標識域名</th>
	<th>綁定域名</th>
	<th>網站根目錄<br />/home/wwwroot/</th>
	<th>默認主頁</th>
	<th>Rewrite<br />規則</th>
	<th>自定義<br />錯誤頁面</th>
	<th>訪問<br />日誌</th>
	<th>錯誤<br />日誌</th>
	<th>二級域名<br />綁定子目錄</th>
	<th>PHP-FPM<br />配置</th>
	<th>所屬組</th>
	<th>添加時間</th>
	<th>運行維護</th>
	<th>操作</th>
	</tr>
	<?php 
	if(!isset($list_show))
	{
	?>
		<tr><td colspan="15" style="padding:10px;">暂無虛擬主機</td></tr>
	<?php	
	}
	else
	{
		foreach ($host_list as $key=>$val)
		{
	?>
			<tr>
			<th class="i"><?php echo $val['host_id'];?></th>
			<td><?php echo $val['host_domain'];?></td>
			<td>
			<?php  
				$server_name_arr = explode(',', $val['host_server_name']);
				foreach ($server_name_arr as $v)
				{
					if(strpos($v, '*') !== false) {
						echo $v . '<br />';
					} else {
					?>
					<a href="http://<?php echo $v;?>" target="_blank"><?php echo $v;?></a><br />
			<?php
					}
				}
			?></td>
			<td><?php echo substr($val['host_root'], 14);?></td>
			<td><?php echo str_replace(',' , '<br />', $val['host_index_name']);?></td>
			<td><?php echo empty($val['host_rewrite']) ? '無' : $val['host_rewrite'];?></td>
			<td><?php echo empty($val['host_error_page']) ? '無' : str_replace(',' , '<br />', $val['host_error_page']);?></td>
			<td><?php echo $val['host_log'] == '1' ? '開啟' : '關閉';?></td>
			<td><?php echo $val['host_error_log'] == '1' ? '開啟' : '關閉';?></td>
			<td><?php echo $val['host_subdirectory'] == '1' ? '開啟' : '關閉';?></td>
			<td><?php echo implode('<br />', explode(',', $val['host_php_fpm'], 2));?></td>
			<td><?php echo $val['host_type'];?></td>
			<td><?php echo date('Y-m-d\<\b\r\>H:i:s', strtotime($val['host_time']));?>&nbsp; </td>
			<td>
			<a href="index.php?c=host&a=vhost&run=<?php echo $val['host_domain'];?>&m=host&g=<?php echo $val['host_nginx'] ? 'stop' : 'start';?>" >
			<span <?php echo $val['host_nginx'] ? 'class="run_start" title="主機運行正常"' : 'class="run_stop" title="主機已停止"';?>>Host</span>
			</a>
			<a href="index.php?c=host&a=vhost&run=<?php echo $val['host_domain'];?>&m=php&g=<?php echo $val['host_php'] ? 'stop' : 'start';?>">
				<span <?php echo $val['host_php'] ? 'class="run_start" title="PHP運行正常"' : 'class="run_stop" title="PHP已停止"';?>>PHP</span>
			</a>
			<td>
			<a href="index.php?c=host&a=vhost&edit=<?php echo $val['host_domain'];?>" class="button"><span class="pen icon"></span>編輯</a>
			<a href="index.php?c=host&a=vhost&del=<?php echo $val['host_domain'];?>" class="button" onclick="return confirm('確認刪除虛擬主機:<?php echo $val['host_domain'];?>?');"><span class="cross icon"></span>刪除</a>
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
<?php echo isset($edit_host) ? '編輯' : '新增';?>虛擬主機: <?php echo isset($edit_host) ? $_POST['host_domain'] : '';?>
</p>
<form action="index.php?c=host&a=vhost" method="POST"  id="host_edit" />
<table border="0" cellspacing="1"  id="STable" style="width:950px;">
	<tr>
	<th> &nbsp; </th>
	<th>值</th>
	<th>說明</th>
	</tr>

	<tr><td>主標識域名</td>
	<td><input type="text" id="host_domain" name="host_domain" class="input_text <?php echo isset($edit_host) ? ' disabled' : '';?>" value="<?php echo $_POST['host_domain'];?>" <?php echo isset($edit_host) ? 'disabled=""' : '';?>/></td>
	<td><p> &nbsp; <font class="red">*</font> 用與唯一標識的主域名 </p>
	<p> &nbsp; 不需填寫http:// 格式例如: amysql.com</p>
	</td>
	</tr>

	<tr><td>綁定域名</td>
	<td><input type="text" id="host_server_name" name="host_server_name" class="input_text" value="<?php echo $_POST['host_server_name'];?>" </td>
	<td><p> &nbsp; 主機綁定的域名，多項請用英文逗號分隔</p>
	<p> &nbsp; 例如: amysql.com,www.amysql.com,bbs.amysql.com  </p>
	</td>
	</tr>

	<tr><td>網站根目錄</td>
	<td>/home/wwwroot/<span id="host_root" class="red">主標識域名</span>/web</td>
	<td><p> &nbsp;  網站的根目錄</td>
	</tr>
	<tr><td>主機日誌目錄</td>
	<td>/home/wwwroot/<span id="host_log" class="red">主标识域名</span>/log</td>
	<td><p> &nbsp;  主機訪問與錯誤日誌文件目錄</td>
	</tr>

	<tr><td>默认主页	</td>
	<td><input type="text" name="host_index_name" class="input_text" value="<?php echo isset($_POST['host_index_name']) ? $_POST['host_index_name'] : 'index.html,index.htm,index.php';?>" /></td>
	<td><p> &nbsp;  主機默認的主页，多項請用英文逗號分隔 </p></td>
	</tr>

	<tr><td>Rewrite規則</td>
	<td>
	<select name="host_rewrite" id="host_rewrite">
	<option value="">選擇虛擬Rewrite規則</option>
	<?php
		foreach ($Rewrite as $key=>$val)
			echo '<option value="' . $val . '">' . $val . '</option>';
	?>
	</select>
	<script>
	G('host_rewrite').value = '<?php echo isset($_POST['host_rewrite']) ? $_POST['host_rewrite'] : '';?>';
	</script>
	</td>
	<td><p> &nbsp; URL重寫規則</p><p> &nbsp; Rewrite存放文件夾 /usr/local/nginx/conf/rewrite</p></td>
	</tr>

	<tr><td>自定義錯誤頁面</td>
	<td>
	<?php
		foreach ($error_page_list as $val)
		{ ?>
			<input type="checkbox" name="<?php echo $val[0];?>" id="id_<?php echo $val[0];?>" <?php echo $val[1] ? 'checked=""' : '';?> /> <label for="id_<?php echo $val[0];?>" title="<?php echo $val[2];?>"><?php echo $val[0];?></label>&nbsp;&nbsp; 
	<?php		
		}
	?>
	</td>
	<td>
	<p> &nbsp; 自定義HTTP狀態碼對應的錯誤頁面</p><p> &nbsp; HTML文件存放在網站根目錄ErrorPages文件夾</p>
	</td>
	</tr>

	<tr><td>主機日誌開啟	</td>
	<td>
	<input type="checkbox" name="host_log" id="id_host_log" <?php echo ($_POST['host_log'] == '1') ? ' checked=""' : '';?> /> 
	<label for="id_host_log">訪問日誌</label>
	&nbsp;&nbsp; 
	<input type="checkbox" name="host_error_log" id="id_host_error_log" <?php echo ($_POST['host_error_log'] == '1') ? ' checked=""' : '';?> /> 
	<label for="id_host_error_log">錯誤日誌</label>
	</td>
	<td><p> &nbsp; 是否開啟訪問日誌與錯誤日誌</p></td>
	</tr>

	<tr><td>二级域名綁定子目錄</td>
	<td>
	<input type="checkbox" name="host_subdirectory" id="id_host_subdirectory" <?php echo ($_POST['host_subdirectory'] == '1') ? ' checked=""' : '';?> /> 
	<label for="id_host_subdirectory">開啟綁定</label>
	</td>
	<td><p> &nbsp; 是否開啟二级域名綁定子目錄</p><p> &nbsp; 例如綁定域名:bbs.amysql.com 将自动綁定到網站根目錄/bbs</p></td>
	</tr>

	<tr><td>PHP-FPM設置	</td>
	<td>
	<select id="php_fpm_pm" name="php_fpm_pm" style="width:110px">
		<option value="static">靜態模式</option>
		<option value="dynamic">動態模式</option>
	<select>
	<script>
	G('php_fpm_pm').value = '<?php echo isset($_POST['php_fpm_pm']) ? $_POST['php_fpm_pm'] : 'static';?>';
	</script>
	<input type="text" id="min_spare_servers" name="min_spare_servers" class="input_text" 
	value="<?php echo isset($_POST['min_spare_servers']) ? $_POST['min_spare_servers'] : '1';?>" style="width:30px" title="靜態模式最小進程數量"/> <span style="font-size:13px;">≤</span>
	<input type="text" id="start_servers" name="start_servers" class="input_text" 
	value="<?php echo isset($_POST['start_servers']) ? $_POST['start_servers'] : '2';?>" style="width:30px" title="動態模式起始進程數量"/> <span style="font-size:13px;">≤</span>
	<input type="text" id="max_spare_servers" name="max_spare_servers" class="input_text" 
	value="<?php echo isset($_POST['max_spare_servers']) ? $_POST['max_spare_servers'] : '3';?>" style="width:30px" title="動態模式最大進程數量"/> <span style="font-size:13px;">≤</span>
	<input type="text" id="max_children" name="max_children" class="input_text" 
	value="<?php echo isset($_POST['max_children']) ? $_POST['max_children'] : '3';?>" style="width:30px" title="子進程數量"/> 
	</td>
<td><p> 設置虛擬主機運行的php進程數量(動態自動調節、靜態固定)</p>
<p> 每一進程耗用>2MB內存可根據服務器實際負載適當調整</p>
<p> 需按(<span style="font-size:13px;">≤</span>)條件設置各項大小，否則會影響主機php啟動</p>
</td>
	</tr>
</table>

<?php if (isset($edit_host)) { ?>
	<input type="hidden" name="save_edit" value="<?php echo $_POST['host_domain'];?>" />
<?php } else { ?>
	<input type="hidden" name="save" value="y" />
<?php }?>

<button type="submit" class="primary button" name="submit"><span class="check icon"></span>保存</button> 
</form>


<div id="notice_message">
<h3>» SSH Host</h3>
1) 有步驟提示操作: <br />
ssh執行命令: amh host <br />
然後選擇對應的1~7的選項進行操作。 <br />

2) 或直接操作: <br />
<ul>
<li>啟動虛擬主機: amh host start [主標識域名] 缺省主標識域名即為所有</li>
<li>停止虛擬主機: amh host stop [主標識域名] 缺省主標識域名即為所有</li>
<li>虛擬主機列表: amh host list </li>
<li>新增虛擬主機: amh host add [主標識域名amysql.com] [綁定域名amysql.com,www.amysql.com] [默認主頁index.php,index.html] [Rewrite規則amh] [自定義錯誤頁面404,502] [訪問日誌on/off] [錯誤日誌on/off] [二級域名綁定子目錄on/off] [設置PHP-FPM static/dynamic,1,2,3,4]< /li>
<br />
<li>編輯虛擬主機: amh host edit [主標識域名] [其餘參數與add命令相同]</li>
<li>刪除虛擬主機: amh host del [主標識域名]</li>

</ul>

3) 溫馨提示:<br />
增加或編輯虛擬主機忽略參某參數請填寫0，如參數有多項請使用英文逗號分隔。 <br />
例如: amh host add amysql.com amysql.com,www.amysql.com index.html,index.php 0 404,502 on off on static,1,2,3,4<br />
以上命令為增加一虛擬主機，主標識域名為amysql.com，綁定域名amysql.com與ww.amysql.com，默認主頁為index.html與index.php，開啟自定義404與502頁面、開啟錯誤日誌、與開啟子目錄綁定。並設置主機php-fpm為靜態模式，子進程數為4。 <br />

<h3>» SSH PHP</h3>
1) 有步驟提示操作: <br />
ssh執行命令: amh php <br />
2) 或直接操作: (缺省主標識域名即操作所有域名)<br />
<ul>
<li>啟動PHP: amh php start [主標識域名]</li>
<li>停止PHP: amh php stop [主標識域名] </li>
<li>重啟PHP: amh php restart [主標識域名] </li>
<li>重載PHP: amh php reload [主標識域名] </li>
</ul>
3) 面板自身PHP操作: amh php [start/stop/restart/reload] [amh-web] [y/n] <br />
面板自身PHP主標識參數為amh-web，並需額外增加確認參數[y/n]
</div>
</div>

<script>G('host_rewrite').parentNode.appendChild( C('input', {'type':'button', 'id':'AMRewrite-1.0', 'value':'管理', 'onclick':function (){WindowOpen("/index.php?c=amrewrite");}}) );</script>
<?php include('footer.php'); ?>
