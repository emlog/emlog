<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class="containertitle2">
<a class="navi1" href="./configure.php">基本设置</a>
<a class="navi4" href="./style.php">后台风格</a>
<a class="navi2" href="./permalink.php">日志链接</a>
<a class="navi4" href="./blogger.php">个人资料</a>
<?php if(isset($_GET['activated'])):?><span class="actived">设置保存成功</span><?php endif;?>
<?php if(isset($_GET['error'])):?><span class="error">保存失败：根目录下的.htaccess不可写</span><?php endif;?>
</div>
<div style="margin-left:10px;">
<div class="des">你可以在这里修改日志链接的形式，这或许可以提高链接的可读性和对搜索引擎的友好程度。<br />
如果修改后日志无法访问，那可能是你的服务器环境不支持URL重写，请修改回默认形式、关闭日志连接别名。启用链接别名后可以自定义日志和页面的链接地址。
</div>
<form action="permalink.php?action=update" method="post">
<div style="margin:10px 10px;">
	<li><input type="radio" name="permalink" value="0" <?php echo $ex0; ?>>默认形式：<span class="permalink_url"><?php echo BLOG_URL; ?>?post=1</span></li>
    <li><input type="radio" name="permalink" value="1" <?php echo $ex1; ?>>文件形式：<span class="permalink_url"><?php echo BLOG_URL; ?>post-1.html</span></li>
    <li><input type="radio" name="permalink" value="2" <?php echo $ex2; ?>>目录形式：<span class="permalink_url"><?php echo BLOG_URL; ?>post/1</span></li>
	<li><input type="radio" name="permalink" value="3" <?php echo $ex3; ?>>分类形式：<span class="permalink_url"><?php echo BLOG_URL; ?>category/1.html</span></li>
    <div style="border-top:1px solid #F7F7F7; width:521px; margin:10px 0px 10px 0px;"></div>
	<li>启用链接别名：<input type="checkbox" style="vertical-align:middle;" value="y" name="isalias" id="isalias" <?php echo $isalias; ?> /></li>
	<li>启用链接别名html后缀：<input type="checkbox" style="vertical-align:middle;" value="y" name="isalias_html" id="isalias_html" <?php echo $isalias_html; ?> /></li>
	<li style="margin-top:10px;"><input type="submit" value="保存设置" class="button" /></li>
</div>
</form>
</div>