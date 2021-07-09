<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
}
?>
<div id="msg" class="fixed-top alert" style="display: none"></div>
<h1 class="h3 mb-4 text-gray-800"><?php echo $containertitle; ?></h1>
<form action="article_save.php?action=add" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
    <div class="row">
        <div class="col-xl-12">
            <div id="post" class="form-group">
                <div>
<!--vot-->          <input type="text" name="title" id="title" value="<?php echo $title; ?>" class="form-control" placeholder="<?=lang('post_title')?>" autofocus required/>
                </div>
                <div id="post_bar">
<!--vot-->          <a href="#" class="text-muted small my-3" data-toggle="modal" data-target="#addModal"><i class="icofont-plus"></i> <?=lang('upload_insert')?></a>
					<?php doAction('adm_writelog_head'); ?>
                    <span id="save_info"></span>
                </div>
                <div id="logcontent"><textarea><?php echo $content; ?></textarea></div>
            </div>

<!--vot-->  <div class="show_advset" id="displayToggle" onclick="displayToggle('advset', 1);"><?=lang('advanced_options')?><i class="icofont-simple-right"></i></div>

            <div id="advset">
                <div class="form-group">
<!--vot-->      <label><?=lang('post_description')?>:</label>
                    <div id="logexcerpt"><textarea><?php echo $excerpt; ?></textarea></div>
                </div>
                <div class="form-group">
<!--vot-->          <label><?=lang('category')?>:</label>
                    <select name="sort" id="sort" class="form-control">
<!--vot-->              <option value="-1"><?=lang('category_select')?></option>
						<?php
						foreach ($sorts as $key => $value):
							if ($value['pid'] != 0) {
								continue;
							}
							$flg = $value['sid'] == $sortid ? 'selected' : '';
							?>
                            <option value="<?php echo $value['sid']; ?>" <?php echo $flg; ?>><?php echo $value['sortname']; ?></option>
							<?php
							$children = $value['children'];
							foreach ($children as $key):
								$value = $sorts[$key];
								$flg = $value['sid'] == $sortid ? 'selected' : '';
								?>
                                <option value="<?php echo $value['sid']; ?>" <?php echo $flg; ?>>&nbsp; &nbsp; &nbsp; <?php echo $value['sortname']; ?></option>
							<?php
							endforeach;
						endforeach;
						?>
                    </select>
                </div>

                <div class="form-group">
<!--vot-->          <label><?=lang('tags')?>:</label>
<!--vot-->          <input name="tag" id="tag" class="form-control" value="<?php echo $tagStr; ?>" placeholder="<?=lang('post_tags_separated')?>"/>
                </div>

                <div class="form-group">
<!--vot-->          <label><?=lang('publish_time')?>:</label>
                    <input maxlength="200" name="postdate" id="postdate" value="<?php echo $postDate; ?>" class="form-control"/>
                </div>

                <div class="form-group">
<!--vot-->          <label><?=lang('link_alias')?>:</label>
                    <input name="alias" id="alias" class="form-control" value="<?php echo $alias; ?>"/>
                </div>

                <div class="form-group">
<!--vot-->          <label><?=lang('access_password')?>:</label>
                    <input type="text" name="password" id="password" class="form-control" value="<?php echo $password; ?>"/>
                </div>

                <div class="form-group">
                    <input type="checkbox" value="y" name="top" id="top" <?php echo $is_top; ?> />
<!--vot-->          <label for="top"><?=lang('home_top')?></label>
                    <input type="checkbox" value="y" name="sortop" id="sortop" <?php echo $is_sortop; ?> />
<!--vot-->          <label for="sortop"><?=lang('category_top')?></label>
                    <input type="checkbox" value="y" name="allow_remark" id="allow_remark" <?php echo $is_allow_remark; ?> />
<!--vot-->          <label for="allow_remark"><?=lang('allow_comments')?></label>
                </div>
            </div>

            <div id="post_button">
                <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
                <input type="hidden" name="ishide" id="ishide" value="<?php echo $hide; ?>"/>
                <input type="hidden" name="as_logid" id="as_logid" value="<?php echo $logid; ?>">
                <input type="hidden" name="gid" value=<?php echo $logid; ?>/>
                <input type="hidden" name="author" id="author" value=<?php echo $author; ?>/>

				<?php if ($logid < 0): ?>
<!--vot-->          <input type="submit" value="<?=lang('post_publish')?>" onclick="return checkform();" class="btn btn-sm btn-success"/>
<!--vot-->          <input type="button" name="savedf" id="savedf" value="<?=lang('save_draft')?>" onclick="autosave(2);" class="btn btn-sm btn-primary"/>
				<?php else: ?>
