<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b>标签修改</b>
<?php if(isset($_GET['error_a'])):?><span class="error">标签不能为空</span><?php endif;?>
</div>
<div class=line></div>
<form  method="post" action="tag.php?action=update_tag">
<div>
<li><input size="40" value="<?php echo $tagname; ?>" name="tagname" class="input" /></li>
<li style="margin:10px 0px">
<input type="hidden" value="<?php echo $tagid; ?>" name="tid" />
<input type="submit" value="保 存" class="button" />
<input type="button" value="取 消" class="button" onclick="javascript: window.location='tag.php';"/>
</li>
</div>
</form>
<script>
$("#menu_tag").addClass('sidebarsubmenu1');
</script>