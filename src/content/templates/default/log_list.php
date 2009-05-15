<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="content">
<ul>
<?php
foreach($logs as $value):
$topFlg = $value['toplog'] == 'y' ? "<img src=\"".CERTEMPLATE_URL."/images/import.gif\" align=\"absmiddle\"  alt=\"置顶日志\" />" : '';
?>
	<li>
	<h2 class="content_h2">
	<?php echo $topFlg; ?><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a>
	</h2>
	<?php blog_sort($value['sortid'], $value['logid']); ?>
	<div class="editor"><a href="#">编辑</a></div>
	<div class="clear line"></div>
   	<div class="bloger"> post by <?php blog_author($value['author']); ?> / <?php echo date('Y-n-j G:i l', $value['date']); ?></div>
	<div class="post"><?php echo $value['log_description']; ?></div>
	<div class="fujian"><?php blog_att($value['logid']); ?></div>
	<div class="under">
	<div class="top"></div>
	<div class="under_p">
	<div class="tag"><?php blog_tag($value['logid']); ?></div>
	<div>
	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>
	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
	</div>
	</div>
	<div class="bottom"></div>
	</div>
	</li>
<?php endforeach; ?>
</ul>
<div id="pagenavi">
	<?php echo $page_url;?>
</div>
</div>
<!--end content-->
<?php
 include getViews('side');
 include getViews('footer'); 
?>