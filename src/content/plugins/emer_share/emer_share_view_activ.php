<div id="emshare_main">
<?php 
if(function_exists('curl_init')){
?>
<form id="form1" name="form1" method="post" action="plugin.php?plugin=emer_share&action=setting">
    <input type="hidden" name="activ" value="1"/>
    <p>您好！您是首次使用插件，请按如下步骤激活插件：</p>
	<p>1. 设置个人资料里填写你的电子邮件地址。</p>
	<p>2. <a href="<?php echo EMER_API_URL?>api/profile?blogurl=<?php  echo BLOG_URL;?>">下载验证文件</a>，把验证文件上传到您博客的根目录（10分钟内有效，否则需要重新下载）。</p>
	<p>3. 上传完毕后，点击下面的激活按钮进行激活。</p>
	<input type="submit" value="激活" />
</form>
<?php 
}else{
?>
<p>对不起！您的空间不支持curl函数，无法使用此插件。请联系主机商开启。</p>
<?php
}
?>
<div style="margin:30px 0px 0px 0px;"><a href="http://emer.emlog.net" target="_blank">访问emer云分享平台&raquo;</a></div>
</div>