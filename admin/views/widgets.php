<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<div class="container-fluid">
<!--vot--><?php if (isset($_GET['activated'])): ?><div class="alert alert-success"><?=lang('settings_saved_ok')?></div><?php endif; ?>
<!--vot--><h1 class="h3 mb-4 text-gray-800"><?=lang('widget_manage')?></h1>
    <div class="row">
        <div class="col-lg-6" id="adm_widget_list">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">
<!--vot-->                  <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#blogger" aria-expanded="true" aria-controls="collapseOne"><?=lang('blogger')?></button>
                            <li class="widget-act-add"></li>
                            <li class="widget-act-del"></li>
                        </h2>
                    </div>
                    <div id="blogger" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">
                            <form action="widgets.php?action=setwg&wg=blogger" method="post" class="form-inline">
                                <li>
                                    <input type="text" name="title" class="form-control" value="<?php echo $customWgTitle['blogger']; ?>"/>
<!--vot-->                          <input type="submit" name="" value="<?=lang('change')?>" class="btn btn-primary btn-sm"/></li>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#calendar" aria-expanded="false" aria-controls="collapseTwo">
<!--vot-->                      <?=lang('calendar')?>
                            </button>
                            <li class="widget-act-add"></li>
                            <li class="widget-act-del"></li>
                        </h2>
                    </div>
                    <div id="calendar" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body">
                            <form action="widgets.php?action=setwg&wg=calendar" method="post" class="form-inline">
                                <li>
                                    <input type="text" name="title" class="form-control" value="<?php echo $customWgTitle['calendar']; ?>"/>
<!--vot-->                          <input type="submit" name="" value="<?=lang('change')?>" class="btn btn-primary btn-sm"/>
                                </li>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">
<!--vot-->                  <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#tag" aria-expanded="false" aria-controls="collapseThree"><?=lang('tags')?>
                            </button>
                            <li class="widget-act-add"></li>
                            <li class="widget-act-del"></li>
                        </h2>
                    </div>
                    <div id="tag" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                        <div class="card-body">
                            <form action="widgets.php?action=setwg&wg=tag" method="post" class="form-inline">
                                <li>
                                    <input type="text" name="title" class="form-control" value="<?php echo $customWgTitle['tag']; ?>"/>
<!--vot-->                          <input type="submit" name="" value="<?=lang('change')?>" class="btn btn-primary btn-sm"/>
                                </li>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">
<!--vot-->                  <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#sort" aria-expanded="false" aria-controls="collapseThree"><?=lang('category')?>
                            </button>
                            <li class="widget-act-add"></li>
                            <li class="widget-act-del"></li>
                        </h2>
                    </div>
                    <div id="sort" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                        <div class="card-body">
                            <form action="widgets.php?action=setwg&wg=sort" method="post" class="form-inline">
                                <li>
                                    <input type="text" name="title" class="form-control" value="<?php echo $customWgTitle['sort']; ?>"/>
<!--vot-->                          <input type="submit" name="" value="<?=lang('change')?>" class="btn btn-primary btn-sm"/>
                                </li>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#archive" aria-expanded="false" aria-controls="collapseThree">
<!--vot-->                      <?=lang('archive')?>
                            </button>
                            <li class="widget-act-add"></li>
                            <li class="widget-act-del"></li>
                        </h2>
                    </div>
                    <div id="archive" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                        <div class="card-body">
                            <form action="widgets.php?action=setwg&wg=archive" method="post" class="form-inline">
                                <li>
                                    <input type="text" name="title" class="form-control" value="<?php echo $customWgTitle['archive']; ?>"/>
<!--vot-->                          <input type="submit" name="" value="<?=lang('change')?>" class="btn btn-primary btn-sm"/>
                                </li>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#newcomm" aria-expanded="false" aria-controls="collapseThree">
<!--vot-->                      <?=lang('new_comments')?>
                            </button>
                            <li class="widget-act-add"></li>
                            <li class="widget-act-del"></li>
                        </h2>
                    </div>
                    <div id="newcomm" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                        <div class="card-body">
                            <form action="widgets.php?action=setwg&wg=newcomm" method="post" class="form-inline">
<!--vot-->                      <li><?=lang('title')?></li>
                                <li><input type="text" name="title" class="form-control" value="<?php echo $customWgTitle['newcomm']; ?>"/></li>
<!--vot-->                      <li><?=lang('last_comments_num')?></li>
                                <li><input class="form-control" maxlength="5" size="10" value="<?php echo Option::get('index_comnum'); ?>" name="index_comnum"/></li>
<!--vot-->                      <li><?=lang('new_comments_length')?></li>
                                <li>
                                    <input class="form-control" maxlength="5" size="10" value="<?php echo Option::get('comment_subnum'); ?>" name="comment_subnum"/>
