<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="sidebar">
<?php
include getViews('side');
?>
  <div id="page">
    <div id="colwrap">
    <?php include getViews('banner'); ?>
      <!-- Posts -->
    <?php
    	$title = "";
    	if(isset($_GET['sort']))
		{
			global $sort_cache;
    		$title = "查看分类文章:' ".$sort_cache[$_GET['sort']]['sortname']."'";
		}
		if(isset($_GET['record']))
		{
			$title = "查看归档文章 ".$_GET['record'];
		}
		if(isset($_GET['author']))
		{
			$title = "查看作者文章";
		}
		if(isset($_GET['tag']))
		{
			$title = "查看标签文章：".$_GET['tag'];
		}
		if(isset($_GET['keyword']))
		{
			$title = "搜索结果";
		}
		if($title != ""):
    ?>
    <div style="float:right;width:660px;">
    <div class="navigation">
    <h3><?php echo $title;?></h3> 
    </div>
    </div>
    <?php endif;?>
      <?php foreach($logs as $value): ?> 
      <div class="postcont">
        <div class="alignright">
          <div class="PTtop"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
          <div class="PTbar">
             <div class="PTds Ptime"><span class="ptblurl">&nbsp;</span><span class="blurt"><?php echo date('d M Y', $value['date']);?> @ <?php echo date('G:i A', $value['date']); ?></span><span class="ptblurr">&nbsp;</span></div>
             <div class="edt"><?php editflg($value['logid'],$value['author']); ?></div>
             <div class="PT PTds"><span class="ptblurl">&nbsp;</span><h3><a href="./?post=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a></h3><span class="ptblurr">&nbsp;</span></div>
          </div>
  
            <div class="PTbtm"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
            <div class="p1">
              <div style="overflow: auto">
              <?php echo $value['log_description']; ?>
              <?php blog_att($value['logid']); ?>
              </div>
            </div>
          
          <div class="PFtop"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
          <div class="PFpst">
            
            <span class="spanchunk tagiconbox">
              <img class="tagicon" src="<?php echo CERTEMPLATE_URL; ?>/images/tags_50.png" alt="Tags" />
            </span>
            <span class="tagstyle spanchunk">
              <?php blog_tag($value['logid']); ?>
              <?php blog_sort($value['sortid'], $value['logid']); ?>
              <strong>发表:</strong> <?php blog_author($value['author']); ?>
            </span>
    
            <span class="tagstyle ts-sm spanchunk"><br /><br /><br />
              <a href="./?post=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a> &bull; 
              <a href="./?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> &bull; 
              <a href="./?post=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>
            </span>
          </div>
          <div class="PFbtm"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
        </div>
        
      </div>
      <hr class="rule" />
      <?php endforeach; ?>
      
      <?php
      if($page_url) {
      ?> 
      <div style="float:right;width:660px;">
        <div class="navigation" align="center">
          <?php echo $page_url;?>
        </div>
      </div><br /><br /><br />
      <?php } ?> 
      <div style="clear:right;"></div>
      </div>
    </div>
<?php include getViews('footer'); ?>