<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="sidebar">
<?php
include getViews('side');
?>
  <div id="page">
    <div id="colwrap">
    <?php include getViews('banner'); ?>
      <div class="postcont">
        <div class="alignright">
          <div class="PTtop"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
          <div class="PTbar">
             <div class="PTds Ptime"><span class="ptblurl">&nbsp;</span><span class="blurt"></span><span class="ptblurr">&nbsp;</span></div>
             <div class="PT PTds"><span class="ptblurl">&nbsp;</span><h3><a href="./?post=<?php echo $logid; ?>"><?php echo $log_title; ?></a></h3><span class="ptblurr">&nbsp;</span></div>
          </div>
  
            <div class="PTbtm"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
            <div class="p1">
              <div style="overflow: auto">
              <?php echo $log_content; ?>
              <?php blog_att($logid); ?>
              </div>
            </div>
            	<div class="PFbtm"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
        </div>
        
      </div>
      <hr class="rule" />
      <?php blog_comment(); ?>
      <div style="clear:right;"></div>
</div></div>
<?php include getViews('footer'); ?>