<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<script type="text/javascript" src="../include/lib/js/jquery/jquery-ui.min.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
<script>setTimeout(hideActived, 2600);</script>
<div class="containertitle"><b>侧边栏组件管理</b>
<?php if (isset($_GET['activated'])): ?><span class="alert alert-success">设置保存成功</span><?php endif; ?></div>
<div class=line></div>

<div class="row">
    <div class="col-lg-4" id="adm_widget_list">
        <div class="panel panel-default">
            <div class="panel-heading">
                系统组件
            </div>
            <div class="panel-body">
                <div class="panel-group" id="accordion">

                    <div id="blogger" class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href=".blogger" aria-expanded="false" class="widget-title">个人资料</a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                        </div>
                        <div class="blogger panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                            <div class="panel-body">
                                <form action="widgets.php?action=setwg&wg=blogger" method="post" class="form-inline">
                                    <li><input type="text" name="title" class="form-control" value="<?php echo $customWgTitle['blogger']; ?>"  /> <input type="submit" name="" value="更改" class="btn btn-primary btn-sm" /></li>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div id="calendar" class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href=".calendar" class="widget-title" aria-expanded="false">日历</a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                        </div>
                        <div class="calendar panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                            <div class="panel-body">
                                <form action="widgets.php?action=setwg&wg=calendar" method="post" class="form-inline">
                                    <li><input type="text" name="title" class="form-control" value="<?php echo $customWgTitle['calendar']; ?>"  /> <input type="submit" name="" value="更改" class="btn btn-primary btn-sm" /></li>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div id="tag" class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href=".tag" class="widget-title" aria-expanded="false">标签</a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                        </div>
                        <div class="tag panel-collapse collapse" aria-expanded="false">
                            <div class="panel-body">
                                <form action="widgets.php?action=setwg&wg=tag" method="post" class="form-inline">
                                    <li><input type="text" name="title" class="form-control" value="<?php echo $customWgTitle['tag']; ?>"  /> <input type="submit" name="" value="更改" class="btn btn-primary btn-sm" /></li>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div id="sort" class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href=".sort" class="widget-title" aria-expanded="false">分类</a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                        </div>
                        <div class="sort panel-collapse collapse" aria-expanded="false">
                            <div class="panel-body">
                                <form action="widgets.php?action=setwg&wg=sort" method="post" class="form-inline">
                                    <li><input type="text" name="title" class="form-control" value="<?php echo $customWgTitle['sort']; ?>"  /> <input type="submit" name="" value="更改" class="btn btn-primary btn-sm" /></li>
                                </form>
                            </div>
                        </div>
                    </div>                                

                    <div id="archive" class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href=".archive" class="widget-title" aria-expanded="false">存档</a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                        </div>
                        <div class="archive panel-collapse collapse" aria-expanded="false">
                            <div class="panel-body">
                                <form action="widgets.php?action=setwg&wg=archive" method="post" class="form-inline">
                                    <li><input type="text" name="title" class="form-control" value="<?php echo $customWgTitle['archive']; ?>"  /> <input type="submit" name="" value="更改" class="btn btn-primary btn-sm" /></li>
                                </form>
                            </div>
                        </div>
                    </div>                                

                    <div id="newcomm" class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href=".newcomm" class="widget-title" aria-expanded="false">最新评论</a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                        </div>
                        <div class="newcomm panel-collapse collapse" aria-expanded="false">
                            <div class="panel-body">
                                <form action="widgets.php?action=setwg&wg=newcomm" method="post" class="form-inline">
                                    <li>标题</li>
                                    <li><input type="text" name="title" class="form-control" value="<?php echo $customWgTitle['newcomm']; ?>"  /></li>
                                    <li>最新评论数</li>
                                    <li><input class="form-control" maxlength="5" size="10" value="<?php echo Option::get('index_comnum'); ?>" name="index_comnum" /></li>
                                    <li>新近评论截取字节数</li>
                                    <li><input class="form-control" maxlength="5" size="10" value="<?php echo Option::get('comment_subnum'); ?>" name="comment_subnum" /> <input type="submit" name="" value="更改" class="btn btn-primary btn-sm" /></li>
                                </form>
                            </div>
                        </div>
                    </div>  

                    <div id="newlog" class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href=".newlog" class="widget-title" aria-expanded="false">最新文章</a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                        </div>
                        <div class="newlog panel-collapse collapse" aria-expanded="false">
                            <div class="panel-body">
                                <form action="widgets.php?action=setwg&wg=newlog" method="post" class="form-inline">
                                    <li>标题</li>
                                    <li><input type="text" name="title" class="form-control" value="<?php echo $customWgTitle['newlog']; ?>"  /></li>
                                    <li>显示最新文章数</li>
                                    <li><input class="form-control" maxlength="5" size="10" value="<?php echo Option::get('index_newlognum'); ?>" name="index_newlog" /> <input type="submit" name="" value="更改" class="btn btn-primary btn-sm" /></li>
                                </form>
                            </div>
                        </div>
                    </div>  

                    <div id="hotlog" class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href=".hotlog" class="widget-title" aria-expanded="false">热门文章</a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                        </div>
                        <div class="hotlog panel-collapse collapse" aria-expanded="false">
                            <div class="panel-body">
                                <form action="widgets.php?action=setwg&wg=hotlog" method="post" class="form-inline">
                                    <li>标题</li>
                                    <li><input type="text" name="title" class="form-control" value="<?php echo $customWgTitle['hotlog']; ?>"  /></li>
                                    <li>显示热门文章数</li>
                                    <li><input class="form-control" maxlength="5" size="10" value="<?php echo Option::get('index_hotlognum'); ?>" name="index_hotlognum" /> <input type="submit" name="" value="更改" class="btn btn-primary btn-sm" /></li>
                                </form>
                            </div>
                        </div>
                    </div>  

                    <div id="random_log" class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href=".random_log" class="widget-title" aria-expanded="false">随机文章</a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                        </div>
                        <div class="random_log panel-collapse collapse" aria-expanded="false">
                            <div class="panel-body">
                                <form action="widgets.php?action=setwg&wg=random_log" method="post" class="form-inline">
                                    <li>标题</li>
                                    <li><input type="text" name="title" class="form-control" value="<?php echo $customWgTitle['random_log']; ?>"  /></li>
                                    <li>显示随机文章数</li>
                                    <li><input class="form-control" maxlength="5" size="10" value="<?php echo Option::get('index_randlognum'); ?>" name="index_randlognum" /> <input type="submit" name="" value="更改" class="btn btn-primary btn-sm" /></li>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div id="link" class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href=".link" class="widget-title" aria-expanded="false">链接</a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                        </div>
                        <div class="link panel-collapse collapse" aria-expanded="false">
                            <div class="panel-body">
                                <form action="widgets.php?action=setwg&wg=link" method="post" class="form-inline">
                                    <li><input type="text" name="title" class="form-control" value="<?php echo $customWgTitle['link']; ?>"  /> <input type="submit" name="" value="更改" class="btn btn-primary btn-sm" /></li>
                                </form>
                            </div>
                        </div>
                    </div> 

                    <div id="search" class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href=".search" class="widget-title" aria-expanded="false">搜索</a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                        </div>
                        <div class="search panel-collapse collapse" aria-expanded="false">
                            <div class="panel-body">
                                <form action="widgets.php?action=setwg&wg=search" method="post" class="form-inline">
                                    <li><input type="text" name="title" value="<?php echo $customWgTitle['search']; ?>" class="form-control" /> <input type="submit" name="" value="更改" class="btn btn-primary btn-sm" /></li>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                自定义组件
            </div>
            <div class="panel-body">
                <div class="panel-group" id="accordion">
                        <?php
                        foreach ($custom_widget as $key => $val):
                        preg_match("/^custom_wg_(\d+)/", $key, $matches);
                        $custom_wg_title = empty($val['title']) ? '未命名组件(' . $matches[1] . ')' : $val['title'];
                        ?>
                        <div class="panel panel-default" id="<?php echo $key; ?>">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $key; ?>" aria-expanded="false" class="widget-title"><?php echo $custom_wg_title; ?></a>
                                    <li class="widget-act-add"></li>
                                    <li class="widget-act-del"></li>
                                </h4>
                            </div>
                            <div id="collapse_<?php echo $key; ?>" class="panel-collapse collapse" aria-expanded="false">
                                <div class="panel-body" class="form-group">
                                    <form action="widgets.php?action=setwg&wg=custom_text" method="post">
                                        <li>
                                            <input type="hidden" name="custom_wg_id" value="<?php echo $key; ?>" />
                                            <input type="text" name="title" class="form-control" value="<?php echo $val['title']; ?>" /><br />
                                        </li>
                                        <li><textarea class="form-control" name="content" style="overflow:auto; height:260px;"><?php echo $val['content']; ?></textarea><br /></li>
                                        <li>
                                            <input type="submit" class="btn btn-primary" name="" value="更改" />
                                            <a class="btn btn-danger" href="widgets.php?action=setwg&wg=custom_text&rmwg=<?php echo $key; ?>">删除该组件</a>
                                        </li>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <p style="margin:20px 0px;"><a class="btn btn-success" href="javascript:displayToggle('custom_text_new', 2);">添加组件+</a></p>

                    <form action="widgets.php?action=setwg&wg=custom_text" method="post" class="form-inline">
                        <div id="custom_text_new" style="display:none;" class="form-group">
                            <li>组件名</li>
                            <li><input type="text" class="form-control" name="new_title" style="width:384px;" value="" /></li>
                            <li>内容 （支持html）</li>
                            <li><textarea name="new_content" class="form-control" rows="10" style="width:380px;overflow:auto;"></textarea></li>
                            <li><input type="submit" class="btn btn-primary btn-sm" name="" value="添加组件"  /></li>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                使用中的组件
            </div>
            <form action="widgets.php?action=compages" method="post" class="form-inline">
                <div class="panel-body">
                    <div class="panel-group adm_widget_box" id="sortable">
                        <?php
                        foreach ($widgets as $widget):
                            $flg = strpos($widget, 'custom_wg_') === 0 ? true : false; //是否为自定义组件
                            $title = ($flg && isset($custom_widget[$widget]['title'])) ? $custom_widget[$widget]['title'] : ''; //获取自定义组件标题
                            if ($flg && empty($title)) {
                                preg_match("/^custom_wg_(\d+)/", $widget, $matches);
                                $title = '未命名组件(' . $matches[1] . ')';
                            }
                            ?>
                        <div class="panel panel-default active_widget" id="em_<?php echo $widget; ?>" style="cursor:move;">
                                <div class="panel-heading">
                                    <input type="hidden" name="widgets[]" value="<?php echo $widget; ?>" />
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
                <input type="hidden" name="wgnum" id="wgnum" value="<?php echo $wgNum; ?>" />
                <div style="margin:20px 40px;"><input type="submit" value="保存组件排序" class="btn btn-primary" /> <a href="javascript:em_confirm(0, 'reset_widget', '<?php echo LoginAuth::genToken(); ?>');" class="btn btn-danger" >恢复出厂设置</a></div>
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

        //添加组件
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
        //删除组件
        $("#adm_widget_list .widget-act-del").click(function(){
            var widget_id = $(this).parent().parent().parent().attr("id");
            $(".adm_widget_box #em_" + widget_id).remove();
            $(this).hide();
            $(this).prev(".widget-act-add").show();
        });

        //拖动
        $( "#sortable" ).sortable();
        $( "#sortable" ).disableSelection();
        
        //自定义组件记忆
        $("#custom_text_new").css('display', $.cookie('em_custom_text_new') ? $.cookie('em_custom_text_new') : 'none');

        $("#menu_view").addClass('in');
        $("#menu_widget").addClass('active');
    });
</script>
