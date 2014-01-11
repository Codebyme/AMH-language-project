<?php include('header.php'); ?>

<div id="body" style="height:535px;">
<?php 
$c_name = 'backup';
include('category_list.php'); 
?>
<div style="width:500px;"><div>
<p id="ing_status" style="margin:0px">請稍後，面板數據備份中：</p>
</div>
</div>

</div>
<input type="button" value="備份中，請稍後…" disabled="" id="backup_ing_button" class="cmd_ing_button" />
<?php include('footer.php'); ?>