<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div id="nav">
<ul>
<li class="page_item current_page_item"><a href="./" title="Home">Home</a></li>
<?php foreach ($navibar as $key => $val):
if ($val['hide'] == 'y'){continue;}
if (empty($val['url'])){$val['url'] = './?post='.$key;}
?>
	<li><a href="<?php echo $val['url']; ?>" target="<?php echo $val['is_blank']; ?>"><?php echo $val['title']; ?></a></li>
<?php endforeach;?>
<?php doAction('navbar', '<li>', '</li>'); ?>
</ul>
</div>
<div id="content">
        <div class="post" id="post-$logid">
		  <div class="title">
          <h2><?php echo $log_title;?></h2>
</div>
<div class="entry">
<?php echo $log_content;?>
<p><?php blog_att($logid); ?></p>
</div>
	<?php 
	if ($allow_remark == 'y'){
		blog_comments();
		blog_comments_post();
	}
	?>
</div>
</div>
<div id="footer">Powered by <a href="http://www.emlog.net" title="emlog <?php echo EMLOG_VERSION;?>">emlog</a>
 Theme by <a href="http://www.ndesign-studio.com/">Nick La</a> <a href="http://www.miibeian.gov.cn" target="_blank"><?php echo $icp; ?></a>
<?php doAction('index_footer'); ?></div>
</div>
<?php
include getViews('side');
?>