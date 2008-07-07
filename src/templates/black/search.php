<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
include getViews('side');
?>

<div class="content">
<div id="tag"><p class="t"><?php echo $search_info; ?></p>
<div class="s">
<?php foreach($slog as $key=>$value): ?>
	<li><a href="./?action=showlog&gid=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a> (<?php echo $value['date']; ?>)</li>
<?php endforeach; ?>
</div>
</div>
</div>

<?php include getViews('footer'); ?>