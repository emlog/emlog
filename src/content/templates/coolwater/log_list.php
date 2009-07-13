<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
	<div id="content-wrap">
		<div id="main">				
			<?php foreach($logs as $value): ?>
			<h2><?php topflg($value['top']); ?><a href="./?post=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a></h2>
			<p class="post-by">Posted by <?php blog_author($value['author']); ?></p>
			<?php echo $value['log_description']; ?>
			<?php blog_att($value['logid']); ?>
			<?php blog_tag($value['logid']); ?>
			<p class="post-footer align-left">					
			<?php blog_sort($value['sortid'], $value['logid']); ?>
					<span class="comments">
					<a href="./?post=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>
					<a href="./?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
					<a href="./?post=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
					</span>
					<span class="date"><?php echo date('F Y', $value['date']); ?> <?php editflg($value['logid'],$value['author']); ?></span>	
			</p>
			<br />
			<?php endforeach; ?>
			<p align="center"><?php echo $page_url;?></p>
		</div>
<?php
include getViews('side');
include getViews('footer'); 
?>