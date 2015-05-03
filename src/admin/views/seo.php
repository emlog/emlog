<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class="panel-heading">
<ul class="nav nav-tabs" role="tablist">
  <li role="presentation"><a href="./configure.php">基本设置</a></li>
  <li role="presentation" class="active"><a href="./seo.php">SEO设置</a></li>
  <li role="presentation"><a href="./blogger.php">个人设置</a></li>
</ul>
<?php if(isset($_GET['activated'])):?><span class="alert alert-success">设置保存成功</span><?php endif;?>
<?php if(isset($_GET['error'])):?><span class="alert alert-danger">保存失败：根目录下的.htaccess不可写</span><?php endif;?>
</div>
<div class="panel-body" style="margin-left:30px;">
<form action="seo.php?action=update" method="post">
<h4>文章链接设置</h4>
<div class="alert alert-info" style="width: 100%">
    你可以在这里修改文章链接的形式，如果修改后文章无法访问，那可能是你的服务器空间不支持URL重写，请修改回默认形式、关闭文章连接别名。
    <br />启用链接别名后可以自定义文章和页面的链接地址。
</div>
<div class="form-group">
            <div class="radio">
                <label>
                    <input type="radio" name="permalink" value="0" <?php echo $ex0; ?>>默认形式：<span class="permalink_url"><?php echo BLOG_URL; ?>?post=1</span>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="permalink" value="1" <?php echo $ex1; ?>>文件形式：<span class="permalink_url"><?php echo BLOG_URL; ?>post-1.html</span>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="permalink" value="2" <?php echo $ex2; ?>>目录形式：<span class="permalink_url"><?php echo BLOG_URL; ?>post/1</span>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="permalink" value="3" <?php echo $ex3; ?>>分类形式：<span class="permalink_url"><?php echo BLOG_URL; ?>category/1.html</span>
                </label>
            </div>
</div>
<div class="form-group">
                <div class="checkbox">
                <label>
                    <input type="checkbox" style="vertical-align:middle;" value="y" name="isalias" id="isalias" <?php echo $isalias; ?> />启用文章链接别名
                </label>
            </div>
                <div class="checkbox">
                <label>
                    <input type="checkbox" style="vertical-align:middle;" value="y" name="isalias_html" id="isalias_html" <?php echo $isalias_html; ?> />启用文章链接别名html后缀
                </label>
            </div>
</div>

<h4>meta信息设置</h4>
<div class="form-group">
    <li>
        <label>站点浏览器标题(title)</label>
        <input maxlength="200" style="width:300px;" class="form-control" value="<?php echo $site_title; ?>" name="site_title" />
    </li>
    <li>
        <label>站点关键字(keywords)</label>
        <input maxlength="200" style="width:300px;" class="form-control" value="<?php echo $site_key; ?>" name="site_key" />
    </li>
    <li>
        <label>站点浏览器描述(description)</label>
        <textarea name="site_description" class="form-control" cols="" rows="4" style="width:300px;"><?php echo $site_description; ?></textarea>
    </li>
    <li>
        <label>文章浏览器标题方案：</label>
        <select name="log_title_style" class="form-control" style="width: 120px;">
        <option value="0" <?php echo $opt0; ?>>文章标题</option>
        <option value="1" <?php echo $opt1; ?>>文章标题 - 站点标题</option>
        <option value="2" <?php echo $opt2; ?>>文章标题 - 站点浏览器标题</option>
        </select>
    </li>
    <li style="margin-top:10px;">
        <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
        <input type="submit" value="保存设置" class="btn btn-primary" />
    </li>
</div>
</form>
</div>
<script>
    setTimeout(hideActived, 2600);
    $("#menu_setting").addClass('active').parent().parent().addClass('active');
</script>