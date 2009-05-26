<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div id="container">
  <div id="search">
    <form method="get" name="keyform" id="searchform" action="<?php echo BLOG_URL; ?>">
      <input type="text" value="" name="keyword" id="s" class="txtField" />
      <input type="submit" id="searchsubmit" class="btnSearch" value="Find It &raquo;"onclick="return keyw()" />
    </form>
  </div>
  <div id="menu-holder">
  <ul id="menu">
  <li id="home"><a href="<?php echo BLOG_URL; ?>">Home</a></li>
  <li id="about"><a href="http://www.emlog.net" target="_blank">emlog</a></li>
  <li id="archives"><a href="<?php echo BLOG_URL; ?>rss.php">Rss</a></li>
  </ul>
  </div>
  <div id="title">
    <h2><a href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a></h2>
    <?php echo $bloginfo; ?></div>
</div>
<div id="content">
  <div class="col01">
    <div class="post" id="post-<?php echo $logid; ?>">
      <h3>
	  <a href="<?php echo BLOG_URL; ?>?post=<?php echo $logid; ?>" rel="bookmark" title="Permanent Link to <?php echo $log_title; ?>"><?php echo $log_title; ?></a>
	  </h3>
      <div class="post-inner">
        <div class="thumbnail"></div>
		<div class="post_P"><?php echo $log_content; ?></div>
		<p><?php blog_att($logid); ?></p>
      </div>
    </div>
	<?php 
	if ($allow_remark == 'y'){
		blog_comments();
		blog_comments_post();
	}
	?>
  </div>
  <div class="col02">
    <?php include getViews('side'); ?>
  </div>
  <br clear="all" />
</div>
<?php include getViews('footer'); ?>