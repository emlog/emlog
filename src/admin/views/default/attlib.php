<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  dir="ltr" lang="<?php echo EMLOG_LANGUAGE; ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>upload</title>
<link href="./views/<?php echo ADMIN_TPL; ?>/css-att.css" type=text/css rel=stylesheet>
<script type="text/javascript" src="./views/<?php echo ADMIN_TPL; ?>/common.js"></script>
</head>
<script>
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
	<span><a href="javascript:showupload();"><? echo $lang['attachment_upload'];?></a></span>
	<span id="curtab"><a href="javascript:showattlib();"><? echo $lang['attachment_library'];?> ( <?php echo $attachnum; ?> )</a></span>
</div>
<div id="media-upload-body">
<?php if(!$attach): ?>
<p id="attmsg"><? echo $lang['attachment_no'];?></p>
<?php else:
foreach($attach as $key=>$value):
	$extension  = strtolower(substr(strrchr($value['filepath'], "."),1));
	$atturl = $blogurl.substr(str_replace('thum-','',$value['filepath']),3);
	$emImageType = array('gif', 'jpg', 'jpeg', 'png', 'bmp');//Enabled attacment types
	if($extension == 'zip' || $extension == 'rar'){
		$imgpath = "./views/".ADMIN_TPL."/images/tar.gif";
		$embedlink = $lang['attachment_type_archive'];
	}elseif (in_array($extension, $emImageType)) {
		$imgpath = $value['filepath'];
		$ed_imgpath = $blogurl.substr($imgpath,3);
		$embedlink = "<a href=\"javascript: parent.addattach('$atturl','$ed_imgpath',{$value['aid']});\">{$lang['attachment_embed']}</a>";
	}else {
		$imgpath = "./views/".ADMIN_TPL."/images/fnone.gif";
		$embedlink = '';
	}
?>
	<li id="attlist"><a href="<?php echo $atturl; ?>" target="_blank" title="<?php echo $value['filename']; ?>"><img src="<?php echo $imgpath; ?>" width="60" height="60" border="0" align="absmiddle"/></a>
	<br><a href="javascript: em_confirm(<?php echo $value['aid']; ?>, 'attachment');"><? echo $lang['remove'];?></a> <?php echo $embedlink; ?></li>
<?php endforeach; endif; ?>
</div>
</body>
</html>
