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
$topFlg = $value['toplog'] == 'y' ? "<img src=\"{$em_tpldir}images/import.gif\" align=\"absmiddle\"  alt=\"置顶日志\" />" : '';
?><div class="post" id="post-1">
                <div class="post-top">
                    <div class="post-title">
                    	<h2><?php echo $topFlg; ?><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a></h2>
                        <h3>
                        	<?php if($log_cache_sort[$value['logid']]): ?>
	<span class="sort">Filed Under[<a href="<?php echo BLOG_URL; ?>?sort=<?php echo $value['sortid']; ?>"><?php echo $log_cache_sort[$value['logid']]; ?></a>]</span>
	<?php endif;?>  <?php echo date('Y-n-j G:i l', $value['date']); ?>                        </h3>
						                    </div>
                </div>

				<div class="entry clear">
					<div class="log_desc"><?php echo $value['log_description']; ?>
						<p>
		<?php 
		$attachment = !empty($log_cache_atts[$value['logid']]) ? '<b>文件附件：</b>'.$log_cache_atts[$value['logid']] : '';
		echo $attachment;
		?>
	</p>
	<p>
		<?php 
		$tag  = !empty($log_cache_tags[$value['logid']]) ? '标签:'.$log_cache_tags[$value['logid']] : '';
		echo $tag;
		?>
	</p>
					</div>
				</div>

                <div class="postmetadata">
                    <div class="alignleft">
						<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>
	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>        </div>
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