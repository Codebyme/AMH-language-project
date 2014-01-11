<?php include('header.php'); ?>

<div id="body">
<?php 
$c_name = 'config';
include('category_list.php'); 
?>

<?php
	if (!empty($notice)) echo '<div style="margin:5px 2px;width:500px;"><p id="' . $status . '">' . $notice . '</p></div>';
?>
<p>在線升級&程序更新:</p>
<table border="0" cellspacing="1"  id="STable" style="width:1000px;">
	<tr>
	<th width="130">名稱</th>
	<th width="60">級別</th>
	<th width="550">升級 & 更新描述</th>
	<th width="100">作者 & 發佈時間</th>
	<th width="120">操作</th>
	</tr>
	<?php 
	if(!is_array($upgrade_list) || count($upgrade_list) < 1)
	{
	?>
		<tr><td colspan="5" style="padding:10px;">暫無程序更新數據</td></tr>
	<?php	
	}
	else
	{
		foreach ($upgrade_list as $key=>$val)
		{
	?>
			<tr>
				<td><?php echo $val['AMH-UpgradeName'];?></td>
				<td style="color:<?php echo $val['AMH-UpgradeGradeColor'];?>"><b><?php echo $val['AMH-UpgradeGradeCN'];?></b></td>
				<td class="description_block"><?php echo $val['AMH-UpgradeDescription'];?>
				<br />查看詳情: <a href="<?php echo $val['AMH-UpgradeUrl'];?>" target="_blank"><?php echo $val['AMH-UpgradeUrl'];?></a>
				</td>
				<td><?php echo $val['AMH-UpgradeScriptBy'];?> 
				<br /> <i><?php echo $val['AMH-UpgradeDate'];?> </i>
				</td>
				<td>
				<?php if ($val['AMH-UpgradeAvailableStatus'] == 'false') { ?>
					<button type="button" class="primary button" disabled >不可用</button>
				<?php }elseif ($val['AMH-UpgradeInstallStatus'] == 'true') { ?>
					<button type="button" class="primary button" disabled >已更新</button>
				<?php } else {?>
					<button type="button" class="primary button" onclick="return (confirm('確認安裝更新：<?php echo $val['AMH-UpgradeName'];?> 吗?') && (WindowLocation('/index.php?c=config&a=config_upgrade&install=<?php echo $val['AMH-UpgradeName'];?>')) && (this.innerHTML=' 请稍等...') && (this.disabled=true))" > 安裝更新</button>
				<?php }?>
				</td>
			</tr>
	<?php
		}
	}
	?>
</table>


<div id="notice_message" style="width:700px;">
<h3>» WEB 在线升級</h3>
1) 每一次升級更新前，請您先查看升級詳情信息，閱讀官方網站發布的升級說明。 <br />
2) 升級更新級別分別有：較低、一般、重要。可選擇性更新升級。 <br />
3) 更新程序如果存在上下依賴性(如，需完成舊的更新)或是當前存在衝突或不兼容情況，這一更新可能會處於"不可用"狀態。 <br />

<h3>» SSH Upgrade</h3>
1) 有步驟提示操作: <br />
ssh執行命令: amh upgrade <br />
然後選擇對應的更新名稱進行安裝升級。 <br />
2) 或直接操作: <br />
<ul>
<li>更新列表: amh upgrade list</li>
<li>更新說明: amh upgrade [更新名稱] info</li>
<li>安裝升級: amh upgrade [更新名稱] install</li>
<li>安裝狀態: amh upgrade [更新名稱] install_status</li>
<li>可用狀態: amh upgrade [更新名稱] available_status</li>
</ul>
</div>
</div>
<script>
upgrade_notice();
</script>
<?php include('footer.php'); ?>