<!--vot-->          <input type="submit" value="<?=lang('save_and_return')?>" onclick="return checkform();" class="btn btn-sm btn-success"/>
<!--vot-->          <input type="button" name="savedf" id="savedf" value="<?=lang('save')?>" onclick="autosave(2);" class="btn btn-sm btn-primary"/>
					<?php if ($isdraft) : ?>
<!--vot-->              <input type="submit" name="pubdf" id="pubdf" value="<?=lang('publish')?>" onclick="return checkform();" class="btn btn-sm btn-success"/>
					<?php endif; ?>
				<?php endif; ?>
            </div>
        </div>
    </div>
</form>

<!--Resource Library-->
<div class="modal fade bd-example-modal-lg" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
<!--vot-->      <h5 class="modal-title" id="exampleModalLabel"><?=lang('resource_library')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-columns">
					<?php
					if ($medias):
						foreach ($medias as $key => $value):
							$media_url = getFileUrl($value['filepath']);
							$media_name = $value['filename'];
							if (isImage($value['filepath'])) {
								$imgpath = $value['thum_filepath'] ?? $value['filepath'];
								$media_icon_imgurl = getFileUrl($imgpath);
							} else {
								$media_icon_imgurl = "./views/images/fnone.png";
							}
							?>
                            <div class="card" style="min-height: 138px;">
								<?php if (isImage($value['filepath'])): ?>
<!--vot-->                          <a href="javascript:insert_media_img('<?php echo $media_url; ?>', '<?php echo $media_icon_imgurl; ?>')" title="<?=lang('img_insert')?>: <?php echo $media_name; ?>">
                                        <img class="card-img-top" src="<?php echo $media_icon_imgurl; ?>"/>
                                    </a>
								<?php else: ?>
<!--vot-->                          <a href="javascript:insert_media('<?php echo $media_url; ?>', '<?php echo $media_name; ?>')" title="<?=lang('file_insert')?>: <?php echo $media_name; ?>">
                                        <img class="card-img-top" src="<?php echo $media_icon_imgurl; ?>"/>
                                    </a>
								<?php endif; ?>
                            </div>
						<?php
						endforeach;
					else :
						?>
<!--vot-->          <?=lang('no_resources')?>
					<?php
					endif;
					?>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="./editor.md/editormd.js?d=5.25.2021"></script>
<? if (EMLOG_LANGUAGE !== 'zh-cn') { ?>
<script src="./editor.md/languages/<?=EMLOG_LANGUAGE?>.js"></script>
<? } ?>
<script>
    var icon_tog;//如果值为true，则“高级选项”箭头向右

    $("#alias").keyup(function () {
        checkalias();
    });
    setTimeout("autosave(1)", 30000);
    $("#menu_category_content").addClass('active');
    $("#menu_content").addClass('show');
    $("#menu_write").addClass('active');
    
    if(Cookies.get('em_advset')=="hidden"){
        icon_tog = true;
        displayToggle('advset', 1);
    }else{
        icon_tog = false;
        $(".icofont-simple-right").attr("class","icofont-simple-down");
    }

    var Editor, Editor_summary;
    $(function () {
        Editor = editormd("logcontent", {
            width: "100%",
            height: 640,
            toolbarIcons: function () {
                return ["undo", "redo", "|",
                    "bold", "del", "italic", "quote", "|",
                    "h1", "h2", "h3", "|",
                    "list-ul", "list-ol", "hr", "|",
                    "link", "image", "preformatted-text", "table", "|", "search", "watch"]
            },
            path: "editor.md/lib/",
            tex: false,
            watch: false,
            htmlDecode : true,
            flowChart: false,
            autoFocus: false,
            sequenceDiagram: false,
            imageUpload: true,
            imageFormats: ["jpg", "jpeg", "gif", "png"],
            imageUploadURL: "media.php?action=upload&editor=1",
            onload : function() {
                    //在大屏模式下，编辑器默认显示预览
                    if($(window).width() > 767){
                        this.watch();
                    }
            }
        });
        Editor_summary = editormd("logexcerpt", {
            width: "100%",
            height: 300,
            toolbarIcons: function () {
                return ["undo", "redo", "|",
                    "bold", "del", "italic", "quote", "|",
                    "h1", "h2", "h3", "|",
                    "list-ul", "list-ol", "hr", "|",
                    "link", "image", "|", "watch"]
            },
            path: "editor.md/lib/",
            tex: false,
            watch: false,
            htmlDecode : true,
            flowChart: false,
            autoFocus: false,
            sequenceDiagram: false,
/*vot*/     placeholder: "<?=lang('enter_summary')?>",
        });
        Editor.setToolbarAutoFixed(false);
        Editor_summary.setToolbarAutoFixed(false);
    });
</script>
