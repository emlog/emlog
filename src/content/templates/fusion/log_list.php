
<!-- main content -->
<div id="main-content">

<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
$topFlg = $value['toplog'] == 'y' ? "<img src=\"{$em_tpldir}images/import.gif\" align=\"absmiddle\"  alt=\"推荐日志\" />" : '';
?>	
		
            <!-- post -->
			<div class="post hentry category-uncategorized" id="post-1">

                <h2><?php echo $topFlg; ?><a href="./?action=showlog&gid=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a>
	</h2>

                <!-- story header -->
                <div class="postheader">
                    <div class="postinfo">
    				<p> <?php if($log_cache_sort[$value['logid']]): ?>
	<span class="sort">[<a href="./?sort=<?php echo $value['sortid']; ?>"><?php echo $log_cache_sort[$value['logid']]; ?></a>]</span>
	<?php endif;?> <?php echo $value['post_time']; ?><!-- by admin -->
					</p>
                    </div>
                </div>
                <!-- /story header -->
				<div class="postbody entry">
					<p>
	<div class="log_desc"><div style="width:610px; overflow:hidden;"><?php echo $value['log_description']; ?></div></div>
    <?php 
		$attachment = !empty($log_cache_atts[$value['logid']]) ? '<b>文件附件：</b>'.$log_cache_atts[$value['logid']] : '';
		echo $attachment;
		?>
	</p>
				</div>
                <p class="tags"><?php 
		$tag  = !empty($log_cache_tags[$value['logid']]) ? '标签:'.$log_cache_tags[$value['logid']] : '';
		echo $tag;
		?></p>
                <p class="postcontrols">
                <a href="./?action=showlog&gid=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>
	<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
	<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
                </p>
                <br clear="all" />
		    </div>
            <!-- /post -->
<?php endforeach; ?>

<div id="pageurl"><?php echo $page_url;?></div>
	
</div>
<!-- /main content -->
</div>
<!-- /main -->
</div>
<!-- /main wrapper -->
<?php 
include getViews('side');
include getViews('footer'); 
?>