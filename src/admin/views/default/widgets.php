<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script type="text/javascript" src="../lib/js/jquery/plugin-interface.js"></script>
<script>setTimeout(hideActived,2600);</script>
<div class=containertitle><b>Widgets</b><span class="title_des">(侧边栏组件管理)</span>
<?php if(isset($_GET['activated'])):?><span class="actived">设置保存成功</span><?php endif;?></div>
<div class=line></div>
<div class="widgetpage">
<div id="adm_widget_list">
	<form action="widgets.php?action=setwg&wg=blogger" method="post">
	<div class="widget-line" id="blogger">
		<div class="widget-top">
			<li class="widget-title">blogger</li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="title" value="<?php echo $customWgTitle['blogger']; ?>"  /> <input type="submit" name="" value="更改" class="submit" /></li>
			<li><a href="blogger.php">修改个人资料...</a></li>
		</div>
	</div>
	</form>
	<form action="widgets.php?action=setwg&wg=calendar" method="post">
	<div class="widget-line" id="calendar">
		<div class="widget-top">
			<li class="widget-title">日历</li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="title" value="<?php echo $customWgTitle['calendar']; ?>"  /> <input type="submit" name="" value="更改" class="submit" /></li>
		</div>
	</div>
	</form>
	<form action="widgets.php?action=setwg&wg=twitter" method="post">
	<div class="widget-line" id="twitter">
		<div class="widget-top">
			<li class="widget-title">碎语</li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="title" value="<?php echo $customWgTitle['twitter']; ?>"  /></li>
			<li>首页显示最新碎语数</li>
			<li><input maxlength="5" size="10" value="<?php echo $index_newtwnum; ?>" name="index_newtwnum" /> <input type="submit" name="" value="更改" class="submit" /></li>
		</div>
	</div>
	</form>
	<form action="widgets.php?action=setwg&wg=tag" method="post">
	<div class="widget-line" id="tag">
		<div class="widget-top">
			<li class="widget-title">标签</li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="title" value="<?php echo $customWgTitle['tag']; ?>"  /> <input type="submit" name="" value="更改" class="submit" /></li>
		</div>
	</div>
	</form>
	<form action="widgets.php?action=setwg&wg=sort" method="post">
	<div class="widget-line" id="sort">
		<div class="widget-top">
			<li class="widget-title">分类</li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="title" value="<?php echo $customWgTitle['sort']; ?>"  /> <input type="submit" name="" value="更改" class="submit" /></li>
		</div>
	</div>
	</form>
	<form action="widgets.php?action=setwg&wg=archive" method="post">
	<div class="widget-line" id="archive">
		<div class="widget-top">
			<li class="widget-title">存档</li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="title" value="<?php echo $customWgTitle['archive']; ?>"  /> <input type="submit" name="" value="更改" class="submit" /></li>
		</div>
	</div>
	</form>
	<form action="widgets.php?action=setwg&wg=newcomm" method="post">
	<div class="widget-line" id="newcomm">
		<div class="widget-top">
			<li class="widget-title">最新评论</li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="title" value="<?php echo $customWgTitle['newcomm']; ?>"  /></li>
			<li>首页最新评论数</li>
			<li><input maxlength="5" size="10" value="<?php echo $index_comnum; ?>" name="index_comnum" /></li>
			<li>新近评论截取字节数</li>
			<li><input maxlength="5" size="10" value="<?php echo $comment_subnum; ?>" name="comment_subnum" /> <input type="submit" name="" value="更改" class="submit" /></li>
		</div>
	</div>
	</form>
	<form action="widgets.php?action=setwg&wg=newlog" method="post">
	<div class="widget-line" id="newlog">
		<div class="widget-top">
			<li class="widget-title">最新日志</li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="title" value="<?php echo $customWgTitle['newlog']; ?>"  /></li>
			<li>首页显示最新日志数</li>
			<li><input maxlength="5" size="10" value="<?php echo $index_newlognum; ?>" name="index_newlog" /> <input type="submit" name="" value="更改" class="submit" /></li>
		</div>
	</div>
	</form>
	<form action="widgets.php?action=setwg&wg=random_log" method="post">
	<div class="widget-line" id="random_log">
		<div class="widget-top">
			<li class="widget-title">随机日志</li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="title" value="<?php echo $customWgTitle['random_log']; ?>"  /></li>
			<li>首页显示随机日志数</li>
			<li><input maxlength="5" size="10" value="<?php echo $index_randlognum; ?>" name="index_randlognum" /> <input type="submit" name="" value="更改" class="submit" /></li>
		</div>
	</div>
	</form>
	<form action="widgets.php?action=setwg&wg=music" method="post">
	<div class="widget-line" id="music">
		<div class="widget-top">
			<li class="widget-title">音乐</li>
			<li class="widget-act-add"> </li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="title" value="<?php echo $customWgTitle['music']; ?>"  /></li>
			<li>音乐链接：(每行一条，仅支持mp3格式)</li>
			<li>(如：http://www.emlog.net/a.mp3 音乐介绍)</li>
			<li><textarea name="mlinks" rows="6" wrap="off" style="width:350px;overflow:auto;"><?php echo $content; ?></textarea></li>
			<li>启用随机播放：
		      <input type="radio" value="1" name="randplay" <?php echo $randplay1; ?>/>是
			  <input type="radio" value="0" name="randplay" <?php echo $randplay2; ?>/>否
			</li>
			<li>启用自动播放：
		      <input type="radio" value="1" name="auto" <?php echo $auto1; ?>/>是
			  <input type="radio" value="0" name="auto" <?php echo $auto2; ?>/>否
			</li>
			<li><input type="submit" value="确 定" class="submit" /></li>
		</div>
	</div>
	</form>
	<form action="widgets.php?action=setwg&wg=link" method="post">
	<div class="widget-line" id="link">
		<div class="widget-top">
			<li class="widget-title">链接</li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="title" value="<?php echo $customWgTitle['link']; ?>"  /> <input type="submit" name="" value="更改" class="submit" /></li>
		</div>
	</div>
	</form>
	<form action="widgets.php?action=setwg&wg=search" method="post">
	<div class="widget-line" id="search">
		<div class="widget-top">
			<li class="widget-title">搜索</li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="title" value="<?php echo $customWgTitle['search']; ?>"  /> <input type="submit" name="" value="更改" class="submit" /></li>
		</div>
	</div>
	</form>
	<form action="widgets.php?action=setwg&wg=bloginfo" method="post">
	<div class="widget-line" id="bloginfo">
		<div class="widget-top">
			<li class="widget-title">信息</li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="title" value="<?php echo $customWgTitle['bloginfo']; ?>"  /> <input type="submit" name="" value="更改" class="submit" /></li>
		</div>
	</div>
	<div class="wg_line">自定义组件</div>
	</form>
	<?php
	foreach ($custom_widget as $key=>$val): 
	preg_match("/^custom_wg_(\d+)/", $key, $matches);
	$custom_wg_title = empty($val['title']) ? '未命名组件('.$matches[1].')' : $val['title'];
	?>
	<form action="widgets.php?action=setwg&wg=custom_text" method="post">
	<div class="widget-line" id="<?php echo $key; ?>">
		<div class="widget-top">
			<li class="widget-title"><?php echo $custom_wg_title; ?></li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li>
			<input type="hidden" name="custom_wg_id" value="<?php echo $key; ?>" />
			<input type="text" name="title" style="width:345px;" value="<?php echo $val['title']; ?>" />
			</li>
			<li><textarea name="content" rows="8" style="width:345px;overflow:auto;"><?php echo $val['content']; ?></textarea></li>
			<li><input type="submit" name="" value="更改" />
			<span style="margin-left:235px;"><a href="widgets.php?action=setwg&wg=custom_text&rmwg=<?php echo $key; ?>">删除该组件</a></span></li>
		</div>
	</div>
	</form>
	<?php endforeach;?>
	<form action="widgets.php?action=setwg&wg=custom_text" method="post">
	<div class="wg_line2"><a href="javascript:displayToggle('custom_text_new', 2);">自定义一个新的组件&raquo;</a></div>
	<div id="custom_text_new">
		<li>组件名</li>
		<li><input type="text" name="new_title" style="width:380px;" value="" /></li>
		<li>内容 （支持html）</li>
		<li><textarea name="new_content" rows="10" style="width:380px;overflow:auto;"></textarea></li>
		<li><input type="submit" name="" value="添加组件"  />
		<span style="margin-left:158px;"><a href="http://www.emlog.net/extend/widgets" target="_blank">获取更多有趣的组件&raquo;</a></span></li>
	</div>
	</form>
</div>
<form action="widgets.php?action=compages" method="post">
<div id="adm_widget_box">
<?php if($tpl_sidenum > 1):?>
<p>
<select id="wg_select">
<?php for ($i=1; $i<=$tpl_sidenum; $i++):
if($i == $wgNum):
?>
<option value="<?php echo $i;?>" selected>侧边栏<?php echo $i;?></option>
<?php else:?>
<option value="<?php echo $i;?>">侧边栏<?php echo $i;?></option>
<?php endif;endfor;?>
</select>
</p>
<?php endif;?>
<ul>
<?php 
	foreach ($widgets as $widget):
	$flg = strpos($widget, 'custom_wg_') === 0 ? true : false;//是否为自定义组件
	$title = ($flg && isset($custom_widget[$widget]['title'])) ? $custom_widget[$widget]['title'] : '';	//获取自定义组件标题
	if($flg && empty($title))
	{
		preg_match("/^custom_wg_(\d+)/", $widget, $matches);
		$title = '未命名组件('.$matches[1].')';
	}	
	?>
	<li class="sortableitem" id="<?php echo $widget; ?>">
	<input type="hidden" name="widgets[]" value="<?php echo $widget; ?>" />
	<?php 
	if ($flg)
	{
		echo $title;
	}else{
		echo $widgetTitle[$widget];
	}?>
	</li>
<?php endforeach;?>
</ul>
<input type="hidden" name="wgnum" id="wgnum" value="<?php echo $wgNum; ?>" />
<div style="margin:10px 40px;"><input type="submit" value="保存组件排序" class="submit" /></div>
</div>
</form>
</div>
<script>
$(document).ready(function(){
	$("#custom_text_new").css('display', $.cookie('em_custom_text_new') ? $.cookie('em_custom_text_new') : 'none');
	var widgets = $(".sortableitem").map(function(){return $(this).attr("id");});
	$.each(widgets,function(i,widget_id){
		$("#"+widget_id+" .widget-act-add").hide();
		$("#"+widget_id+" .widget-act-del").show();
	});
	//show edit form
	$("#adm_widget_list .widget-title").toggle(
		function(){$(this).parent().next(".widget-control").show("fast")},
		function(){$(this).parent().next(".widget-control").hide("fast")}
	);
	//add widget
	$("#adm_widget_list .widget-act-add").click(function(){
		var wgnum = $("#wgnum").val();
		var title = $(this).prevAll(".widget-title").html();
		var widget_id = $(this).parent().parent().attr("id");
		var widget_element = "<li class=\"sortableitem\" id=\""+widget_id+"\">"+title+"<input type=\"hidden\" name=\"widgets[]\" value=\""+widget_id+"\" /></li>";
		$("#adm_widget_box ul").append(widget_element);
		$(this).hide();
		$(this).next(".widget-act-del").show();
	});
	//remove widget
	$("#adm_widget_list .widget-act-del").click(function(){
		var widget_id = $(this).parent().parent().attr("id");
		$("#adm_widget_box ul #" + widget_id).remove();
		$(this).hide();
		$(this).prev(".widget-act-add").show();
	});
	//move
	$("#adm_widget_box ul").mouseover(function(){
		$("#adm_widget_box ul").Sortable({
			accept: 'sortableitem'
		});
	});
	$("#wg_select").change(function(){
		window.location = "widgets.php?wg="+$(this).val();
	});
	$("#menu_widget").addClass('sidebarsubmenu1');
});
</script>