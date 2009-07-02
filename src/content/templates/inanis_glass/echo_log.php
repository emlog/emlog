<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="sidebar">
<?php
about();
include getViews('side');
?>
  <div id="page">
    <div id="colwrap">
    <?php include getViews('banner'); ?>
      <div class="postcont">
        <div class="alignright">
          <div class="PTtop"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
          <div class="PTbar">
             <div class="PTds Ptime"><span class="ptblurl">&nbsp;</span><span class="blurt"><?php echo date('d M Y', $date);?> @ <?php echo date('G:i A', $date); ?></span><span class="ptblurr">&nbsp;</span></div>
             <div class="edt"><?php editflg($logid,$author); ?></div>
             <div class="PT PTds"><span class="ptblurl">&nbsp;</span><h3><a href="./?post=<?php echo $logid; ?>"><?php echo $log_title; ?></a></h3><span class="ptblurr">&nbsp;</span></div>
          </div>
  
            <div class="PTbtm"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
            <div class="p1">
              <div style="overflow: auto">
              <?php echo $log_content; ?>
              <?php blog_att($logid); ?>
              <?php doAction('log_related'); ?>
              </div>
            </div>
          
          <div class="PFtop"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
          <div class="PFpst">
            
            <span class="spanchunk tagiconbox">
              <img class="tagicon" src="<?php echo CERTEMPLATE_URL; ?>/images/tags_50.png" alt="Tags" />
            </span>
            <span class="tagstyle spanchunk">
              <?php blog_tag($logid); ?>
              <?php blog_sort($sortid, $logid); ?>
              <strong>发表:</strong> <?php blog_author($author); ?>
            </span>
    
            <span class="tagstyle ts-sm spanchunk"><br /><br /><br />
              <a href="./?post=<?php echo $logid; ?>">浏览(<?php echo $views; ?>)</a> &bull; 
              <a href="./?post=<?php echo $logid; ?>#tb">引用(<?php echo $tbcount; ?>)</a> &bull; 
              <a href="./?post=<?php echo $logid; ?>#comment">评论(<?php echo $comnum; ?>)</a>
            </span>
          </div>
          <div class="PFbtm"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
        </div>
        
      </div>
      <hr class="rule" />
      
      <?php neighbor_log(); ?> 
      <?php blog_response(); ?>
      <div style="clear:right;"></div>
	</div>
</div>
<?php include getViews('footer'); ?>