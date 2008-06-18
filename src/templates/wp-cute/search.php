<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<DIV class=post id=post-1>
<h3><?php echo $search_info; ?></h3>
<div>
<ul>
<?php foreach($slog as $key=>$value): ?>
<li><a href="./?action=showlog&gid=<?php echo $value['gid'];?>"><?php echo $value['title'];?></a> (<?php echo $value['date'];?>)</li>
<?php endforeach; ?>	
</ul>
</div>
</div>
<?php
include getViews('footer');
?>