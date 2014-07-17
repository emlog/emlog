<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="m">
<?php foreach($logs as $value): ?>
<div class="title"><a href="<?php echo BLOG_URL; ?>m/?post=<?php echo $value['logid'];?>"><?php echo $value['log_title']; ?></a></div>
<!--vot--><div class="info"><?=emdate($value['date'])?></div>
<div class="info2">
<!--vot--><?=lang('comments')?>: <?php echo $value['comnum']; ?>, <?=lang('views')?>: <?php echo $value['views']; ?> 
<?php if(ROLE == ROLE_ADMIN || $value['author'] == UID): ?>
<!--vot--><a href="./?action=write&id=<?php echo $value['logid'];?>"><?=lang('edit')?></a>
<?php endif;?>
</div>
<?php endforeach; ?>
<div id="page"><?php echo $page_url;?></div>
</div>