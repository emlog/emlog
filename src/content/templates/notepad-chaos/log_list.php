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
  <?php foreach($logs as $value):?>
    <div class="post" id="post-<?php echo $value['gid']; ?>">
      <h3><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>" rel="bookmark" title="Permanent Link to <?php echo $value['log_title']; ?>">
	  <?php echo $value['log_title']; ?></a>
		<?php if($log_cache_sort[$value['logid']]): ?>
		<span class="sort">[<a href="<?php echo BLOG_URL; ?>?sort=<?php echo $value['sortid']; ?>"><?php echo $log_cache_sort[$value['logid']]; ?></a>]</span>
		<?php endif;?>
	  </h3>
      <div class="post-inner">
        <div class="date-tab"><span class="month"><?php echo date('n月',$value['date']); ?></span><span class="day"><?php echo date('j',$value['date']); ?></span></div>
        <div class="thumbnail"></div>
        <div class="post_P">
	<?php echo $value['log_description']; ?>
    </div>
	<p><?php blog_att($value['logid']); ?></p>
	<p><?php blog_tag($value['logid']); ?></p>
    </div>
	<div class="meta">
		<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>|
		<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a>|
		<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
	</div>
    </div>
   <?php endforeach;?>
    <div class="page-url"><?php echo $page_url;?></div>
  </div>
  <div class="col02">
    <?php include getViews('side'); ?>
  </div>
  <br clear="all" />
</div>
<?php include getViews('footer'); ?>