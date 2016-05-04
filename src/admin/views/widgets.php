<?php if (!defined('EMLOG_ROOT')) {exit('error!');}?>
<script type="text/javascript" src="../include/lib/js/jquery/jquery-ui.min.js?v=<?= Option::EMLOG_VERSION; ?>"></script>
<script>setTimeout(hideActived, 2600);</script>
<!--vot--><div class="containertitle"><b><?=lang('widget_manage')?></b>
<!--vot--><?php if (isset($_GET['activated'])): ?><span class="alert alert-success"><?=lang('settings_saved_ok')?></span><?php endif; ?></div>
<div class=line></div>

<div class="row">
    <div class="col-lg-6" id="adm_widget_list">
        <div class="panel panel-default">
            <div class="panel-heading">
<!--vot-->      <?=lang('system_widgets')?>
            </div>
            <div class="panel-body">
                <div class="panel-group" id="accordion">

                    <div id="blogger" class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
<!--vot-->                      <a data-toggle="collapse" data-parent="#accordion" href=".blogger" aria-expanded="false" class="widget-title"><?=lang('blogger')?></a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                        </div>
                        <div class="blogger panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                            <div class="panel-body">
                                <form action="widgets.php?action=setwg&wg=blogger" method="post" class="form-inline">
<!--vot-->                          <li><input type="text" name="title" class="form-control" value="<?= $customWgTitle['blogger']; ?>"  /> <input type="submit" name="" value="<?=lang('change')?>" class="btn btn-primary btn-sm" /></li>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div id="calendar" class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
<!--vot-->                      <a data-toggle="collapse" data-parent="#accordion" href=".calendar" class="widget-title" aria-expanded="false"><?=lang('calendar')?></a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                        </div>
                        <div class="calendar panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                            <div class="panel-body">
                                <form action="widgets.php?action=setwg&wg=calendar" method="post" class="form-inline">
<!--vot-->                          <li><input type="text" name="title" class="form-control" value="<?= $customWgTitle['calendar']; ?>"  /> <input type="submit" name="" value="<?=lang('change')?>" class="btn btn-primary btn-sm" /></li>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div id="tag" class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
<!--vot-->                      <a data-toggle="collapse" data-parent="#accordion" href=".tag" class="widget-title" aria-expanded="false"><?=lang('tags')?></a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                        </div>
                        <div class="tag panel-collapse collapse" aria-expanded="false">
                            <div class="panel-body">
                                <form action="widgets.php?action=setwg&wg=tag" method="post" class="form-inline">
<!--vot-->                          <li><input type="text" name="title" class="form-control" value="<?= $customWgTitle['tag']; ?>"  /> <input type="submit" name="" value="<?=lang('change')?>" class="btn btn-primary btn-sm" /></li>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div id="sort" class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
<!--vot-->                      <a data-toggle="collapse" data-parent="#accordion" href=".sort" class="widget-title" aria-expanded="false"><?=lang('categories')?></a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                        </div>
                        <div class="sort panel-collapse collapse" aria-expanded="false">
                            <div class="panel-body">
                                <form action="widgets.php?action=setwg&wg=sort" method="post" class="form-inline">
<!--vot-->                          <li><input type="text" name="title" class="form-control" value="<?= $customWgTitle['sort']; ?>"  /> <input type="submit" name="" value="<?=lang('change')?>" class="btn btn-primary btn-sm" /></li>
                                </form>
                            </div>
                        </div>
                    </div>                                

                    <div id="archive" class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
<!--vot-->                      <a data-toggle="collapse" data-parent="#accordion" href=".archive" class="widget-title" aria-expanded="false"><?=lang('archive')?></a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                        </div>
                        <div class="archive panel-collapse collapse" aria-expanded="false">
                            <div class="panel-body">
                                <form action="widgets.php?action=setwg&wg=archive" method="post" class="form-inline">
<!--vot-->                          <li><input type="text" name="title" class="form-control" value="<?= $customWgTitle['archive']; ?>"  /> <input type="submit" name="" value="<?=lang('change')?>" class="btn btn-primary btn-sm" /></li>
                                </form>
                            </div>
                        </div>
                    </div>                                

                    <div id="newcomm" class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
<!--vot-->                      <a data-toggle="collapse" data-parent="#accordion" href=".newcomm" class="widget-title" aria-expanded="false"><?=lang('new_comments')?></a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                        </div>
                        <div class="newcomm panel-collapse collapse" aria-expanded="false">
                            <div class="panel-body">
                                <form action="widgets.php?action=setwg&wg=newcomm" method="post" class="form-inline">
<!--vot-->                          <li><?=lang('title')?></li>
                                    <li><input type="text" name="title" class="form-control" value="<?= $customWgTitle['newcomm']; ?>"  /></li>
