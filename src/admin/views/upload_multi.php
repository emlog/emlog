<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  dir="ltr" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>upload</title>
<link href="./views/css/css-att.css" type="text/css" rel="stylesheet">
<link href="./views/css/css-uploadify.css" type="text/css" rel="stylesheet">

<script type="text/javascript" src="../include/lib/js/jquery/jquery-1.7.js"></script>
<script type="text/javascript" src="../include/lib/js/uploadify/jquery.uploadify.min.js"></script>

<script>
function showupload(multi)
{
	var as_logid = parent.document.getElementById('as_logid').value
	window.location.href="attachment.php?action=selectFile&logid="+as_logid+"&multi="+multi;	
}
function showattlib()
{
	var as_logid = parent.document.getElementById('as_logid').value
	window.location.href="attachment.php?action=attlib&logid="+as_logid;	
}
</script>
<body>
<div id="media-upload-header">
	<span><a href="javascript:showupload(0);">上传附件</a></span>
	<span id="curtab"><a href="javascript:showupload(1);">批量上传</a></span>
	<span><a href="javascript:showattlib();">附件库（<?php echo $attachnum; ?>）</a></span>
</div>

<form enctype="multipart/form-data" method="post" name="upload" action="">
<div id="media-upload-body">
<div class="demo-box">
<div id="custom-bt"><input width="120" type="file" height="30" name="Filedata" id="custom_file_upload" style="display: none;"></div>
<div id="custom-queue" class="uploadifyQueue"></div>
</div>
</div>
</form>
<script>
    $(document).ready(function() {
        $("#custom_file_upload").uploadify({            
			id              : jQuery(this).attr('id'),
			swf             : '../include/lib/js/uploadify/uploadify.swf',
			uploader        : 'attachment.php?action=upload_multi&logid='+parent.document.getElementById('as_logid').value,
			cancelImage     : './views/images/cancel.png',
			checkExisting   : false,
			buttonText      : '选择文件',
			auto            : true,
			multi           : true,
			buttonCursor    : 'pointer',
			fileTypeExts    : '*.jpg;*.gif;*.png;*.jpeg;*.rar;*.zip;*.bmp',
			queueID         : 'custom-queue',  
			queueSizeLimit	: 100,
			removeCompleted : false,
			fileSizeLimit	: 102400,
			fileObjName     : 'attach',
			onQueueComplete : function() {  
				showattlib();
			},
			onUploadError : function(file,errorCode,errorMsg,errorString,swfuploadifyQueue) {  
			    alert( 'id: ' + file.id  
			           + ' - 索引: ' + file.index  
			           + ' - 文件名: ' + file.name  
			           + ' - 文件大小: ' + file.size  
			           + ' - 类型: ' + file.type  
			           + ' - 创建日期: ' + file.creationdate  
			           + ' - 修改日期: ' + file.modificationdate  
			           + ' - 文件状态: ' + file.filestatus  
			           + ' - 错误代码: ' + errorCode  
			           + ' - 错误描述: ' + errorMsg  
			           + ' - 简要错误描述: ' + errorString  
			           + ' - 出错的文件数: ' + swfuploadifyQueue.filesErrored  
			           + ' - 错误信息: ' + swfuploadifyQueue.errorMsg  
			           + ' - 要添加至队列的数量: ' + swfuploadifyQueue.filesSelected  
			           + ' - 添加至对立的数量: ' + swfuploadifyQueue.filesQueued  
			           + ' - 队列长度: ' + swfuploadifyQueue.queueLength);  
			} 
        });
    });
</script>
</body>
</html>
