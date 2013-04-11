<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class="containertitle2">
<a class="navi1" href="./configure.php">基本设置</a>
<a class="navi2" href="./seo.php">SEO设置</a>
<a class="navi4" href="./style.php">后台风格</a>
<a class="navi4" href="./blogger.php">个人设置</a>
<?php if(isset($_GET['activated'])):?><span class="actived">设置保存成功</span><?php endif;?>
<?php if(isset($_GET['error'])):?><span class="error">保存失败：根目录下的.htaccess不可写</span><?php endif;?>
</div>
<div style="margin-left:10px;">
<form action="seo.php?action=update" method="post">
<div style="font-size: 14px; margin: 10px 0px 10px 10px;"><b>文章链接设置：</b></div>
<div class="des" style="margin-left:10px;">
    你可以在这里修改文章链接的形式，如果修改后文章无法访问，那可能是你的服务器环境不支持URL重写，请修改回默认形式、关闭文章连接别名。
    <br />启用链接别名后可以自定义文章和页面的链接地址。
</div>
<div style="margin:10px 8px;">
	<li><input type="radio" name="permalink" value="0" <?php echo $ex0; ?>>默认形式：<span class="permalink_url"><?php echo BLOG_URL; ?>?post=1</span></li>
    <li><input type="radio" name="permalink" value="1" <?php echo $ex1; ?>>文件形式：<span class="permalink_url"><?php echo BLOG_URL; ?>post-1.html</span></li>
    <li><input type="radio" name="permalink" value="2" <?php echo $ex2; ?>>目录形式：<span class="permalink_url"><?php echo BLOG_URL; ?>post/1</span></li>
	<li><input type="radio" name="permalink" value="3" <?php echo $ex3; ?>>分类形式：<span class="permalink_url"><?php echo BLOG_URL; ?>category/1.html</span></li>
    <div style="border-top:1px solid #F7F7F7; width:521px; margin:10px 0px 10px 0px;"></div>
	<li>启用文章链接别名：<input type="checkbox" style="vertical-align:middle;" value="y" name="isalias" id="isalias" <?php echo $isalias; ?> /></li>
	<li>启用文章链接别名html后缀：<input type="checkbox" style="vertical-align:middle;" value="y" name="isalias_html" id="isalias_html" <?php echo $isalias_html; ?> /></li>
</div>
<div style="border-top:1px solid #F7F7F7; width:521px; margin:10px 0px 10px 0px;"></div>
<div style="font-size: 14px; margin: 20px 0px 10px 10px;"><b>Meta设置：</b></div>
<div class="item_edit" style="margin-left:10px;">
    <li>站点浏览器标题(title)<br /><input maxlength="200" style="width:300px;" value="<?php echo $site_title; ?>" name="site_title" /></li>
    <li>站点关键字(keywords)<br /><input maxlength="200" style="width:300px;" value="<?php echo $site_key; ?>" name="site_key" /></li>
    <li>站点浏览器描述(description)<br /><textarea name="site_description" cols="" rows="4" style="width:300px;"><?php echo $site_description; ?></textarea></li>
    <li>文章浏览器标题方案：
        <select name="rss_output_fulltext">
		<option value="y" <?php echo $ex1; ?>>仅文章标题</option>
		<option value="n" <?php echo $ex2; ?>>文章标题 - 站点标题</option>
        <option value="n" <?php echo $ex2; ?>>文章标题 - 站点浏览器标题</option>
        </select>
    </li>
    <li style="margin-top:10px;"><input type="submit" value="保存设置" class="button" /></li>
</div>
</form>
</div>