<!--vot-->                          <input type="submit" name="" value="<?=lang('change')?>" class="btn btn-primary btn-sm"/>
                                </li>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#newlog" aria-expanded="false" aria-controls="collapseThree">
<!--vot-->                      <?=lang('new_posts')?>
                            </button>
                            <li class="widget-act-add"></li>
                            <li class="widget-act-del"></li>
                        </h2>
                    </div>
                    <div id="newlog" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                        <div class="card-body">
                            <form action="widgets.php?action=setwg&wg=newlog" method="post" class="form-inline">
<!--vot-->                      <li><?=lang('title')?></li>
                                <li><input type="text" name="title" class="form-control" value="<?php echo $customWgTitle['newlog']; ?>"/></li>
<!--vot-->                      <li><?=lang('new_posts_show')?></li>
                                <li>
                                    <input class="form-control" maxlength="5" size="10" value="<?php echo Option::get('index_newlognum'); ?>" name="index_newlog"/>
<!--vot-->                          <input type="submit" name="" value="<?=lang('change')?>" class="btn btn-primary btn-sm"/>
                                </li>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#hotlog" aria-expanded="false" aria-controls="collapseThree">
<!--vot-->                      <?=lang('hot_posts')?>
                            </button>
                            <li class="widget-act-add"></li>
                            <li class="widget-act-del"></li>
                        </h2>
                    </div>
                    <div id="hotlog" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                        <div class="card-body">
                            <form action="widgets.php?action=setwg&wg=hotlog" method="post" class="form-inline">
<!--vot-->                      <li><?=lang('title')?></li>
                                <li><input type="text" name="title" class="form-control" value="<?php echo $customWgTitle['hotlog']; ?>"/></li>
<!--vot-->                      <li><?=lang('hot_posts_home')?></li>
<!--vot-->                      <li><input class="form-control" maxlength="5" size="10" value="<?php echo Option::get('index_hotlognum'); ?>" name="index_hotlognum"/> <input
                                            type="submit" name="" value="<?=lang('change')?>" class="btn btn-primary btn-sm"/></li>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">
<!--vot-->                  <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#link" aria-expanded="false" aria-controls="collapseThree"><?=lang('links')?>
                            </button>
                            <li class="widget-act-add"></li>
                            <li class="widget-act-del"></li>
                        </h2>
                    </div>
                    <div id="link" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                        <div class="card-body">
                            <form action="widgets.php?action=setwg&wg=link" method="post" class="form-inline">
<!--vot-->                      <li><input type="text" name="title" class="form-control" value="<?php echo $customWgTitle['link']; ?>"/> <input type="submit" name="" value="<?=lang('change')?>"
                                                                                                                                                class="btn btn-primary btn-sm"/>
                                </li>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#search" aria-expanded="false" aria-controls="collapseThree">
<!--vot-->                      <?=lang('search')?>
                            </button>
                            <li class="widget-act-add"></li>
                            <li class="widget-act-del"></li>
                        </h2>
                    </div>
                    <div id="search" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                        <div class="card-body">
                            <form action="widgets.php?action=setwg&wg=search" method="post" class="form-inline">
<!--vot-->                      <li><input type="text" name="title" value="<?php echo $customWgTitle['search']; ?>" class="form-control"/> <input type="submit" name="" value="<?=lang('change')?>"
                                                                                                                                                  class="btn btn-primary btn-sm"/>
                                </li>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!--vot-->  <h3 class="h3 mb-4 text-gray-800"><?=lang('widgets_custom')?></h3>
            <div class="accordion" id="accordionExample">
                <?php
                foreach ($custom_widget as $key => $val):
                    preg_match("/^custom_wg_(\d+)/", $key, $matches);
/*vot*/             $custom_wg_title = empty($val['title']) ? lang('widget_untitled'). ' (' . $matches[1] . ')' : $val['title'];
                    ?>
                    <div class="card">
                        <div class="card-header">
                            <h2 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#<?php echo $key; ?>" aria-expanded="true"
                                        aria-controls="collapseOne"><?php echo $custom_wg_title; ?></button>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h2>
                        </div>
                        <div id="<?php echo $key; ?>" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                                <form action="widgets.php?action=setwg&wg=custom_text" method="post">
                                    <li>
                                        <input type="hidden" name="custom_wg_id" value="<?php echo $key; ?>"/>
                                        <input type="text" name="title" class="form-control" value="<?php echo $val['title']; ?>"/><br/>
                                    </li>
                                    <li><textarea class="form-control" name="content" style="overflow:auto; height:260px;"><?php echo $val['content']; ?></textarea><br/></li>
                                    <li>
