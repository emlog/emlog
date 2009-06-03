<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div id="body">
    
<div id="body_top">

	<div id="body_left">
    	<div id="body_left_content">
	<div id="content" class="narrowcolumn">
<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
?><div class="post" id="post-1">
                <div class="post-top">
                    <div class="post-title">
                    	<h2>
						<?php topflg($value['top']); ?><a href="./?post=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a>
						</h2>
                        <h3>
						<?php blog_sort($value['sortid'], $value['logid']); ?>
						post by <?php blog_author($value['author']); ?> / <?php echo date('Y-n-j G:i l', $value['date']); ?> 
						<?php editflg($value['logid'],$value['author']); ?>
						</h3>
						</div>
                </div>
				<div class="entry clear">
					<div class="log_desc"><?php echo $value['log_description']; ?>
					<p><?php blog_att($value['logid']); ?></p>
					<p><?php blog_tag($value['logid']); ?></p>
					</div>
				</div>

                <div class="postmetadata">
                    <div class="alignleft">
						<a href="./?post=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>
						<a href="./?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
						<a href="./?post=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
						</div>
                </div>
			</div>

<?php endforeach; ?>
				</div>			
		<div class="navigation">
<div class="alignleft"><?php echo $page_url;?></div>
		</div>
	</div>
	</div>
<?php 
include getViews('side');
include getViews('footer'); ?>