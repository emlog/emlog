<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<?php $controller = isset($this) ? get_class($this) : ''; ?>
<a href="<?php echo BLOG_URL; ?>"><?php echo Option::get('blogname'); ?></a>
<?php if(!empty($tws)): ?>
	<span>&raquo;</span> <a href="<?php echo BLOG_URL; ?>t/"><?php echo Option::get('twnavi');?></a>
<?php elseif($controller === 'Sort_Controller'): ?>
	<span>&raquo;</span> <a href="<?php echo Url::sort($sortid); ?>"><?php echo $sortName; ?></a>
<?php elseif($controller === 'Tag_Controller'): ?>
	<span>&raquo;</span> <a href="<?php echo Url::tag(urlencode($tag)); ?>"><?php echo $tag; ?></a>
<?php elseif($controller === 'Author_Controller'): ?>
	<span>&raquo;</span> <a href="<?php echo Url::author($author); ?>"><?php echo $author_name; ?></a>
<?php elseif($controller === 'Record_Controller'): ?>
	<span>&raquo;</span> <a href="<?php echo Url::record($record); ?>">归档<?php echo $record; ?></a>
<?php elseif($controller === 'Search_Controller'): ?>
	<span>&raquo;</span> <a href="<?php echo BLOG_URL.'?keyword='.urlencode($keyword); ?>"><?php echo $keyword; ?></a>
<?php elseif($controller === 'Plugin_Controller'): ?>
	<span>&raquo;</span> <a href="<?php echo BLOG_URL.'?plugin='.$plugin; ?>"><?php echo $plugin; ?></a>
<?php elseif($controller === 'Log_Controller' && isset($logid)): 
	global $CACHE; 
	$log_cache_sort = $CACHE->readCache('logsort');
	if(!empty($log_cache_sort[$logid])): ?>
	<span>&raquo;</span> <a href="<?php echo Url::sort($log_cache_sort[$logid]['id']); ?>"><?php echo $log_cache_sort[$logid]['name']; ?></a>
	<?php endif; ?>
	<span>&raquo;</span> <span><?php echo $log_title; ?></span>
<?php endif; ?>
<?php if(isset($page) && $page > 1): ?>
	<span>&raquo;</span> <span>第<?php echo $page; ?>页</span>
<?php endif; ?>
<?php if(isset($comment_page) && $comment_page > 1): ?>
	<span>&raquo;</span> <span>评论第<?php echo $comment_page; ?>页</span>
<?php endif; ?>