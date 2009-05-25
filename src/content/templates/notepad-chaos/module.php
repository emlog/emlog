<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<?php
//widget：blogger
function widget_blogger($title){
	global $user_cache; 
	$name = $user_cache[1]['mail'] != '' ? "<a href=\"mailto:".$user_cache[1]['mail']."\">".$user_cache[1]['name']."</a>" : $user_cache[1]['name'];?>
    <li><span onclick="showhidediv('blogger')"><b><?php echo $title; ?></b></span></li>
    	<ul id="blogger">
    	<li>
		<?php if (!empty($user_cache[1]['photo']['src'])): ?>
		<img src="<?php echo BLOG_URL.$user_cache[1]['photo']['src']; ?>" width="<?php echo $user_cache[1]['photo']['width']; ?>" height="<?php echo $user_cache[1]['photo']['height']; ?>" alt="blogger" />
		<?php endif;?>
		</li>
		<li><b><?php echo $name; ?></b></li>
		<li><span id="bloggerdes"><?php echo $user_cache[1]['des']; ?></span>
		<?php if(ROLE == 'admin'): ?>
		<a href="javascript:void(0);" onclick="showhidediv('modbdes','bdes')">
		<img src="<?php echo CERTEMPLATE_URL; ?>/images/modify.gif" align="absmiddle" style="border:0"alt="修改我的状态"/></a></li>
		<li id='modbdes' style="display:none;">
		<textarea name="bdes" class="input" id="bdes" style="overflow-y: hidden;width:190px;height:60px;"><?php echo $user_cache[1]['des']; ?></textarea>
		<br />
		<a href="javascript:void(0);" onclick="postinfo('<?php echo BLOG_URL; ?>admin/blogger.php?action=update&flg=1','bdes','bloggerdes');">提交</a>
		<a href="javascript:void(0);" onclick="showhidediv('modbdes')">取消</a>
		<?php endif; ?>
		</li>
    	</ul>
<?php }?>
<?php
//widget：日历
function widget_calendar($title){
	global $calendar_url; ?>
    <li><span onclick="showhidediv('calendar')"><b><?php echo $title; ?></b></span></li>
    	<ul id="calendar">
    	</ul>
    	<script>sendinfo('<?php echo $calendar_url; ?>','calendar');</script>
<?php }?>
<?php
//widget：标签
function widget_tag($title){
	global $tag_cache; ?>
    <li><span onclick="showhidediv('tags')"><b><?php echo $title; ?></b></span></li>
    	<ul id="tags">
    	<?php foreach($tag_cache as $value):?>
		<a href="<?php echo BLOG_URL; ?>?tag=<?php echo $value['tagurl']; ?>" style="font-size:<?php echo $value['fontsize']; ?>pt;;line-height:30px;" title="<?php echo $value['usenum']; ?> 篇日志"><?php echo $value['tagname']; ?></a>
		<?php endforeach; ?>
    	</ul>
<?php }?>
<?php
//widget：分类
function widget_sort($title){
	global $sort_cache; ?>
	<li><span onclick="showhidediv('sort')"><b><?php echo $title; ?></b></span></li>
	<div class="sort">
	  <ul>
	<?php foreach($sort_cache as $value): ?>
	<li>
	<a href="<?php echo BLOG_URL; ?>?sort=<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?>(<?php echo $value['lognum'] ?>)</a>
	<a href="<?php echo BLOG_URL; ?>rss.php?sort=<?php echo $value['sid']; ?>"><img align="absmiddle" src="<?php echo CERTEMPLATE_URL; ?>/images/icon_rss.gif" alt="订阅该分类"/></a>
	</li>
	<?php endforeach; ?>
	  </ul>
	</div>
<?php }?>
<?php
//widget：twitter
function widget_twitter($title){
	global $tw_cache,$index_twnum,$localdate; ?>
    <?php if($index_twnum>0): ?>
	<li><span onclick="showhidediv('twitter')"><b><?php echo $title; ?></b></span></li>
	<ul id="twitter">
	<?php
	if(isset($tw_cache) && is_array($tw_cache)):
		$morebt = count($tw_cache)>$index_twnum?"<li id=\"twdate\"><a href=\"javascript:void(0);\" onclick=\"sendinfo('".BLOG_URL."twitter.php?p=2','twitter')\">较早的&raquo;</a></li>":'';
		foreach (array_slice($tw_cache,0,$index_twnum) as $value):
			$delbt = ROLE == 'admin'?"<a href=\"javascript:void(0);\" onclick=\"isdel('".BLOG_URL."','{$value['id']}','twitter')\">删除</a>":'';
			$value['date'] = smartyDate($localdate,$value['date']);
			?>
			<li> <?php echo $value['content']; ?> <?php echo $delbt; ?><br><font color="#21565E"><?php echo $value['date']; ?></font></li>
		<?php endforeach;?>
		<?php echo $morebt;?>
	<?php endif;?>
	</ul>
	<?php if(ROLE == 'admin'): ?>
		<ul>
		<li><a href="javascript:void(0);" onclick="showhidediv('addtw','tw')">我要唠叨</a></li>
		<li id='addtw' style="display: none;">
		<textarea name="tw" id="tw" style="overflow-y: hidden;width:200px;height:70px;" class="input"></textarea>
		<a href="javascript:void(0);" onclick="postinfo('<?php echo BLOG_URL; ?>twitter.php?action=add','tw','twitter');">提交</a>
		<a href="javascript:void(0);" onclick="showhidediv('addtw')">取消</a>
		</li>
		</ul>
	<?php endif;?>
	<?php endif;?>
<?php } ?>
<?php
//widget：最新评论
function widget_newcomm($title){
	global $com_cache; ?>
	<li><span onclick="showhidediv('comm')"><b><?php echo $title; ?></b></span></li>
	<div class="comm">
	  <ul>
	  	<?php 
		foreach($com_cache as $value): 
		$value['url'] = BLOG_URL.$value['url'];
		?>
		<li>
		<a href="<?php echo $value['url']; ?>"><?php echo $value['content']; ?> by <?php echo $value['name']; ?>
		<?php if($value['reply']): ?>
		<img src="<?php echo CERTEMPLATE_URL; ?>/images/reply.gif" style="border:0" title="博主回复：<?php echo $value['reply']; ?>"align="absmiddle"/>
		<?php endif;?>
		</a>
		</li>
		<?php endforeach; ?>
	  </ul>
	</div>
<?php }?>
<?php
//widget：随机日志
function widget_random_log($title){
	global $index_randlognum, $emBlog;
	if (!isset($emBlog))
	{
		global $DB;
		require_once(EMLOG_ROOT.'/model/C_blog.php');
		$emBlog = new emBlog($DB);
	}
	$randLogs = $emBlog->getRandLog($index_randlognum);?>
	<li><span onclick="showhidediv('randlog')"><b><?php echo $title; ?></b></span></li>
	<div id="randlog">
	  <ul>
		<?php foreach($randLogs as $value): ?>
		<li><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a></li>
		<?php endforeach; ?>	
	  </ul>
	</div>
<?php }?>
<?php 
//widget：音乐
function widget_music($title){
	global $musicdes,$musicurl,$autoplay; ?>
	<li><span onclick="showhidediv('music')"><b><?php echo $title; ?></b></span></li>
	<ul id="music">
	<li>
	<?php echo $musicdes;?><object type="application/x-shockwave-flash" data="<?php echo CERTEMPLATE_URL; ?>/images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay;?>&autoreplay=1" width="150" height="20"><param name="movie" value="<?php echo CERTEMPLATE_URL; ?>/images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay;?>&autoreplay=1" /></object>
	</li>
	</ul>
<?php }?>
<?php
//widget：归档
function widget_archive($title){
	global $dang_cache; ?>
	<li><span onclick="showhidediv('record')"><b><?php echo $title; ?></b></span></li>
		<ul id="record">
		<?php foreach($dang_cache as $value): ?>
		<li><a href="<?php echo BLOG_URL; ?><?php echo $value['url']; ?>"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a></li>
		<?php endforeach; ?>		
		</ul>
<?php } ?>
<?php
//widget：自定义组件
function widget_custom_text($title, $content, $id){ ?>
	<li><span onclick="showhidediv('<?php echo $id; ?>')"><b><?php echo $title; ?></b></span></li>
	<div id="<?php echo $id; ?>">
	  <ul>
		<li><?php echo $content; ?>	</li>
	  </ul>
	</div>
<?php } ?>
<?php
//widget：链接
function widget_link($title){
	global $link_cache; ?>
	<li><span onclick="showhidediv('link')"><b><?php echo $title; ?></b></span></li>
	<div id="link">
	  <ul>
		<?php foreach($link_cache as $value): ?>     	
		<li><a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><?php echo $value['link']; ?></a></li>
		<?php endforeach; ?>	
	  </ul>
	</div>
<?php }?>
<?php
//widget：博客信息
function widget_bloginfo($title){
	global $sta_cache,$viewcount_day,$viewcount_all; ?>
	<li><span onclick="showhidediv('bloginfo')"><b><?php echo $title; ?></b></span></li>
		<ul id="bloginfo">
		<li>日志数量：<?php echo $sta_cache['lognum']; ?></li>
		<li>评论数量：<?php echo $sta_cache['comnum']; ?></li>
		<li>引用数量：<?php echo $sta_cache['tbnum']; ?></li>
		<li>今日访问：<?php echo $viewcount_day; ?></li>
		<li>总访问量：<?php echo $viewcount_all; ?></li>
		</ul>
<?php }?>