<?php include('header.php'); ?>
<style>
#STable td.module_name {
	font-size:14px;
	padding:12px 0px;
}
</style>
<div id="body">
<?php 
$c_name = 'module';
include('category_list.php'); 
?>


<p>下載新的模塊程序:</p>
<?php
	if (!empty($notice)) echo '<div style="margin:5px 2px;width:500px;"><p id="' . $status . '">' . $notice . '</p></div>';
?>
<div id="module_down">
<form action="" method="POST" />
模塊名字搜索 <input type="text" class="input_text" name="module_name" style="width:251px"/>
<button type="submit" name="download_submit" class="primary button" style="_margin-bottom:15px;_margin-left:3px;"> 下載 </button> 
</form>
</div>
<table border="0" cellspacing="1"  id="STable" style="width:1000px;">
	<tr>
	<th width="230">模塊名稱 & 評分</th>
	<th width="580">模塊描述</th>
	<th width="120">模塊開發者</th>
	<th width="120">操作</th>
	</tr>
	<?php 
	if(!is_array($new_module_list['data']) || count($new_module_list['data']) < 1)
	{
	?>
		<tr><td colspan="5" style="padding:10px;">没找到新模塊拓展下載</td></tr>
	<?php	
	}
	else
	{
		foreach ($new_module_list['data'] as $key=>$val)
		{
			$fraction = number_format($val['module_stars'] / $val['module_starts_sum'], 2)
	?>
			<tr>
				<td class="module_name">
				<div>
					<img src="<?php echo !empty($val['module_ico']) ? $val['module_ico'] : '/View/images/module.gif';?>" /> <br />
					<?php echo $val['module_name'];?>
				</div>
				<div class="stars" title="得分<?php echo $fraction;?> 总<?php echo $val['module_starts_sum'];?>次次評價">
					<div class="stars_val" style="width:<?php echo $fraction;?>px">
					</div>
				</div>
				</td>
				<td class="description_block">
				<?php echo $val['module_description'];?>
				<br /> 模塊開發者網站: <a href="http://<?php echo $val['module_website'];?>" target="_blank"><?php echo $val['module_website'];?></a>
				</td>
				<td><?php echo $val['module_by'];?><br />
				<i><?php echo $val['module_time'];?></i>
				</td>
				<td>
				<?php if($val['module_download'] == 'y') {?>
					<button type="button" class="primary button" disabled=""> 已下載 </button>
				<?php } else {?>
					<button type="button" class="primary button" onclick="return (confirm('確認下載：<?php echo $val['module_name'];?> 模塊麼？?') && (WindowLocation('/index.php?c=module&a=module_down&module_name=<?php echo $val['module_name'];?>&page=<?php echo $page;?>')) && (this.innerHTML=' 請稍等...') && (this.disabled=true))" > 下載 </button>
				<?php } ?>
				</td>
			</tr>
	<?php
		}
	}
	?>
</table>
<div id="page_list">总<?php echo $total_page;?>頁 - 在線共<?php echo $new_module_list['sum'];?>個模塊拓展 » 頁碼 <?php echo htmlspecialchars_decode($page_list);?> </div>



<div id="notice_message" style="width:460px;line-height:25px">
<h3>» Download Module</h3>
1) 所有發布的模塊都已經過官方審核，可以輸入模塊名字直接搜索下載。 <br />
2) 模塊腳本保存目錄：/root/amh/modules <br />
3) 支持用戶創建編寫新的功能模塊，您也可以把模塊提交給我們，<br />
審核通過後將列入官方下載列表或會收錄為默認安裝模塊提供給用戶使用，<br />
模塊編程規範請查閱官方論壇文檔。 <br />
4) 更多豐富功能模塊與模塊開發交流請登錄AMH官方論壇。 <br />
</div>

</div>
<?php include('footer.php'); ?>