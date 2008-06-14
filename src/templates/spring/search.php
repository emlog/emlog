<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div class="post">
<p><?php echo <?php echo $search_info; ?>;?></p>
<div>
<?php
foreach($slog as $key=>$value){
?>
<p><a href="./?action=showlog&gid=<?php echo $value['gid'];?>"><?php echo $value['title'];?></a> (<?php echo $value['date'];?>)</p>
<?php
}?>
</div>
</div>
<?php
?>
</div>
<?php
include getViews('side');
include getViews('footer');
?>