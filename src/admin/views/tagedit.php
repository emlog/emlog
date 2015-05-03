<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="containertitle"><b>标签修改</b>
<?php if(isset($_GET['error_a'])):?><span class="alert alert-danger">标签不能为空</span><?php endif;?>
</div>
<div class=line></div>
<form  method="post" action="tag.php?action=update_tag" class="form-inline">
<div class="form-group">
    <li><input size="40" value="<?php echo $tagname; ?>" name="tagname" class="form-control" /></li>
    <li style="margin:10px 0px">
    <input type="hidden" value="<?php echo $tagid; ?>" name="tid" />
    <input type="submit" value="保 存" class="btn btn-primary" />
    <input type="button" value="取 消" class="btn btn-default" onclick="javascript: window.location='tag.php';"/>
    </li>
</div>
</form>
<script>
$("#menu_tag").addClass('active');
</script>
