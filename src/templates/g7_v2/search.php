<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div class="post">
<div class="content">
<h2><b>日志搜索</b></h2>
<p><?php echo <?php echo $search_info; ?>;?></p>
<ul>
<?php
foreach($slog as $key=>$value){
?>
<li><a href="./?action=showlog&gid=<?php echo $value['gid'];?>"><?php echo $value['title'];?></a> (<?php echo $value['date'];?>)</li>
<?php
}?>
</ul>
</div>
<?php
?>
</div>
</div>
</div>
<?php
include getViews('footer');
?>