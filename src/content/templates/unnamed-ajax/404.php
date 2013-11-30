<?php 
/*
* 404页面模板
*/
if(!defined('EMLOG_ROOT')) {exit('error!');}
$options_cache = Option::getAll();
extract($options_cache);
include View::getView('header');
if($_):
?>
<div id="content">
<?php endif; ?>
	<div class="post">
		<h2>您要访问的页面未找到</h2>
		<div class="log">
			<p>貌似没有找到您要访问的页面，随便看看吧～<img src="<?php echo BLOG_URL; ?>images/404.jpg" /></p>
		</div>
	</div>
<?php if($_): ?>
</div>
<?php include View::getView('side'); else:$ajax['content']=ob_get_clean();ob_start();endif; include View::getView('footer');?>