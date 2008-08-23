<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
include getViews('side');
?>
<div class="content">
<img src="<?php echo $tpl_dir; ?>dum-dum/images/img_08.jpg" alt="" />
	<div class="contenttext">
<?php foreach($logs as $value):?>

		<div class="post" id="post-<?php echo $value['logid']; ?>">
			<div class="postheader">
				<div class="postdate">
					<div class="postday">2</div> <!-- POST DAY -->
					<div class="postmonth">3</div> <!-- POST MONTH -->
				</div> <!-- POST DATE -->
				
				<div class="posttitle">
					<h3><?php echo $value['toplog']; ?><a href="./?action=showlog&gid=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a></h3>
				</div> <!-- POST TITLE -->

				<div class="postmeta">
					<div class="postauthor">by wwwwwwwwww</div> <!-- POST AUTHOR -->
					<div class="postcategory"><?php echo $value['tag']; ?></div> <!-- POST CATEGORY -->
				</div> <!-- POST META -->
			</div> <!-- POST HEADER -->
			<div style=" clear:both;"></div>
			<div class="posttext">
				<?php echo $value['log_description']; ?>
			</div> <!-- POST TEXT -->
			<div style="clear:both;"></div>
			<div class="postfooter" style="">
				<div class="postcomments"><?php echo $value['comnum']; ?></div> <!-- POST COMMENTS -->
				<div class="posttags"><div class="posttags2"><p><?php echo $value['tag']; ?></p></div> <!-- POST TAGS 2 --></div> <!-- POST TAGS -->
				<div class="postnr"><div class="postnrtext">22222222222222</div> <!-- POST NR TEXT --></div> <!-- POST NR -->
			</div> <!-- POST FOOTER -->
		</div> <!-- POST -->
		<?php endforeach; ?>

	</div> <!-- CONTENT TEXT -->
<img src="<?php echo $tpl_dir; ?>dum-dum/images/img_09.jpg" style="vertical-align: bottom;" alt="" />
</div> <!-- CONTENT -->

<div id="pageurl"><?php echo $page_url;?></div>
<?php include getViews('footer'); ?>