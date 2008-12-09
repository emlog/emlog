<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
include getViews('side');
?>
<div id="content">
<div class="post">
<?php
foreach($logs as $value):
$datetime = explode("-",$value['post_time']);
$year = $datetime['0'];
$day = $datetime['1']."/".substr($datetime['2'],0,2);
$topFlg = $value['toplog'] == 'y' ? "<img src=\"{$em_tpldir}images/import.gif\" align=\"absmiddle\"  alt=\"推荐日志\" />" : '';
?> 
				<div class="dtm">
					<div class="dtmtmc">
						<div class="titlemeta">
							<?php echo $topFlg; ?><a href="./?action=showlog&gid=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a><br/>
							<span class="byline"><?php echo $value['tag']; ?></span>
						</div>
					</div>
					<div class="dtmdate">
						<div class="date"><?php echo $year; ?><br /><span><?php echo $day ?></span></div>
					</div>
				</div>
				<div class="postcontent">
				<?php echo $value['log_description']; ?>
				<p><?php echo $value['attachment']; ?></p>
				</div>
				<div class="posttags">	
				<div class="comments">
				<?php if($value['allow_remark']=='n'): ?>
				Comments Off
				<?php else: ?>
				<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>#comment">
				<?php if($value['comnum']==1 || $value['comnum']==0): ?>
				<?php echo $value['comnum']; ?> Comment
				<?php else: ?>
				<?php echo $value['comnum']; ?> Comments
				<?php endif; ?>
				</a>
				<?php endif; ?>
				|
				<?php if($value['allow_tb']=='n'): ?>
				Trackback Off
				<?php else: ?>
				<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>#tb">
				<?php if($value['tbcount']==0 || $value['tbcount']==1): ?>
				<?php echo $value['tbcount']; ?> Trackback
				<?php else: ?>
				<?php echo $value['tbcount']; ?> Trackbacks
				<?php endif; ?>
				</a>
				<?php endif; ?>
				|
				<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>">
				<?php if($value['views']==0 || $value['views']==1): ?>
				<?php echo $value['views']; ?> View
				<?php else: ?>
				<?php echo $value['views']; ?> Views
				<?php endif; ?>
				</a>
				</div>
				</div>
<?php endforeach; ?>
<br/>
<div id="pageurl"><?php echo $page_url;?></div>
</div>
</div>
<?php include getViews('footer'); ?>