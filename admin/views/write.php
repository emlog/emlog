<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $containertitle; ?></h1>
    <span id="msg_2"></span>
    <form action="save_log.php?action=add" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
        <!--文章内容-->
        <div class="row">
            <div class="col-xl-8">
                <div id="msg"></div>
                <div id="post" class="form-group">
                    <div>
                        <input type="text" name="title" id="title" value="<?php echo $title; ?>" class="form-control" placeholder="文章标题"/>
                    </div>
                    <div id="post_bar">
                        <a href="#" class="text-muted small my-3" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus"></i> 上传文件\图片</a>
                        <div id="FrameUpload" style="display: none;">
                            <iframe width="100%" height="330" frameborder="0" src="<?php echo $att_frame_url; ?>"></iframe>
                        </div>
                    </div>
                    <div id="editor"></div>
                    <!--                    <div>-->
                    <!--                        <textarea id="logcontent" name="logcontent" style="width:100%; height:460px;">--><?php //echo $content; ?><!--</textarea>-->
                    <!--                    </div>-->
                    <div class="show_advset" onclick="displayToggle('advset', 1);">高级选项<i class="fa fa-caret-right fa-fw"></i></div>
                    <div id="advset">
                        <div>文章摘要：</div>
                        <div><textarea id="logexcerpt" name="logexcerpt" style="width:100%; height:260px;"><?php echo $excerpt; ?></textarea></div>
                    </div>
                </div>
                <div class=line></div>
            </div>

            <!--文章侧边栏-->
            <div class="col-xl-4 container-side">
                <div class="panel panel-default">
                    <div class="panel-heading">设置项</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <select name="sort" id="sort" class="form-control">
                                <option value="-1">选择分类...</option>
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
                            <label>标签：</label>
                            <input name="tag" id="tag" class="form-control" value="<?php echo $tagStr; ?>" placeholder="文章标签，使用逗号分隔"/>
                            <span style="color:#2A9DDB;cursor:pointer;margin-right: 40px;"><a href="javascript:displayToggle('tagbox', 0);">已有标签+</a></span>
                            <div id="tagbox" style="display: none;">
                                <?php
                                if ($tags) {
                                    foreach ($tags as $val) {
                                        echo " <a class='badge badge-pill badge-success' href=\"javascript: insertTag('{$val['tagname']}','tag');\">{$val['tagname']}</a> ";
                                    }
                                } else {
                                    echo '还没有设置过标签！';
                                }
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>发布时间：</label>
                            <input maxlength="200" name="postdate" id="postdate" value="<?php echo $postDate; ?>" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label>链接别名：</label>
                            <input name="alias" id="alias" class="form-control" value="<?php echo $alias; ?>"/>
                        </div>

                        <div class="form-group">
                            <label>访问密码：</label>
                            <input type="text" name="password" id="password" class="form-control" value="<?php echo $password; ?>"/>
                        </div>

                        <div class="form-group">
                            <input type="checkbox" value="y" name="top" id="top" <?php echo $is_top; ?> />
                            <label for="top">首页置顶</label>
                            <input type="checkbox" value="y" name="sortop" id="sortop" <?php echo $is_sortop; ?> />
                            <label for="sortop">分类置顶</label>
                            <input type="checkbox" value="y" name="allow_remark" id="allow_remark" checked="checked" <?php echo $is_allow_remark; ?> />
                            <label for="allow_remark">允许评论</label>
                        </div>
                    </div>
                </div>

                <div id="post_button">
                    <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
                    <input type="hidden" name="ishide" id="ishide" value="<?php echo $hide; ?>"/>
                    <input type="hidden" name="gid" value=<?php echo $logid; ?>/>
                    <input type="hidden" name="author" id="author" value=<?php echo $author; ?>/>

                    <?php if ($logid < 0): ?>
                        <input type="submit" value="发布文章" onclick="return checkform();" class="btn btn-success"/>
                        <input type="button" name="savedf" id="savedf" value="保存草稿" onclick="autosave(2);" class="btn btn-success"/>
                    <?php else: ?>
                        <input type="submit" value="保存并返回" onclick="return checkform();" class="btn btn-success"/>
                        <input type="button" name="savedf" id="savedf" value="保存" onclick="autosave(2);" class="btn btn-success"/>
                        <?php if ($isdraft) : ?>
                            <input type="submit" name="pubdf" id="pubdf" value="发布" onclick="return checkform();" class="btn btn-success"/>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </form>
</div>


<div class="modal fade bd-example-modal-lg" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a class="btn btn-success fileinput-button dz-clickable"><i class="glyphicon glyphicon-plus"></i>选择文件上传...</a>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- HTML heavily inspired by http://blueimp.github.io/jQuery-File-Upload/ -->
                <div class="table table-striped" class="files" id="previews">
                    <div id="template" class="file-row">
                        <!-- This is used as the file preview template -->
                        <div>
                            <span class="preview"><img data-dz-thumbnail/></span>
                        </div>
                        <div>
                            <p class="name" data-dz-name></p>
                            <strong class="error text-danger" data-dz-errormessage></strong>
                        </div>
                        <div>
                            <p class="size" data-dz-size></p>
                            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary start">
                                <i class="glyphicon glyphicon-upload"></i>
                                <span>Start</span>
                            </button>
                            <button data-dz-remove class="btn btn-warning cancel">
                                <i class="glyphicon glyphicon-ban-circle"></i>
                                <span>Cancel</span>
                            </button>
                            <button data-dz-remove class="btn btn-danger delete">
                                <i class="glyphicon glyphicon-trash"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

<script>
    setTimeout("autosave(0)", 60000);
    $("#menu_category_content").addClass('active');
    $("#menu_content").addClass('show');
    $("#menu_write").addClass('active');


    ClassicEditor
        .create( document.querySelector( '#editor' ), {
            toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
                ]
            }
        } )
        .catch(error => {
            console.error(error);
        });


    $("#alias").keyup(function () {
        checkalias();
    });

    // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
    var previewNode = document.querySelector("#template");
    previewNode.id = "";
    var previewTemplate = previewNode.parentNode.innerHTML;
    previewNode.parentNode.removeChild(previewNode);

    var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
        url: "/target-url", // Set the url
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 20,
        previewTemplate: previewTemplate,
        autoQueue: false, // Make sure the files aren't queued until manually added
        previewsContainer: "#previews", // Define the container to display the previews
        clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
    });

    myDropzone.on("addedfile", function (file) {
        // Hookup the start button
        file.previewElement.querySelector(".start").onclick = function () {
            myDropzone.enqueueFile(file);
        };
    });

    // Update the total progress bar
    myDropzone.on("totaluploadprogress", function (progress) {
        document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
    });

    myDropzone.on("sending", function (file) {
        // Show the total progress bar when upload starts
        document.querySelector("#total-progress").style.opacity = "1";
        // And disable the start button
        file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
    });

    // Hide the total progress bar when nothing's uploading anymore
    myDropzone.on("queuecomplete", function (progress) {
        document.querySelector("#total-progress").style.opacity = "0";
    });
</script>
