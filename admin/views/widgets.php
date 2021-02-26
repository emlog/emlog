<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<div class="container-fluid">
    <?php if (isset($_GET['activated'])): ?><div class="alert alert-success">设置保存成功</div><?php endif; ?>
    <h1 class="h3 mb-4 text-gray-800">侧边栏组件管理</h1>
    <div class="row">
        <div class="col-lg-6" id="adm_widget_list">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#blogger" aria-expanded="true" aria-controls="collapseOne">个人资料</button>
                            <li class="widget-act-add"></li>
                            <li class="widget-act-del"></li>
                        </h2>
                    </div>
                    <div id="blogger" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">
                            <form action="widgets.php?action=setwg&wg=blogger" method="post" class="form-inline">
                                <li>
                                    <input type="text" name="title" class="form-control" value="<?php echo $customWgTitle['blogger']; ?>"/>
                                    <input type="submit" name="" value="更改" class="btn btn-primary btn-sm"/></li>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#calendar" aria-expanded="false" aria-controls="collapseTwo">
                                日历
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
                                    <input type="submit" name="" value="更改" class="btn btn-primary btn-sm"/>
                                </li>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#tag" aria-expanded="false" aria-controls="collapseThree">标签
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
                                    <input type="submit" name="" value="更改" class="btn btn-primary btn-sm"/>
                                </li>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#sort" aria-expanded="false" aria-controls="collapseThree">分类
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
                                    <input type="submit" name="" value="更改" class="btn btn-primary btn-sm"/>
                                </li>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#archive" aria-expanded="false" aria-controls="collapseThree">
                                存档
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
                                    <input type="submit" name="" value="更改" class="btn btn-primary btn-sm"/>
                                </li>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#newcomm" aria-expanded="false" aria-controls="collapseThree">
                                最新评论
                            </button>
                            <li class="widget-act-add"></li>
                            <li class="widget-act-del"></li>
                        </h2>
                    </div>
                    <div id="newcomm" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                        <div class="card-body">
                            <form action="widgets.php?action=setwg&wg=newcomm" method="post" class="form-inline">
                                <li>标题</li>
                                <li><input type="text" name="title" class="form-control" value="<?php echo $customWgTitle['newcomm']; ?>"/></li>
                                <li>最新评论数</li>
                                <li><input class="form-control" maxlength="5" size="10" value="<?php echo Option::get('index_comnum'); ?>" name="index_comnum"/></li>
                                <li>新近评论截取字节数</li>
                                <li>
                                    <input class="form-control" maxlength="5" size="10" value="<?php echo Option::get('comment_subnum'); ?>" name="comment_subnum"/>
                                    <input type="submit" name="" value="更改" class="btn btn-primary btn-sm"/>
                                </li>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#newlog" aria-expanded="false" aria-controls="collapseThree">
                                最新文章
                            </button>
                            <li class="widget-act-add"></li>
                            <li class="widget-act-del"></li>
                        </h2>
                    </div>
                    <div id="newlog" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                        <div class="card-body">
                            <form action="widgets.php?action=setwg&wg=newlog" method="post" class="form-inline">
                                <li>标题</li>
                                <li><input type="text" name="title" class="form-control" value="<?php echo $customWgTitle['newlog']; ?>"/></li>
                                <li>显示最新文章数</li>
                                <li>
                                    <input class="form-control" maxlength="5" size="10" value="<?php echo Option::get('index_newlognum'); ?>" name="index_newlog"/>
                                    <input type="submit" name="" value="更改" class="btn btn-primary btn-sm"/>
                                </li>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#hotlog" aria-expanded="false" aria-controls="collapseThree">
                                热门文章
                            </button>
                            <li class="widget-act-add"></li>
                            <li class="widget-act-del"></li>
                        </h2>
                    </div>
                    <div id="hotlog" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                        <div class="card-body">
                            <form action="widgets.php?action=setwg&wg=hotlog" method="post" class="form-inline">
                                <li>标题</li>
                                <li><input type="text" name="title" class="form-control" value="<?php echo $customWgTitle['hotlog']; ?>"/></li>
                                <li>显示热门文章数</li>
                                <li><input class="form-control" maxlength="5" size="10" value="<?php echo Option::get('index_hotlognum'); ?>" name="index_hotlognum"/> <input
                                            type="submit" name="" value="更改" class="btn btn-primary btn-sm"/></li>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#link" aria-expanded="false" aria-controls="collapseThree">链接
                            </button>
                            <li class="widget-act-add"></li>
                            <li class="widget-act-del"></li>
                        </h2>
                    </div>
                    <div id="link" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                        <div class="card-body">
                            <form action="widgets.php?action=setwg&wg=link" method="post" class="form-inline">
                                <li><input type="text" name="title" class="form-control" value="<?php echo $customWgTitle['link']; ?>"/> <input type="submit" name="" value="更改"
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
                                搜索
                            </button>
                            <li class="widget-act-add"></li>
                            <li class="widget-act-del"></li>
                        </h2>
                    </div>
                    <div id="search" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                        <div class="card-body">
                            <form action="widgets.php?action=setwg&wg=search" method="post" class="form-inline">
                                <li><input type="text" name="title" value="<?php echo $customWgTitle['search']; ?>" class="form-control"/> <input type="submit" name="" value="更改"
                                                                                                                                                  class="btn btn-primary btn-sm"/>
                                </li>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="h3 mb-4 text-gray-800">自定义组件</h3>
            <div class="accordion" id="accordionExample">
                <?php
                foreach ($custom_widget as $key => $val):
                    preg_match("/^custom_wg_(\d+)/", $key, $matches);
                    $custom_wg_title = empty($val['title']) ? '未命名组件(' . $matches[1] . ')' : $val['title'];
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
                                        <input type="submit" class="btn btn-primary" name="" value="更改"/>
                                        <a class="btn btn-danger" href="widgets.php?action=setwg&wg=custom_text&rmwg=<?php echo $key; ?>">删除该组件</a>
                                    </li>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <p style="margin:20px 0px;"><a class="btn btn-success" href="javascript:displayToggle('custom_text_new', 2);">添加组件+</a></p>
                <form action="widgets.php?action=setwg&wg=custom_text" method="post">
                    <div class="form-group">
                        <label for="sortname">组件名</label>
                        <input class="form-control" id="new_title" name="new_title">
                    </div>
                    <div class="form-group">
                        <label for="alias">内容 （支持html）</label>
                        <textarea name="new_content" class="form-control" rows="10"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">添加组件</button>
                    <span id="alias_msg_hook"></span>
                </form>
            </div>
        </div>

        <div class="col-lg-6">
            <h1 class="h3 mb-4 text-gray-800">侧边栏组件管理</h1>
            <form action="widgets.php?action=compages" method="post">
                <div class="accordion" id="accordionExample">
                    <?php
                    foreach ($widgets as $widget):
                        $flg = strpos($widget, 'custom_wg_') === 0 ? true : false; //是否为自定义组件
                        $title = ($flg && isset($custom_widget[$widget]['title'])) ? $custom_widget[$widget]['title'] : ''; //获取自定义组件标题
                        if ($flg && empty($title)) {
                            preg_match("/^custom_wg_(\d+)/", $widget, $matches);
                            $title = '未命名组件(' . $matches[1] . ')';
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
                    <input type="submit" value="保存组件排序" class="btn btn-primary"/>
                    <a href="javascript:em_confirm(0, 'reset_widget', '<?php echo LoginAuth::genToken(); ?>');" class="btn btn-danger">恢复出厂设置</a>
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

        //添加组件
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
        //删除组件
        $("#adm_widget_list .widget-act-del").click(function () {
            var widget_id = $(this).parent().parent().parent().attr("id");
            $(".adm_widget_box #em_" + widget_id).remove();
            $(this).hide();
            $(this).prev(".widget-act-add").show();
        });

        //拖动
        $("#sortable").sortable();
        $("#sortable").disableSelection();

        //自定义组件记忆
        $("#custom_text_new").css('display', $.cookie('em_custom_text_new') ? $.cookie('em_custom_text_new') : 'none');

        $("#menu_category_view").addClass('active');
        $("#menu_view").addClass('show');
        $("#menu_widget").addClass('active');
    });
</script>