<!--vot-->                          <li><?=lang('last_comments_num')?></li>
                                    <li><input class="form-control" maxlength="5" size="10" value="<?= Option::get('index_comnum'); ?>" name="index_comnum" /></li>
<!--vot-->                          <li><?=lang('new_comments_length')?></li>
<!--vot-->                          <li><input class="form-control" maxlength="5" size="10" value="<?= Option::get('comment_subnum'); ?>" name="comment_subnum" /> <input type="submit" name="" value="<?=lang('change')?>" class="btn btn-primary btn-sm" /></li>
                                </form>
                            </div>
                        </div>
                    </div>  

                    <div id="newlog" class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
<!--vot-->                      <a data-toggle="collapse" data-parent="#accordion" href=".newlog" class="widget-title" aria-expanded="false"><?=lang('new_posts')?></a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                        </div>
                        <div class="newlog panel-collapse collapse" aria-expanded="false">
                            <div class="panel-body">
                                <form action="widgets.php?action=setwg&wg=newlog" method="post" class="form-inline">
<!--vot-->                          <li><?=lang('title')?></li>
                                    <li><input type="text" name="title" class="form-control" value="<?= $customWgTitle['newlog']; ?>"  /></li>
<!--vot-->                          <li><?=lang('new_posts_show')?></li>
<!--vot-->                          <li><input class="form-control" maxlength="5" size="10" value="<?= Option::get('index_newlognum'); ?>" name="index_newlog" /> <input type="submit" name="" value="<?=lang('change')?>" class="btn btn-primary btn-sm" /></li>
                                </form>
                            </div>
                        </div>
                    </div>  

                    <div id="hotlog" class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
<!--vot-->                      <a data-toggle="collapse" data-parent="#accordion" href=".hotlog" class="widget-title" aria-expanded="false"><?=lang('hot_posts')?></a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                        </div>
                        <div class="hotlog panel-collapse collapse" aria-expanded="false">
                            <div class="panel-body">
                                <form action="widgets.php?action=setwg&wg=hotlog" method="post" class="form-inline">
<!--vot-->                          <li><?=lang('title')?></li>
                                    <li><input type="text" name="title" class="form-control" value="<?= $customWgTitle['hotlog']; ?>"  /></li>
<!--vot-->                          <li><?=lang('hot_posts_home')?></li>
<!--vot-->                          <li><input class="form-control" maxlength="5" size="10" value="<?= Option::get('index_hotlognum'); ?>" name="index_hotlognum" /> <input type="submit" name="" value="<?=lang('change')?>" class="btn btn-primary btn-sm" /></li>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div id="link" class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
<!--vot-->                      <a data-toggle="collapse" data-parent="#accordion" href=".link" class="widget-title" aria-expanded="false"><?=lang('links')?></a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                        </div>
                        <div class="link panel-collapse collapse" aria-expanded="false">
                            <div class="panel-body">
                                <form action="widgets.php?action=setwg&wg=link" method="post" class="form-inline">
<!--vot-->                          <li><input type="text" name="title" class="form-control" value="<?= $customWgTitle['link']; ?>"  /> <input type="submit" name="" value="<?=lang('change')?>" class="btn btn-primary btn-sm" /></li>
                                </form>
                            </div>
                        </div>
                    </div> 

                    <div id="search" class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
<!--vot-->                      <a data-toggle="collapse" data-parent="#accordion" href=".search" class="widget-title" aria-expanded="false"><?=lang('search')?></a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                        </div>
                        <div class="search panel-collapse collapse" aria-expanded="false">
                            <div class="panel-body">
                                <form action="widgets.php?action=setwg&wg=search" method="post" class="form-inline">
<!--vot-->                          <li><input type="text" name="title" value="<?= $customWgTitle['search']; ?>" class="form-control" /> <input type="submit" name="" value="<?=lang('change')?>" class="btn btn-primary btn-sm" /></li>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
<!--vot-->      <?=lang('widgets_custom')?>
            </div>
            <div class="panel-body">
                <div class="panel-group" id="accordion">
                        <?php
                        foreach ($custom_widget as $key => $val):
                        preg_match("/^custom_wg_(\d+)/", $key, $matches);
/*vot*/                 $custom_wg_title = empty($val['title']) ? lang('widget_untitled'). ' (' . $matches[1] . ')' : $val['title'];
                        ?>
                        <div class="panel panel-default" id="<?= $key; ?>">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse_<?= $key; ?>" aria-expanded="false" class="widget-title"><?= $custom_wg_title; ?></a>
                                    <li class="widget-act-add"></li>
                                    <li class="widget-act-del"></li>
                                </h4>
                            </div>
                            <div id="collapse_<?= $key; ?>" class="panel-collapse collapse" aria-expanded="false">
                                <div class="panel-body" class="form-group">
                                    <form action="widgets.php?action=setwg&wg=custom_text" method="post">
                                        <li>
                                            <input type="hidden" name="custom_wg_id" value="<?= $key; ?>" />
                                            <input type="text" name="title" class="form-control" value="<?= $val['title']; ?>" /><br />
                                        </li>
                                        <li><textarea class="form-control" name="content" style="overflow:auto; height:260px;"><?= $val['content']; ?></textarea><br /></li>
                                        <li>
