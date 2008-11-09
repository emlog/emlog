<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
<script type="text/javascript" src="../lib/js/jquery/plugin-interface.js"></script>
<div class=containertitle><b>Widget 管理</b></div>
<div class=line></div>

<div id="adm_widget_list">
	<div class="widget-line" id="blogger">
		<div class="widget-top">
			<li class="widget-title">Blogger</li>
			<li class="widget-act-edit"><a href="javascript:void(0);">编辑</a></li>
			<li class="widget-act-add"><a href="javascript:void(0);">添加</a></li>
			<li class="widget-act-del"><a href="javascript:void(0);">移除</a></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="blogger_title" value=""  /> <input type="button" name="" value="更改"  /></li>
		</div>
	</div>
	<div class="widget-line" id="calendar">
		<div class="widget-top">
			<li class="widget-title">日历</li>
			<li class="widget-act-edit"><a href="javascript:void(0);">编辑</a></li>
			<li class="widget-act-add"><a href="javascript:void(0);">添加</a></li>
			<li class="widget-act-del"><a href="javascript:void(0);">移除</a></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="calander_title" value=""  /> <input type="button" name="" value="更改"  /></li>
		</div>
	</div>
	<div class="widget-line" id="tag">
		<div class="widget-top">
			<li class="widget-title">标签</li>
			<li class="widget-act-edit"><a href="javascript:void(0);">编辑</a></li>
			<li class="widget-act-add"><a href="javascript:void(0);">添加</a></li>
			<li class="widget-act-del"><a href="javascript:void(0);">移除</a></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="tag_title" value=""  /> <input type="button" name="" value="更改"  /></li>
		</div>
	</div>
	<div class="widget-line" id="twitter">
		<div class="widget-top">
			<li class="widget-title">Twitter</li>
			<li class="widget-act-edit"><a href="javascript:void(0);">编辑</a></li>
			<li class="widget-act-add"><a href="javascript:void(0);">添加</a></li>
			<li class="widget-act-del"><a href="javascript:void(0);">移除</a></li>
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
			<li class="widget-act-edit"><a href="javascript:void(0);">编辑</a></li>
			<li class="widget-act-add"><a href="javascript:void(0);">添加</a></li>
			<li class="widget-act-del"><a href="javascript:void(0);">移除</a></li>
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
			<li class="widget-act-edit"><a href="javascript:void(0);">编辑</a></li>
			<li class="widget-act-add"><a href="javascript:void(0);">添加</a></li>
			<li class="widget-act-del"><a href="javascript:void(0);">移除</a></li>
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
			<li class="widget-act-edit"><a href="javascript:void(0);">编辑</a></li>
			<li class="widget-act-add"><a href="javascript:void(0);">添加</a></li>
			<li class="widget-act-del"><a href="javascript:void(0);">移除</a></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="archive_title" value=""  /> <input type="button" name="" value="更改"  /></li>
		</div>
	</div>
	<div class="widget-line" id="link">
		<div class="widget-top">
			<li class="widget-title">友情链接</li>
			<li class="widget-act-edit"><a href="javascript:void(0);">编辑</a></li>
			<li class="widget-act-add"><a href="javascript:void(0);">添加</a></li>
			<li class="widget-act-del"><a href="javascript:void(0);">移除</a></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="link_title" value=""  /> <input type="button" name="" value="更改"  /></li>
		</div>
	</div>
	<div class="widget-line" id="bloginfo">
		<div class="widget-top">
			<li class="widget-title">博客信息</li>
			<li class="widget-act-edit"><a href="javascript:void(0);">编辑</a></li>
			<li class="widget-act-add"><a href="javascript:void(0);">添加</a></li>
			<li class="widget-act-del"><a href="javascript:void(0);">移除</a></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="bloginfo_title" value=""  /> <input type="button" name="" value="更改"  /></li>
		</div>
	</div>
	<div class="widget-line" id="custom_text">
		<div class="widget-top">
			<li class="widget-title">自定义栏目</li>
			<li class="widget-act-edit"><a href="javascript:void(0);">编辑</a></li>
			<li class="widget-act-add"><a href="javascript:void(0);">添加</a></li>
			<li class="widget-act-del"><a href="javascript:void(0);">移除</a></li>
		</div>
		<div class="widget-control">
			<li>标题</li>
			<li><input type="text" name="text_title" value=""  /> <input type="button" name="" value="更改"  /></li>
		</div>
	</div>
</div>
<form action="widgets.php?action=compages" method="post" name="input" id="input">
<div id="adm_widget_box">
	<ul>
	</ul>
	<div>
	<input type="submit" value="确 定" class="submit2" />
	</div>
</div>
</form>
<div id="widgets_str" style="display:none;"><?php echo $widgetsStr; ?></div>
<script type="text/javascript">
$(document).ready(function(){

	//json
	var widget_str = $("#widgets_str").text();
	var widgets = widget_str.split(",");
	$.each(widgets,function(i,n)
	{
		$("#"+n+" .widget-act-add").hide();
		var title = $("#"+n+" .widget-title").text();
		var widget_element = "<li class=\"sortableitem\" id=\""+n+"\"><span>"+title+"</span><input type=\"hidden\" name=\"widgets[]\" value=\""+n+"\" /></li>";
		$("#adm_widget_box ul").append(widget_element);
	}
	);

	$("#adm_widget_list .widget-act-edit").toggle(
	function(){$(this).parent().next(".widget-control").show("fast")},
	function(){$(this).parent().next(".widget-control").hide("fast")}
	);
	$("#adm_widget_list .widget-act-add").click(function()
	{
		var title = $(this).prevAll(".widget-title").text();
		var widget_id = $(this).parent().parent().attr("id");
		var widget_element = "<li class=\"sortableitem\" id=\""+widget_id+"\"><span>"+title+"</span><input type=\"hidden\" name=\"widgets[]\" value=\""+widget_id+"\" /></li>";
		$("#adm_widget_box ul").append(widget_element);
		$(this).hide();
		$(this).next(".widget-act-del").show();
	}
	);
	$("#adm_widget_list .widget-act-del").click(function()
	{
		var widget_id = $(this).parent().parent().attr("id");
		$("#adm_widget_box ul #" + widget_id).remove();
		$(this).hide();
		$(this).prev(".widget-act-add").show();
	}
	);
	$("#adm_widget_box").mouseover(function(){
		$("#adm_widget_box ul").Sortable(
		{
			accept : 		'sortableitem',
			helperclass : 	'sortHelper',
			activeclass : 	'sortableactive',
			hoverclass : 	'sortablehover',
			opacity: 		0.8,
			floats: true,
			revert:	true
		}
		)
	});
});
</script>

