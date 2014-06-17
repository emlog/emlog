<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b><?=lang('image_crop')?></b> <?php if(isset($_GET['activated'])):?><span class="actived"><?=lang('template_change_ok')?></span><?php endif;?></div>
<div class=line></div>
<link href="../include/lib/js/imgareaselect/imgareaselect.css?v=<?php echo Option::EMLOG_VERSION; ?>" type=text/css rel=stylesheet>
<script type="text/javascript" src="../include/lib/js/imgareaselect/jquery.imgareaselect.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
<form method="post" action="./template.php?action=crop">
<p class="submit">
	<input type="hidden" name="x1" id="x1" value="0"/>
	<input type="hidden" name="y1" id="y1" value="0"/>
	<input type="hidden" name="width" id="width" value="960"/>
	<input type="hidden" name="height" id="height" value="705"/>
	<input type="hidden" name="img" id="img" value="<?php echo $topimg; ?>"/>
<!--vot--><input type="submit" value="<?=lang('crop_and_save')?>" /><span style="margin-left:15px;"><a href="./template.php?action=custom-top" ><?=lang('crop_cancel')?></a> <?=lang('crop_load_prompt')?></span>
</p>
<div id="crop_image" style="position: relative">
	<img src="<?php echo $topimg; ?>" id="upload" />
</div>
</form>
<script type="text/javascript">
setTimeout(hideActived,2600);
$("#menu_tpl").addClass('sidebarsubmenu1');
	function onEndCrop( coords ) {
		jQuery( '#x1' ).val(coords.x);
		jQuery( '#y1' ).val(coords.y);
		jQuery( '#width' ).val(coords.w);
		jQuery( '#height' ).val(coords.h);
		alert(coords.w);
	}
	jQuery(document).ready(function() {
		var xinit = 960;
		var yinit = 134;
		var ratio = xinit / yinit;
		var ximg = jQuery('img#upload').width();
		var yimg = jQuery('img#upload').height();

		if ( yimg < yinit || ximg < xinit ) {
			if ( ximg / yimg > ratio ) {
				yinit = yimg;
				xinit = yinit * ratio;
			} else {
				xinit = ximg;
				yinit = xinit / ratio;
			}
		}

		jQuery('img#upload').imgAreaSelect({
			handles: true,
			keys: true,
			aspectRatio: xinit + ':' + yinit,
			show: true,
			x1: 0,
			y1: 0,
			x2: xinit,
			y2: yinit,
			maxHeight: 134,
			maxWidth: 960,
			onInit: function () {
				jQuery('#width').val(xinit);
				jQuery('#height').val(yinit);
			},
			onSelectChange: function(img, c) {
				jQuery('#x1').val(c.x1);
				jQuery('#y1').val(c.y1);
				jQuery('#width').val(c.width);
				jQuery('#height').val(c.height);
			}
		});
	});
</script>