<!--vot-->                                  <input type="submit" class="btn btn-primary" name="" value="<?=lang('change')?>" />
<!--vot-->                                  <a class="btn btn-danger" href="widgets.php?action=setwg&wg=custom_text&rmwg=<?= $key; ?>"><?=lang('widget_delete')?></a>
                                        </li>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

<!--vot-->          <p style="margin:20px 0px;"><a class="btn btn-success" href="javascript:displayToggle('custom_text_new', 2);"><?=lang('widget_add')?>+</a></p>

                    <form action="widgets.php?action=setwg&wg=custom_text" method="post" class="form-inline">
                        <div id="custom_text_new" style="display:none;" class="form-group">
<!--vot-->                  <li><?=lang('widget_title')?></li>
                            <li><input type="text" class="form-control" name="new_title" style="width:384px;" value="" /></li>
<!--vot-->                  <li><?=lang('widget_content_info')?></li>
                            <li><textarea name="new_content" class="form-control" rows="10" style="width:380px;overflow:auto;"></textarea></li>
<!--vot-->                  <li><input type="submit" class="btn btn-primary btn-sm" name="" value="<?=lang('widget_add')?>"  /></li>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
<!--vot-->      <?=lang('widget_use')?>
            </div>
            <form action="widgets.php?action=compages" method="post" class="form-inline">
                <div class="panel-body">
                    <div class="panel-group adm_widget_box" id="sortable">
                        <?php
                        foreach ($widgets as $widget):
/*vot*/                     $flg = strpos($widget, 'custom_wg_') === 0 ? true : false; //Whether is custom widget
/*vot*/                     $title = ($flg && isset($custom_widget[$widget]['title'])) ? $custom_widget[$widget]['title'] : ''; //Get custom widget title
                            if ($flg && empty($title)) {
                                preg_match("/^custom_wg_(\d+)/", $widget, $matches);
/*vot*/                         $title = lang('widget_untitled'). ' (' . $matches[1] . ')';
                            }
                            ?>
                        <div class="panel panel-default active_widget" id="em_<?= $widget; ?>" style="cursor:move;">
                                <div class="panel-heading">
                                    <input type="hidden" name="widgets[]" value="<?= $widget; ?>" />
                                    <h4 class="panel-title">
                                        <?php if ($flg) {
                                            echo $title;
                                        } else {
                                            echo $widgetTitle[$widget];
                                        } ?>
                                    </h4>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <input type="hidden" name="wgnum" id="wgnum" value="<?= $wgNum; ?>" />
<!--vot-->      <div style="margin:20px 40px;"><input type="submit" value="<?=lang('widget_order_save')?>" class="btn btn-primary" /> <a href="javascript:em_confirm(0, 'reset_widget', '<?= LoginAuth::genToken(); ?>');" class="btn btn-danger" ><?=lang('widget_setting_reset')?></a></div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        var widgets = $(".active_widget").map(function(){return $(this).attr("id");});
        $.each(widgets,function(i,widget_id){
            var widget_id = widget_id.substring(3);
            $("#"+widget_id+" .widget-act-add").hide();
            $("#"+widget_id+" .widget-act-del").show();
        });

        //Add widget
        $("#adm_widget_list .widget-act-add").click(function(){
            var title = $(this).prevAll(".widget-title").html();
            var widget_id = $(this).parent().parent().parent().attr("id");
            var widget_element = "<div class=\"panel panel-default active_widget\" id=\"em_"+widget_id+"\">";
                widget_element += "<div class=\"panel-heading\">";
                widget_element += "<input type=\"hidden\" name=\"widgets[]\" value=\""+widget_id+"\" />";
                widget_element += "<h4 class=\"panel-title\">"+title+"</h4>";
                widget_element += "</div>";
                widget_element += "</div>";
            $(".adm_widget_box").append(widget_element);
            $(this).hide();
            $(this).next(".widget-act-del").show();
        });
        //Remove widget
        $("#adm_widget_list .widget-act-del").click(function(){
            var widget_id = $(this).parent().parent().parent().attr("id");
            $(".adm_widget_box #em_" + widget_id).remove();
            $(this).hide();
            $(this).prev(".widget-act-add").show();
        });

        //Drag
        $( "#sortable" ).sortable();
        $( "#sortable" ).disableSelection();
        
        //Custom Widget Text
        $("#custom_text_new").css('display', $.cookie('em_custom_text_new') ? $.cookie('em_custom_text_new') : 'none');

        $("#menu_view").addClass('in');
        $("#menu_widget").addClass('active');
    });
</script>
