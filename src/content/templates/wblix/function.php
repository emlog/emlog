<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<!--blogger-->
<?php function widget_blogger($title){ ?>
	<?php global $photo,$name,$blogger_des,$em_tpldir; ?>
	<h4><em onclick="showhidediv('blogger')"><?php echo $title; ?></em></h4>
	<ul id="blogger">
		<li><?php echo $photo;?></li>
		<li><span id="bloggerdes"><?php echo $blogger_des; ?></span>
		<?php if(ISLOGIN === true): ?>
		<a href="javascript:void(0);" onclick="showhidediv('modbdes','bdes')">
		<img src="<?php echo CERTEMPLATE_URL; ?>/images/modify.gif" align="absmiddle" alt="修改我的状态"/></a></li>
		<li id='modbdes' style="display:none;">
		<textarea name="bdes" class="input" id="bdes" style="overflow-y: hidden;width:160px;height:50px;"><?php echo $blogger_des; ?></textarea>
		<br />
		<a href="javascript:void(0);" onclick="postinfo('<?php echo BLOG_URL; ?>admin/blogger.php?action=update&flg=1','bdes','bloggerdes');">提交</a>
		<a href="javascript:void(0);" onclick="showhidediv('modbdes')">取消</a>
		<?php endif; ?>
		</li>
	</ul>
<?php }?>
<!--日历-->
<?php function widget_calendar($title){ ?>
	<?php global $calendar_url; ?>
	<h4><em onclick="showhidediv('calendar')"><?php echo $title; ?></em></h4>
	<ul>
	<div id="calendar"></div>
	</ul>
	<script>sendinfo('<?php echo $calendar_url;?>','calendar');</script>
<?php }?>
<!--标签-->
<?php function widget_tag($title){ ?>
	<?php global $tag_cache; ?>
	<h4><em onclick="showhidediv('tag')"><?php echo $title; ?></em></h4>
	<ul id="tag">
	<?php foreach($tag_cache as $value): ?>
	<span style="font-size:<?php echo $value['fontsize'];?>pt; height:30px;">
	<a href="<?php echo BLOG_URL; ?>?tag=<?php echo $value['tagurl'];?>"><?php echo $value['tagname'];?></a>
	</span>&nbsp;
	<?php endforeach; ?>	
	</ul>
<?php }?>
<!--分类-->
<?php function widget_sort($title){ ?>
	<?php global $sort_cache,$em_tpldir; ?>
	<h4><em onclick="showhidediv('sort')"><?php echo $title; ?></em></h4>
	<ul id="sort">
	<?php foreach($sort_cache as $value): ?>
	<li>
	<a href="<?php echo BLOG_URL; ?>index.php?sort=<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?>(<?php echo $value['lognum'] ?>)</a>
	<a href="<?php echo BLOG_URL; ?>rss.php?sort=<?php echo $value['sid']; ?>"><img align="absmiddle" src="<?php echo CERTEMPLATE_URL; ?>/images/icon_rss.gif" alt="订阅该分类"/></a>
	</li>
	<?php endforeach; ?>	
	</ul>
<?php }?>
<!--twitter-->
<?php function widget_twitter($title){ ?>
	<?php global $tw_cache,$index_twnum,$localdate,$em_tpldir; ?>
	<?php if($index_twnum>0): ?>
	<h4 onclick="showhidediv('twitter')"><em><?php echo $title; ?></em></h4>
	<ul id="twitter" class="posts">
	<?php if(isset($tw_cache) && is_array($tw_cache)):
	$morebt = count($tw_cache)>$index_twnum?"<li id=\"twdate\"><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=2','twitter')\">更早的&raquo;</a></li>":'';
	foreach (array_slice($tw_cache,0,$index_twnum) as $value):
		$delbt = ISLOGIN === true?"<a href=\"javascript:void(0);\" onclick=\"isdel('{$value['id']}','twitter')\">删除</a>":'';
		$value['date'] = smartyDate($localdate,$value['date']);
	?>
	<li> <?php echo $value['content'];?> <?php echo $delbt;?><br><span><?php echo $value['date'];?></span></li>
	<?php  endforeach; ?>
	<?php echo $morebt; ?>
	<?php endif; ?>
	</ul>
	<?php if(ISLOGIN === true): ?>
	<ul>
	<li><a href="javascript:void(0);" onclick="showhidediv('addtw','tw')">我要唠叨</a></li>
	<li id='addtw' style="display: none;">
	<textarea name="tw" id="tw" style="overflow-y: hidden;width:180px;height:70px;" class="input"></textarea>
	<a href="javascript:void(0);" onclick="postinfo('<?php echo BLOG_URL; ?>twitter.php?action=add','tw','twitter');">提交</a>
	<a href="javascript:void(0);" onclick="showhidediv('addtw')">取消</a>
	</li>
	</ul>
	<?php endif; ?>
	<?php endif; ?>
<?php } ?>
<!--音乐-->
<?php function widget_music($title){ ?>
	<?php global $musicdes,$em_tpldir,$musicurl,$autoplay; ?>
	<h4><em onclick="showhidediv('music')"><?php echo $title; ?></em></h4>
	<ul id="music">
	<?php echo $musicdes;?><object type="application/x-shockwave-flash" data="<?php echo CERTEMPLATE_URL; ?>/images/player.swf?son=<?php echo $musicurl; ?>
	<?php echo $autoplay;?>&autoreplay=1" width="180" height="20"><param name="movie" value="<?php echo CERTEMPLATE_URL; ?>/images/player.swf?son=<?php echo $musicurl; ?>
	<?php echo $autoplay;?>&autoreplay=1" /></object>
	</p>
	</ul>
<?php }?>
<!--最新评论-->
<?php function widget_newcomm($title){ ?>
	<?php global $com_cache,$em_tpldir; ?>
	<h4><em onclick="showhidediv('newcomm')"><?php echo $title; ?></em></h4>
	<ul id="newcomm" class="posts">
	<?php foreach($com_cache as $value): ?>
			<li><?php echo $value['name']; ?> 
	<?php if($value['reply']): ?>
		<a href="<?php echo $value['url']; ?>" title="博主回复：<?php echo $value['reply']; ?>">
		<img src="<?php echo CERTEMPLATE_URL; ?>/images/reply.gif" align="absmiddle"/>
		</a>
	<?php endif;?>
	<br /><a href="<?php echo $value['url'];?>"><?php echo $value['content'];?></a></li>
	<?php endforeach; ?>	
	</ul>
<?php }?>
<!--最新日志-->
<?php function widget_newlog($title){ ?>
	<?php global $newLogs_cache; ?>
	<h4><em onclick="showhidediv('newlog')"><?php echo $title; ?></em></h4>
	<ul id="newlog" class="posts">
	<?php foreach($newLogs_cache as $value): ?>
	<li><a href="<?php echo BLOG_URL; ?>index.php?post=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a></li>
	<?php endforeach; ?>	
	</ul>
<?php }?>
<!--随机日志-->
<?php function widget_random_log($title){ ?>
	<?php 
	global $index_randlognum, $emBlog;
	$randLogs = $emBlog->getRandLog($index_randlognum);
	?>
	<h4><em onclick="showhidediv('randlog')"><?php echo $title; ?></em></h4>
	<ul id="randlog" class="posts">
	<?php foreach($randLogs as $value): ?>
	<li><a href="<?php echo BLOG_URL; ?>index.php?post=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a></li>
	<?php endforeach; ?>	
	</ul>
<?php }?>
<!--归档-->
<?php function widget_archive($title){ ?>
	<?php global $dang_cache; ?>
	<h4><em onclick="showhidediv('record')"><?php echo $title; ?></em></h4>
	<ul class="record" id="record">
	<?php foreach($dang_cache as $value): ?>
	<li><a href="<?php echo $value['url'];?>"><?php echo $value['record'];?>(<?php echo $value['lognum'];?>)</a></li>
	<?php endforeach; ?>	
	</ul>
<?php } ?>
<!--自定义-->
<?php function widget_custom_text($title, $content, $id){ ?>
	<h4><em onclick="showhidediv('<?php echo $id; ?>')"><?php echo $title; ?></em></h4>
	<ul id="<?php echo $id; ?>">
	<p><?php echo $content; ?></p>	
	</ul>	
<?php } ?>
<!--链接-->
<?php function widget_link($title){ ?>
	<?php global $link_cache; ?>
	<h4><em onclick="showhidediv('blogroll')"><?php echo $title; ?></em></h4>
	<ul class="links" id="blogroll">
	<?php foreach($link_cache as $value): ?>     	
			<li><a href="<?php echo $value['url'];?>" title="<?php echo $value['des'];?>" target="_blank"><?php echo $value['link'];?></a></li>
	<?php endforeach; ?>
	</ul>
<?php }?>
<!--信息-->
<?php function widget_bloginfo($title){ ?>
	<?php global $sta_cache,$em_tpldir; ?>
	<h4><em onclick="showhidediv('sta')"><?php echo $title; ?></em></h4>
	<ul class="months" id="sta">
			<li>日志数量：<?php echo $sta_cache['lognum'];?></li>
			<li>评论数量：<?php echo $sta_cache['comnum'];?></li>
			<li>引用数量：<?php echo $sta_cache['tbnum'];?></li>
			<li>今日访问：<?php echo $sta_cache['day_view_count'];?></li>
			<li>总访问量：<?php echo $sta_cache['view_count'];?></li>
			<li><a href="<?php echo BLOG_URL; ?>rss.php"><img src="<?php echo CERTEMPLATE_URL; ?>/images/rss.gif" alt="订阅Rss"/></a></li>
	</ul>
<?php }?>