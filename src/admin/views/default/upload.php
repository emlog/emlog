<?php if(!defined('ADMIN_ROOT')) {exit('error!');} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  dir="ltr" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>upload</title>
<link href="./views/<?php echo ADMIN_TPL; ?>/main.css" type=text/css rel=stylesheet>
<script type="text/javascript" src="./views/<?php echo ADMIN_TPL; ?>/main.js"></script>
<script>
function uploadfile()
{
	var as_logid = parent.document.getElementById('as_logid').value
	document.upload.action = "attachment.php?action=upload&logid="+as_logid;
	document.upload.submit();
}
function showupload()
{
	var as_logid = parent.document.getElementById('as_logid').value
	window.location.href="attachment.php?action=selectFile&logid="+as_logid;	
}
function showattlib()
{
	var as_logid = parent.document.getElementById('as_logid').value
	window.location.href="attachment.php?action=attlib&logid="+as_logid;	
}
</script>
<body>
<div id="media-upload-header">
	<span id="curtab"><a href="javascript:showupload();">上传附件</a></span>
	<span><a href="javascript:showattlib();">附件库（<?php echo $attachnum; ?>）</a></span>
</div>

<form enctype="multipart/form-data" method="post" name="upload" action="">
<div id="media-upload-body">
	<p>
	<a id="attach" title="增加附件" onclick="addattachfrom()" href="javascript:;" name="attach">[+]</a> 
	<a id="attach" title="减少附件" onclick="removeattachfrom()" href="javascript:;" name="attach">[-]</a> 
	(最大允许<?php echo $maxsize ;?> 允许类型<?php echo $att_type_str; ?>)
	<div id="attachbodyhidden" style="display:none"><span><input type="file" name="attach[]"></span></div>
	<div id="attachbody"><span><input type="file" name="attach[]"></span></div>
	<input type="button" name="html-upload" value="上传" onclick="uploadfile();"/>
	</p>
</div>
</form>
</body>
</html>
