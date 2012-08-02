<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script type="text/javascript" src="../include/lib/js/jquery/plugin-interface.js"></script>
<script>setTimeout(hideActived,2600);</script>
<div class=containertitle><b><? echo $lang['widgets'];?></b> <span class="title_des">(<? echo $lang['sidebar_widgets']; ?>)</span>
<?php if(isset($_GET['activated'])):?><span class="actived"><? echo $lang['settings_saved_ok']; ?></span><?php endif;?></div>
<div class=line></div>
<div class="widgetpage">
<div id="adm_widget_list">
	<form action="widgets.php?action=setwg&wg=blogger" method="post">
	<div class="widget-line" id="blogger">
		<div class="widget-top">
			<li class="widget-title"><? echo $lang['widget_blogger'];?></li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li><? echo $lang['title'];?></li>
			<li><input type="text" name="title" value="<?php echo $customWgTitle['blogger']; ?>"  /> <input type="submit" name="" value="<? echo $lang['widget_change'];?>" class="submit" /></li>
		</div>
	</div>
	</form>
	<form action="widgets.php?action=setwg&wg=calendar" method="post">
	<div class="widget-line" id="calendar">
		<div class="widget-top">
			<li class="widget-title"><? echo $lang['calendar'];?></li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li><? echo $lang['title'];?></li>
			<li><input type="text" name="title" value="<?php echo $customWgTitle['calendar']; ?>"  /> <input type="submit" name="" value="<? echo $lang['widget_change'];?>" class="submit" /></li>
		</div>
	</div>
	</form>
	<form action="widgets.php?action=setwg&wg=twitter" method="post">
	<div class="widget-line" id="twitter">
		<div class="widget-top">
			<li class="widget-title"><? echo $lang['twitters_last']; ?></li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li><? echo $lang['title']; ?></li>
			<li><input type="text" name="title" value="<?php echo $customWgTitle['twitter']; ?>"  /></li>
			<li><? echo $lang['twitters_last_info']; ?></li>
			<li><input maxlength="5" size="10" value="<?php echo Option::get('index_newtwnum'); ?>" name="index_newtwnum" /> <input type="submit" name="" value="<? echo $lang['change'];?>" class="submit" /></li>
		</div>
	</div>
	</form>
	<form action="widgets.php?action=setwg&wg=tag" method="post">
	<div class="widget-line" id="tag">
		<div class="widget-top">
			<li class="widget-title"><? echo $lang['tags'];?></li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li><? echo $lang['title'];?></li>
			<li><input type="text" name="title" value="<?php echo $customWgTitle['tag']; ?>"  /> <input type="submit" name="" value="<? echo $lang['widget_change'];?>" class="submit" /></li>
		</div>
	</div>
	</form>
	<form action="widgets.php?action=setwg&wg=sort" method="post">
	<div class="widget-line" id="sort">
		<div class="widget-top">
			<li class="widget-title"><? echo $lang['categories'];?></li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li><? echo $lang['title'];?></li>
			<li><input type="text" name="title" value="<?php echo $customWgTitle['sort']; ?>"  /> <input type="submit" name="" value="<? echo $lang['widget_change'];?>" class="submit" /></li>
		</div>
	</div>
	</form>
	<form action="widgets.php?action=setwg&wg=archive" method="post">
	<div class="widget-line" id="archive">
		<div class="widget-top">
			<li class="widget-title"><? echo $lang['archive'];?></li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li><? echo $lang['title'];?></li>
			<li><input type="text" name="title" value="<?php echo $customWgTitle['archive']; ?>"  /> <input type="submit" name="" value="<? echo $lang['widget_change'];?>" class="submit" /></li>
		</div>
	</div>
	</form>
	<form action="widgets.php?action=setwg&wg=newcomm" method="post">
	<div class="widget-line" id="newcomm">
		<div class="widget-top">
			<li class="widget-title"><? echo $lang['latest_comments'];?></li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li><? echo $lang['title'];?></li>
			<li><input type="text" name="title" value="<?php echo $customWgTitle['newcomm']; ?>"  /></li>
			<li><? echo $lang['comments_latest_number'];?></li>
			<li><input maxlength="5" size="10" value="<?php echo Option::get('index_comnum'); ?>" name="index_comnum" /></li>
			<li><? echo $lang['comments_trim_length'];?></li>
			<li><input maxlength="5" size="10" value="<?php echo Option::get('comment_subnum'); ?>" name="comment_subnum" /> <input type="submit" name="" value="<? echo $lang['widget_change'];?>" class="submit" /></li>
		</div>
	</div>
	</form>
	<form action="widgets.php?action=setwg&wg=newlog" method="post">
	<div class="widget-line" id="newlog">
		<div class="widget-top">
			<li class="widget-title"><? echo $lang['latest_posts'];?></li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li><? echo $lang['title'];?></li>
			<li><input type="text" name="title" value="<?php echo $customWgTitle['newlog']; ?>"  /></li>
			<li><? echo $lang['latest_posts_number'];?></li>
			<li><input maxlength="5" size="10" value="<?php echo Option::get('index_newlognum'); ?>" name="index_newlog" /> <input type="submit" name="" value="<? echo $lang['widget_change'];?>" class="submit" /></li>
		</div>
	</div>
	</form>
	<form action="widgets.php?action=setwg&wg=random_log" method="post">
	<div class="widget-line" id="random_log">
		<div class="widget-top">
			<li class="widget-title"><? echo $lang['random_posts'];?></li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li><? echo $lang['title'];?></li>
			<li><input type="text" name="title" value="<?php echo $customWgTitle['random_log']; ?>"  /></li>
			<li><? echo $lang['random_posts_number'];?></li>
			<li><input maxlength="5" size="10" value="<?php echo Option::get('index_randlognum'); ?>" name="index_randlognum" /> <input type="submit" name="" value="<? echo $lang['widget_change'];?>" class="submit" /></li>
		</div>
	</div>
	</form>
	<form action="widgets.php?action=setwg&wg=link" method="post">
	<div class="widget-line" id="link">
		<div class="widget-top">
			<li class="widget-title"><? echo $lang['links'];?></li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li><? echo $lang['title'];?></li>
			<li><input type="text" name="title" value="<?php echo $customWgTitle['link']; ?>"  /> <input type="submit" name="" value="<? echo $lang['widget_change'];?>" class="submit" /></li>
		</div>
	</div>
	</form>
	<form action="widgets.php?action=setwg&wg=search" method="post">
	<div class="widget-line" id="search">
		<div class="widget-top">
			<li class="widget-title"><? echo $lang['search'];?></li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li><? echo $lang['title'];?></li>
			<li><input type="text" name="title" value="<?php echo $customWgTitle['search']; ?>"  /> <input type="submit" name="" value="<? echo $lang['widget_change'];?>" class="submit" /></li>
		</div>
	</div>
	</form>
	<div class="wg_line"><? echo $lang['widgets_custom']; ?></div>
	<?php
	foreach ($custom_widget as $key=>$val): 
	preg_match("/^custom_wg_(\d+)/", $key, $matches);
	$custom_wg_title = empty($val['title']) ? $lang['widget_custom'].' ('.$matches[1].')' : $val['title'];
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
			<li><input type="submit" name="" value="<? echo $lang['widget_change'];?>" />
			<span style="margin-left:235px;"><a href="widgets.php?action=setwg&wg=custom_text&rmwg=<?php echo $key; ?>"><? echo $lang['widget_delete'];?></a></span></li>
		</div>
	</div>
	</form>
	<?php endforeach;?>
	<form action="widgets.php?action=setwg&wg=custom_text" method="post">
	<div class="wg_line2"><a href="javascript:displayToggle('custom_text_new', 2);"><? echo $lang['widget_new'];?>+</a></div>
	<div id="custom_text_new">
		<li><? echo $lang['widget_name'];?></li>
		<li><input type="text" name="new_title" style="width:380px;" value="" /></li>
		<li><? echo $lang['widget_content'];?></li>
		<li><textarea name="new_content" rows="10" style="width:380px;overflow:auto;"></textarea></li>
		<li><input type="submit" name="" value="<? echo $lang['widget_add'];?>"  />
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
<option value="<?php echo $i;?>" selected><? echo $lang['sidebar'];?><?php echo $i;?></option>
<?php else:?>
<option value="<?php echo $i;?>"><? echo $lang['sidebar'];?><?php echo $i;?></option>
<?php endif;endfor;?>
</select>
</p>
<?php endif;?>
<ul>
<?php 
	foreach ($widgets as $widget):
	$flg = strpos($widget, 'custom_wg_') === 0 ? true : false;//Whether the widget is a custom widget
	$title = ($flg && isset($custom_widget[$widget]['title'])) ? $custom_widget[$widget]['title'] : ''; //Get custom widget title
	if($flg && empty($title)){
		preg_match("/^custom_wg_(\d+)/", $widget, $matches);
		$title = $lang['widget_custom'].' ('.$matches[1].')';
	}	
	?>
	<li class="sortableitem" id="em_<?php echo $widget; ?>">
	<input type="hidden" name="widgets[]" value="<?php echo $widget; ?>" />
	<?php 
	if ($flg){
		echo $title;
	}else{
		echo $widgetTitle[$widget];
	}?>
	</li>
