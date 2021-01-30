<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<!-- Begin Page Content -->
<?php if(isset($_GET['error_a'])):?><span class="alert alert-danger">标签不能为空</span><?php endif;?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">标签修改</h1>
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
</div>
<script>
$("#menu_tag").addClass('active');
</script>