<!--vot-->                              <input type="submit" class="btn btn-primary" name="" value="<?=lang('change')?>">
<!--vot-->                              <a class="btn btn-danger" href="widgets.php?action=setwg&wg=custom_text&rmwg=<?php echo $key; ?>"><?=lang('widget_delete')?></a>
                                    </li>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
<!--vot-->      <p style="margin:20px 0px;"><a class="btn btn-success" href="javascript:displayToggle('custom_text_new', 2);"><?=lang('widget_add')?>+</a></p>
                <form action="widgets.php?action=setwg&wg=custom_text" method="post">
                    <div class="form-group">
<!--vot-->          <label for="sortname"><?=lang('widget_title')?></label>
                        <input class="form-control" id="new_title" name="new_title">
                    </div>
                    <div class="form-group">
<!--vot-->          <label for="alias"><?=lang('widget_content_info')?></label>
                        <textarea name="new_content" class="form-control" rows="10"></textarea>
                    </div>
<!--vot-->          <button type="submit" class="btn btn-primary"><?=lang('widget_add')?></button>
                    <span id="alias_msg_hook"></span>
                </form>
            </div>
        </div>

        <div class="col-lg-6">
<!--vot--><h1 class="h3 mb-4 text-gray-800"><?=lang('widget_manage')?></h1>
            <form action="widgets.php?action=compages" method="post">
                <div class="accordion" id="accordionExample">
                    <?php
                    foreach ($widgets as $widget):
/*vot*/                 $flg = strpos($widget, 'custom_wg_') === 0 ? true : false; //Whether is custom widget
/*vot*/                 $title = ($flg && isset($custom_widget[$widget]['title'])) ? $custom_widget[$widget]['title'] : ''; //Get custom widget title
                        if ($flg && empty($title)) {
                            preg_match("/^custom_wg_(\d+)/", $widget, $matches);
/*vot*/                     $title = lang('widget_untitled'). ' (' . $matches[1] . ')';
                        }
                        ?>
                        <div class="card">
                            <div class="card-header">
                                <h2 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#blogger" aria-expanded="true" aria-controls="collapseOne">
                                        <?php if ($flg) {
                                            echo $title;
                                        } else {
                                            echo $widgetTitle[$widget];
                                        } ?>
                                    </button>
                                    <input type="hidden" name="widgets[]" value="<?php echo $widget; ?>"/>
                                </h2>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <input type="hidden" name="wgnum" id="wgnum" value="<?php echo $wgNum; ?>"/>
<!--vot-->          <input type="submit" value="<?=lang('widget_order_save')?>" class="btn btn-primary">
<!--vot-->          <a href="javascript:em_confirm(0, 'reset_widget', '<?php echo LoginAuth::genToken(); ?>');" class="btn btn-danger"><?=lang('widget_setting_reset')?></a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    setTimeout(hideActived, 2600);
    $(document).ready(function () {
        var widgets = $(".active_widget").map(function () {
            return $(this).attr("id");
        });
        $.each(widgets, function (i, widget_id) {
            var widget_id = widget_id.substring(3);
            $("#" + widget_id + " .widget-act-add").hide();
            $("#" + widget_id + " .widget-act-del").show();
        });

        //Add widget
        $("#adm_widget_list .widget-act-add").click(function () {
            var title = $(this).prevAll(".widget-title").html();
            var widget_id = $(this).parent().parent().parent().attr("id");
            var widget_element = "<div class=\"panel panel-default active_widget\" id=\"em_" + widget_id + "\">";
            widget_element += "<div class=\"panel-heading\">";
            widget_element += "<input type=\"hidden\" name=\"widgets[]\" value=\"" + widget_id + "\" />";
            widget_element += "<h4 class=\"panel-title\">" + title + "</h4>";
            widget_element += "</div>";
            widget_element += "</div>";
            $(".adm_widget_box").append(widget_element);
            $(this).hide();
            $(this).next(".widget-act-del").show();
        });
        //Remove widget
        $("#adm_widget_list .widget-act-del").click(function () {
            var widget_id = $(this).parent().parent().parent().attr("id");
            $(".adm_widget_box #em_" + widget_id).remove();
            $(this).hide();
            $(this).prev(".widget-act-add").show();
        });

        //Drag
        $("#sortable").sortable();
        $("#sortable").disableSelection();

        //Custom Widget Text
        $("#custom_text_new").css('display', $.cookie('em_custom_text_new') ? $.cookie('em_custom_text_new') : 'none');

        $("#menu_category_view").addClass('active');
        $("#menu_view").addClass('show');
        $("#menu_widget").addClass('active');
    });
</script>
