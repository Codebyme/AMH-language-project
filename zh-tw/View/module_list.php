<?php include('header.php'); ?>
<script src="View/js/module_list.js"></script>
<style>
.stars_show {
	margin:5px 10px 0px;
	display:none;
	width: 110px;
	float: left;
}
.stars {
	margin:5px;
	display:block;
	height: 38px;
}
</style>

<div id="body">
<?php 
$c_name = 'module';
include('category_list.php'); 
?>


<p>模塊拓展&程序管理列表:</p>
<?php
	if (!empty($notice)) echo '<div style="margin:5px 2px;width:500px;"><p id="' . $status . '">' . $notice . '</p></div>';
?>
<div id="module_list" style="position: relative">
	<?php
	if (is_array($module_list_data['data']) && count($module_list_data['data']) > 0)
	{
		foreach ($module_list_data['data'] as $_k=>$_v)
		{
			echo '<div class="module_row">';
			foreach ($_v as $key=>$val)
			{				
	?>
		<div class="item">
			<div class="h3">
			<img src="<?php echo !empty($val['AMH-ModuleIco']) ? $val['AMH-ModuleIco'] : '/View/images/module.gif';?>" /> 
			<br /><?php echo $val['AMH-ModuleName'];?>
			<br /><i><font><?php echo $val['AMH-ModuleDate'];?></font></i>
			<br />
			<?php if($val['AMH-ModuleStatus'] == 'true') { ?>
				<?php if( $val['AMH-ModuleAdmin'] != '') { ?>
				<a class="button2" href="<?php echo $val['AMH-ModuleAdmin'];?>" target="_blank" style="right: 120px;">管理模塊</a>
				<?php }?>
			<?php } else { ?>
				<a class="button2" href="./index.php?c=module&a=module_list&name=<?php echo $val['AMH-ModuleName'];?>&action=delete&page=<?php echo $page;?>" onclick="return confirm('確認刪除<?php echo $val['AMH-ModuleName'];?>吗?');" style="right: 120px;">刪除</a>
			<?php } ?>

			<?php if($val['AMH-ModuleButton'] != '') { ?>
			<a class="button2" href="./index.php?c=module&a=module_list&name=<?php echo $val['AMH-ModuleName'];?>&action=<?php echo $val['AMH-ModuleAction'];?>&page=<?php echo $page;?>&actionName=<?php echo urlencode($val['AMH-ModuleButton']);?>" onclick="return (confirm('確認<?php echo $val['AMH-ModuleButton'];?><?php echo $val['AMH-ModuleName'];?>嗎?') && (this.innerHTML='請稍等...'))" ><?php echo $val['AMH-ModuleButton'];?></a>
			<?php }?>
			</div>

			<p><?php echo $val['AMH-ModuleDescription'];?></p>
			<div class="stars_show">
			<a class="stars"  href="javascript:;" name="<?php echo $val['AMH-ModuleName'];?>" title="得分<?php echo $val['AMH-ModuleScore']['val'];?> 总<?php echo $val['AMH-ModuleScore']['sum'];?>次評價">
				<font class="stars_val" name="<?php echo $val['AMH-ModuleScore']['val'];?>" style="width:<?php echo $val['AMH-ModuleScore']['val'];?>px;display:block;margin:0px;">
				</font>
				<span></span>
			</a>
			</div>
			<i class="by">模塊由<?php echo $val['AMH-MoudleScriptBy'];?></i>
			<em><a href="<?php echo $val['AMH-ModuleWebSite'];?>" target="_blank"><?php echo $val['AMH-ModuleWebSite'];?></a></em>製作
			<br />
		</div>
	<?php
		}
			echo '</div>';
		}
	}
	else
	{
	?>
		<div class="item" style="padding:20px; 10px"><p>無模塊拓展程序</p></div>   
	<?php
	}
	?>
	<div style="clear:both;"></div>
</div>

<div id="page_list">总<?php echo $total_page;?>頁 - 本地共<?php echo $module_list_data['sum'];?>个模塊拓展 » 頁碼 <?php echo htmlspecialchars_decode($page_list);?> </div>


<div id="notice_message" style="width:500px;">
<h3>» WEB Module</h3>
1) 注意: 安裝非官方提供的模塊，必要驗證確認模塊安全性。 <br />
2) 模塊需先卸載再刪除。卸載模塊即恢復至安裝模塊之前的狀態。
<br />刪除模塊即是刪除對應/root/amh/modules模塊腳本文件。 <br />

<h3>» SSH Module</h3>
1) 有步驟提示操作: <br />
ssh執行命令: amh module <br />
然後選擇對應的模塊進行管理。 <br />
2) 或直接操作: <br />
<ul>
<li>下載模塊: amh module download [模塊名字]</li>
<li>模塊信息: amh module [模塊名字] info</li>
<li>安裝模塊: amh module [模塊名字] install</li>
<li>管理模塊: amh module [模塊名字] admin</li>
<li>卸載模塊: amh module [模塊名字] uninstall</li>
<li>安裝狀態: amh module [模塊名字] status</li>
<li>刪除模塊: amh module [模塊名字] delete</li>
</ul>
3) 支持用戶創建編寫新的功能模塊，模塊腳本目錄/root/amh/modules
<br />模塊編程規範請查閱官方論壇文檔。
</div>
</div>
</div>
<script>
amh_module();
</script>
<?php include('footer.php'); ?>