<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  dir="ltr" lang="<?php echo EMLOG_LANGUAGE; ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>upload</title>
<link href="./views/css/css-att.css" type=text/css rel=stylesheet>
<script type="text/javascript" src="./views/js/common.js"></script>
</head>
<script>
function showupload(multi){
	var as_logid = parent.document.getElementById('as_logid').value
	window.location.href="attachment.php?action=selectFile&logid="+as_logid+"&multi="+multi;	
}
function showattlib(){
	var as_logid = parent.document.getElementById('as_logid').value
	window.location.href="attachment.php?action=attlib&logid="+as_logid;	
}
</script>
<body>
<div id="media-upload-header">
	<span><a href="javascript:showupload(0);"><? echo $lang['attachment_upload'];?></a></span>
	<span><a href="javascript:showupload(1);">批量上传</a></span>
	<span id="curtab"><a href="javascript:showattlib();"><? echo $lang['attachment_library'];?> ( <?php echo $attachnum; ?> )</a></span>
</div>
<div id="media-upload-body">
<?php if(!$attach): ?>
<p id="attmsg"><? echo $lang['attachment_no'];?></p>
<?php else:
foreach($attach as $key=>$value):
	$extension  = strtolower(substr(strrchr($value['filepath'], "."),1));
	$atturl = BLOG_URL.substr(str_replace('thum-','',$value['filepath']),3);
	if($extension == 'zip' || $extension == 'rar'){
		$imgpath = "./views/images/tar.gif";
		$embedlink = "<a href=\"javascript: parent.addattach_file('$atturl', '{$value['filename']}', {$value['aid']});\">插入 </a>";
	}elseif (in_array($extension, array('gif', 'jpg', 'jpeg', 'png', 'bmp'))) {
		$imgpath = $value['filepath'];
		$ed_imgpath = BLOG_URL.substr($imgpath,3);
		$embedlink = "<a href=\"javascript: parent.addattach_img('$atturl','$ed_imgpath',{$value['aid']});\">{$lang['attachment_embed']}</a>";
	}else {
		$imgpath = "./views/images/fnone.gif";
		$embedlink = "<a href=\"javascript: parent.addattach_file('$atturl', '{$value['filename']}', {$value['aid']});\">插入 </a>";
	}
?>
	<li id="attlist"><a href="<?php echo $atturl; ?>" target="_blank" title="<?php echo $value['filename']; ?>"><img src="<?php echo $imgpath; ?>" width="60" height="60" border="0" align="absmiddle"/></a>
	<br><a href="javascript: em_confirm(<?php echo $value['aid']; ?>, 'attachment');"><? echo $lang['remove'];?></a> <?php echo $embedlink; ?></li>
<?php endforeach; endif; ?>
</div>
</body>
</html>
