<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
 <!-- sidebar (container) -->
<div id="sidebar">
  <!-- sidebar wrap -->
  <div class="wrap">
     <ul>
     <li>
          
<!-- search form -->

<div id="searchtab">
  <div class="inside">
    <form method="get" id="searchform"  name="keyform" action="index.php">
      <input type="text" name="keyword" id="searchbox" size="16" class="searchfield" value="Search website..." onfocus="if(this.value == 'Search website...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search website...';}" />
       <input type="submit" value="Go" class="searchbutton" />
    </form>
  </div>
</div>

<!-- /search form -->		</li>

           <!-- Author information is disabled per default. Uncomment and fill in your details if you want to use it.
			<li><h2>Author</h2>
			<p>A little something about you, the author. Nothing lengthy, just an overview.</p>
			</li>
			-->
            <li>
              <!-- sidebar menu (categories) -->
              <ul class="nav">
                	<?php foreach($sort_cache as $value): ?>
	<li>
	<a href="./index.php?sort=<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?>(<?php echo $value['lognum'] ?>)</a><div class="rss"><a href="./rss.php?sort=<?php echo $value['sid']; ?>"><img align="absmiddle" src="<?php echo $em_tpldir; ?>images/icon_rss.gif" alt="订阅该分类"/></a></div>
	</li>
	<?php endforeach; ?>
                            </ul>
              <!-- /sidebar menu -->
            </li>

           
            			<li id="linkcat-2" class="linkcat"><h2>Blogroll</h2>
	<ul class='xoxo blogroll'>
<?php foreach($link_cache as $value): ?>     	
	<li><a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><?php echo $value['link']; ?></a></li>
	<?php endforeach; ?>

	</ul>
</li>
    		
<?php 
require_once (getViews('function'));
$widgets = !empty($options_cache['widgets1']) ? unserialize($options_cache['widgets1']) : array();
foreach ($widgets as $val)
{
	$widget_title = @unserialize($options_cache['widget_title']);
	$custom_widget = @unserialize($options_cache['custom_widget']);
	if(strpos($val, 'custom_wg_') === 0)
	{
		$callback = 'widget_custom_text';
		if(function_exists($callback))
		{
			call_user_func($callback, htmlspecialchars($custom_widget[$val]['title']), $custom_widget[$val]['content'], $val);
		}
	}else{
		$callback = 'widget_'.$val;
		if(function_exists($callback))
		{
			preg_match("/^.*\s\((.*)\)/", $widget_title[$val], $matchs);
			$wgTitle = isset($matchs[1]) ? $matchs[1] : $widget_title[$val];
			call_user_func($callback, htmlspecialchars($wgTitle));
		}
	}
}
?>
<div class="listerrss">
<a href="./rss.php"><img src="<?php echo $em_tpldir; ?>images/rss.gif" alt="订阅Rss"/></a>
</div>
</ul>
  </div><!-- /sidebar wrap -->
</div><!-- /sidebar -->

<!-- clear main & sidebar sections -->
<br clear="left" />
<!-- /clear main & sidebar sections -->