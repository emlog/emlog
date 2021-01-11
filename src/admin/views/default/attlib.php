<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<!DOCTYPE html>
<!--vot--><html dir="<?= EMLOG_LANGUAGE_DIR ?>" lang="<?=EMLOG_LANGUAGE?>">
<head>
<meta charset="UTF-8">
<title>upload</title>
<link href="./views/<?php echo ADMIN_TEMPLATE; ?>/css/css-att.css?v=<?= Option::EMLOG_VERSION ?>" type=text/css rel=stylesheet>
<script type="text/javascript" src="./views/<?php echo ADMIN_TEMPLATE; ?>/js/common.js?v=<?= Option::EMLOG_VERSION ?>"></script>
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
<!--vot--><span><a href="javascript:showupload(0);"><?=lang('attachment_upload')?></a></span>
<!--vot--><span><a href="javascript:showupload(1);"><?=lang('bulk_upload')?></a></span>
<!--vot--><span id="curtab"><a href="javascript:showattlib();"><?=lang('attachment_library')?><?= $attachnum ?></a></span>
</div>
<div id="media-upload-body">
<?php if(!$attach): ?>
<!--vot--><p id="attmsg"><?=lang('no_attachments')?></p>
<?php else:
foreach($attach as $key=>$value):
	$extension  = strtolower(substr(strrchr($value['filepath'], "."),1));
	$atturl = BLOG_URL.substr($value['filepath'], 3);
	if ($extension == 'zip' || $extension == 'rar'){
		$imgpath = "./views/images/tar.gif";
/*vot*/		$embedlink = "<a href=\"javascript: parent.addattach_file('$atturl', '{$value['filename']}', {$value['aid']});\">".lang('insert')."</a>";
	} elseif (in_array($extension, array('gif', 'jpg', 'jpeg', 'png', 'bmp'))) {
		$imgpath = $value['filepath'];
		$ed_imgpath = BLOG_URL.substr($imgpath,3);
/*vot*/		$embedlink = "<a href=\"javascript: parent.addattach_img('$atturl', '$ed_imgpath',{$value['aid']}, '{$value['width']}', '{$value['height']}', '{$value['filename']}');\" title=\"".lang('insert_full_size')."\">".lang('full_size')."</a>";
		if (isset($value['thum_filepath'])) {
			$thum_url = BLOG_URL.substr($value['thum_filepath'], 3);
/*vot*/			$embedlink .= " <a href=\"javascript: parent.addattach_img('$atturl', '$thum_url',{$value['aid']}, '{$value['thum_width']}', '{$value['thum_height']}', '{$value['filename']}');\" title=\"".lang('insert_thumbnail')."\">".lang('thumbnail')."</a>";
		}
	} else {
		$imgpath = "./views/images/fnone.gif";
/*vot*/		$embedlink = "<a href=\"javascript: parent.addattach_file('$atturl', '{$value['filename']}', {$value['aid']});\">".lang('insert')."</a>";
	}
?>
	<li id="attlist"><a href="<?= $atturl ?>" target="_blank" title="<?= $value['filename'] ?>"><img src="<?= $imgpath ?>" width="90" height="90" border="0" align="absmiddle"></a>
	<?php if ($value['width'] && $value['height']): ?>
	<br>
	<?= $value['width']?>x<?= $value['height']?>
	<?php else:?>
	<br>
	<?= subString($value['filename'], 0, 6) ?>
	<?php endif;?>
<!--vot--><br><a href="javascript: em_confirm(<?= $value['aid'] ?>, 'attachment', '<?= LoginAuth::genToken() ?>');"><?=lang('delete')?></a> <?= $embedlink ?></li>
<?php endforeach; endif; ?>
</div>
</body>
</html>
