<?php include('header.php'); ?>

<div id="body" style="height:535px;">
<?php 
$c_name = 'backup';
include('category_list.php'); 
?>
<div style="width:500px;"><div>
<p id="ing_status" style="margin:0px">請稍後，面板數據一鍵還原中：</p>
</div>
</div>

</div>
<input type="button" value="還原中，請稍後…" disabled="" id="revert_ing_button" class="cmd_ing_button" />
<?php include('footer.php'); ?>