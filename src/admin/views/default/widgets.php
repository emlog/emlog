<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
<script type="text/javascript" src="../lib/js/jquery/plugin-interface.js"></script>
<div class=containertitle><b>Widget 管理</b></div>
<div class=line></div>
<div class="widgetpage">
<div id="adm_widget_list">
	<div class="widget-line" id="blogger">
		<div class="widget-top">
			<li class="widget-title">Blogger</li>
			<li class="widget-act-add"> </li>
			<li class="widget-act-del"> </li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="blogger_title" value=""  /> <input type="button" name="" value="更改"  /></li>
		</div>
	</div>
	<div class="widget-line" id="calendar">
		<div class="widget-top">
			<li class="widget-title">日历</li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="calander_title" value=""  /> <input type="button" name="" value="更改"  /></li>
		</div>
	</div>
	<div class="widget-line" id="tag">
		<div class="widget-top">
			<li class="widget-title">标签</li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="tag_title" value=""  /> <input type="button" name="" value="更改"  /></li>
		</div>
	</div>
	<div class="widget-line" id="twitter">
		<div class="widget-top">
			<li class="widget-title">Twitter</li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="twitter_title" value=""  /></li>
			<li>首页显示twitter数</li>
			<li><input class="input_line" maxlength="5" size="10" value="<?php echo $index_twnum; ?>" name="index_twnum" /> <input type="button" name="" value="更改"  /></li>
		</div>
	</div>
	<div class="widget-line" id="music">
		<div class="widget-top">
			<li class="widget-title">背景音乐</li>
			<li class="widget-act-add"> </li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="music_title" value=""  /></li>
			<li><input type="button" name="" value="更改"  /></li>
		</div>
	</div>
	<div class="widget-line" id="newcomm">
		<div class="widget-top">
			<li class="widget-title">最新评论</li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="newcomm_title" value=""  /></li>
			<li>首页最新评论数</li>
			<li><input class="input_line" maxlength="5" size="10" value="<?php echo $index_comnum; ?>" name="index_comnum" /></li>
			<li>新近评论截取字节数</li>
			<li><input class="input_line" maxlength="5" size="10" value="<?php echo $comment_subnum; ?>" name="comment_subnum" /> <input type="button" name="" value="更改"  /></li>
		</div>
	</div>
	<div class="widget-line" id="archive">
		<div class="widget-top">
			<li class="widget-title">日志存档</li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="archive_title" value=""  /> <input type="button" name="" value="更改"  /></li>
		</div>
	</div>
	<div class="widget-line" id="link">
		<div class="widget-top">
			<li class="widget-title">友情链接</li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="link_title" value=""  /> <input type="button" name="" value="更改"  /></li>
		</div>
	</div>
	<div class="widget-line" id="bloginfo">
		<div class="widget-top">
			<li class="widget-title">博客信息</li>
			<li class="widget-act-add"></li>
			<li class="widget-act-del"></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="bloginfo_title" value=""  /> <input type="button" name="" value="更改"  /></li>
		</div>
	</div>
	<div class="widget-line" id="custom_text">
		<div class="widget-top">
			<li class="widget-title">自定义栏目</li>
			<li class="widget-act-add"></li>
		</div>
	</div>
</div>
<form action="widgets.php?action=compages" method="post" name="input" id="input">
<div id="adm_widget_box">
	<ul>
	</ul>
	<div style="margin:10px 40px;">
	<input type="submit" value="确 定" class="submit2" />
	</div>
</div>
</form>
<div id="widgets_str" style="display:none;"><?php echo $widgetsStr; ?></div>
</div>
<script>
$(document).ready(function(){
	var widget_str = $("#widgets_str").text();
	var widgets = widget_str.split(",");
	$.each(widgets,function(i,widget_id)
	{
		if(widget_id != 'custom_text'){
			$("#"+widget_id+" .widget-act-add").hide();
		}
		$("#"+widget_id+" .widget-act-del").show();
		var title = $("#"+widget_id+" .widget-title").text();
		var wg_edit = widget_id=='custom_text' ? "<span class=\"wgbox_edit\">编辑</span> <span class=\"wgbox_del\">移除</span>" : '';
		var wg_text = widget_id=='custom_text' ? "<span class=\"wgbox_text\"><textarea name=\"sssss\"></textarea></span>" : '';
		var widget_element = "<li class=\"sortableitem\" id=\"wg_"+widget_id+"\"><span class=\"wgbox_title\">"+title+"</span>"+wg_edit+wg_text+"<input type=\"hidden\" name=\"widgets[]\" value=\""+widget_id+"\" /></li>";
		$("#adm_widget_box ul").append(widget_element);
	}
	);
	
	//show edit form
	$("#adm_widget_list .widget-title").toggle
	(
	function(){$(this).parent().next(".widget-control").show("fast")},
	function(){$(this).parent().next(".widget-control").hide("fast")}
	);
	//add widget
	$("#adm_widget_list .widget-act-add").click(function()
	{
		var title = $(this).prevAll(".widget-title").text();
		var widget_id = $(this).parent().parent().attr("id");
		var wg_edit = widget_id=='custom_text' ? "<span class=\"wgbox_edit\">编辑</span> <span class=\"wgbox_del\">移除</span>" : '';
		var wg_text = widget_id=='custom_text' ? "<span class=\"wgbox_text\"><textarea name=\"sssss\"></textarea></span>" : '';
		var widget_element = "<li class=\"sortableitem\" id=\"wg_"+widget_id+"\"><span class=\"wgbox_title\">"+title+"</span>"+wg_edit+wg_text+"<input type=\"hidden\" name=\"widgets[]\" value=\""+widget_id+"\" /></li>";
		$("#adm_widget_box ul").append(widget_element);
		if(widget_id != 'custom_text'){
			$(this).hide();
		}
		$(this).next(".widget-act-del").show();
		//$(".wgbox_edit").bind("click", abc);
	}
	);
	//remove widget
	$("#adm_widget_list .widget-act-del").click(function()
	{
		var widget_id = $(this).parent().parent().attr("id");
		$("#adm_widget_box ul #wg_" + widget_id).remove();
		$(this).hide();
		$(this).prev(".widget-act-add").show();
	}
	);
	//move
	$("#adm_widget_box").mouseover(function(){
		$("#adm_widget_box ul").Sortable(
		{
			accept: 'sortableitem',
			handle: 'span.wgbox_title'
		}
		);
	});
	
	var abc = function(){
		$(".wgbox_edit").click(function(event)
		{
			$(this).parent().find(".wgbox_text textarea").toggle("fast");
			event.stopPropagation();
		});
		$(".wgbox_del").click(function()
		{
			$(this).parent().remove();
		});
	}
	abc();
	//$(".wgbox_edit").bind("click", abc);
});
</script>