<?php endforeach;?>
</ul>
<input type="hidden" name="wgnum" id="wgnum" value="<?php echo $wgNum; ?>" />
<div style="margin:20px 40px;"><input type="submit" value="<? echo $lang['widgets_order_save'];?>" class="submit" /></div>
<div style="margin:10px 40px;"><a href="http://www.emlog.net/extend/widgets" target="_blank"><? echo $lang['widget_repository']; ?>&raquo;</a></div>
<div style="margin:10px 40px;"><a href="javascript: em_confirm(0, 'reset_widget');"><? echo $lang['plugin_reset']; ?>&raquo;</a></div>
</div>
</form>
</div>
<script>
$(document).ready(function(){
	$("#custom_text_new").css('display', $.cookie('em_custom_text_new') ? $.cookie('em_custom_text_new') : 'none');
	var widgets = $(".sortableitem").map(function(){return $(this).attr("id");});
	$.each(widgets,function(i,widget_id){
		var widget_id = widget_id.substring(3);
		$("#"+widget_id+" .widget-act-add").hide();
		$("#"+widget_id+" .widget-act-del").show();
	});
	//show edit form
	$("#adm_widget_list .widget-title").click(
		function(){$(this).parent().next(".widget-control").slideToggle('fast');}
	);
	//add widget
	$("#adm_widget_list .widget-act-add").click(function(){
		var wgnum = $("#wgnum").val();
		var title = $(this).prevAll(".widget-title").html();
		var widget_id = $(this).parent().parent().attr("id");
		var widget_element = "<li class=\"sortableitem\" id=\"em_"+widget_id+"\">"+title+"<input type=\"hidden\" name=\"widgets[]\" value=\""+widget_id+"\" /></li>";
		$("#adm_widget_box ul").append(widget_element);
		$(this).hide();
		$(this).next(".widget-act-del").show();
	});
	//remove widget
	$("#adm_widget_list .widget-act-del").click(function(){
		var widget_id = $(this).parent().parent().attr("id");
		$("#adm_widget_box ul #em_" + widget_id).remove();
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