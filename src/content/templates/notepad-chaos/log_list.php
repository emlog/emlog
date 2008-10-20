<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div id="container">
  <div id="search">
    <form method="get" name="keyform" id="searchform" action="index.php">
      <input type="text" value="" name="keyword" id="s" class="txtField" />
      <input type="submit" id="searchsubmit" class="btnSearch" value="Find It &raquo;"onclick="return keyw()" />
    </form>
  </div>
  <div id="menu-holder">
  <ul id="menu">
  <li id="home"><a href="./">Home</a></li>
  <li id="about"><a href="http://www.emlog.net" target="_blank">emlog</a></li>
  <li id="archives"><a href="/rss.php">Rss</a></li>
  </ul>
  </div>
  <div id="title">
    <h2><a href="./"><?php echo $blogname; ?></a></h2>
    <?php echo $bloginfo; ?></div>
</div>
<div id="content">
  <div class="col01">
  <?php foreach($logs as $value):?>
    <div class="post" id="post-<?php echo $value['gid']; ?>">
      <h3><a href="./?action=showlog&gid=<?php echo $value['logid']; ?>" rel="bookmark" title="Permanent Link to <?php echo $value['log_title']; ?>"><?php echo $value['log_title']; ?></a></h3>
      <div class="post-inner">
        <div class="date-tab"><span class="month"><?php echo date('n月',$value['date']); ?></span><span class="day"><?php echo date('j',$value['date']); ?></span></div>
        <div class="thumbnail"></div>
		<?php echo $value['log_description']; ?>
		<p><?php echo $value['att_img']; ?></p>
		<p><?php echo $value['attachment']; ?></p>
      </div>
	<div class="meta"><?php echo ($value['tag']?$value['tag']."|":''); ?>
		<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>|
		<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a>|
		<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
	</div>
    </div>
   <?php endforeach;?>
    <div class="page-url"><?php echo $page_url;?></div>
  </div>
  <div class="col02">
    <div class="recent-posts">
    <?php
    	$topquery = $DB->query("SELECT * FROM ".DB_PREFIX."blog WHERE hide='n' ORDER BY date DESC  LIMIT 5");
		while($toplogs = $DB->fetch_array($topquery)):
			$toplogs['post_time'] = date('Y-n-j G:i l',$toplogs['date']);
			$toplogs['title'] = htmlspecialchars(trim($toplogs['title']));
	?>
    <ul>
    <li><a href="./?action=showlog&gid=<?php echo $toplogs['gid']; ?>"><?php echo $toplogs['title']; ?><br />
    <span class="listMeta"><?php echo $toplogs['post_time']; ?></span></a></li>
    </ul>
    <?php endwhile;?>
    </div>
    <div class="postit-bottom"></div>
    <?php include getViews('side'); ?>
  </div>
  <br clear="all" />
</div>
<?php include getViews('footer'); ?>