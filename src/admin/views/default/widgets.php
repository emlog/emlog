<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
<script type='text/javascript'>
$(document).ready(function(){
$("#adm_widget_list .widget-act a").eq(0).toggle(
function(){$(this).parent().parent().next(".widget-control").css("display","block")},
function(){$(this).parent().parent().next(".widget-control").css("display","none")}
)
})
</script>
<div class=containertitle><b>Widget 管理</b></div>
<div class=divne></div>

<div id="adm_widget_list">

	<div class="widget-line">
		<div class="widget-top">
			<li class="widget-title">Twitter</li>
			<li class="widget-des">这里是一些介绍性的文字</li>
			<li class="widget-act"><a href="javascript:void(0);">设置</a> <a>添加</a></li>
		</div>
		<div class="widget-control">
			<li>该 Widget 没有可设置选项。</li>
			<input type="hidden" name="widget-id[]" value="links" />
			<input type="hidden" class="widget-width" value="" />
		</div>
	</div>
	<div class="widget-line">
		<div class="widget-top">
			<li class="widget-title">Twitter</li>
			<li class="widget-des">这里是一些介绍性的文字</li>
			<li class="widget-act"><a href="javascript:void(0);">设置</a> <a>添加</a></li>
		</div>
		<div class="widget-control">
			<li>该 Widget 没有可设置选项。</li>
			<input type="hidden" name="widget-id[]" value="links" />
			<input type="hidden" class="widget-width" value="" />
		</div>
	</div>

</div>
<div id="adm_widget_box">
<ul>
<div></div>
</ul>
</div>

