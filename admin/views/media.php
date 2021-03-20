<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<?php if (isset($_GET['active_del'])): ?>
    <div class="alert alert-success">删除成功</div><?php endif; ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">资源管理</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-success shadow-sm" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> 上传文件</a>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th><input type="checkbox" id="checkAll"/></th>
                <th>文件</th>
                <th>状态</th>
                <th>日期</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody
            <?php
            foreach ($attach as $key => $value):
                $extension = strtolower(substr(strrchr($value['filepath'], "."), 1));
                $atturl = BLOG_URL . substr($value['filepath'], 3);
                if ($extension == 'zip' || $extension == 'rar') {
                    $imgpath = "./views/images/tar.gif";
                } elseif (in_array($extension, array('gif', 'jpg', 'jpeg', 'png', 'bmp'))) {
                    $imgpath = $value['filepath'];
                    $ed_imgpath = BLOG_URL . substr($imgpath, 3);
                    if (isset($value['thum_filepath'])) {
                        $thum_url = BLOG_URL . substr($value['thum_filepath'], 3);
                    }
                } else {
                    $imgpath = "./views/images/fnone.gif";
                }
                ?>
                <tr>
                    <td><input type="checkbox" value="<?php echo $value['aid']; ?>" name="atts[]" class="ids"/></td>
                    <td>
                        <a href="<?php echo $atturl; ?>" target="_blank" title="<?php echo $value['filename']; ?>">
                            <img src="<?php echo $imgpath; ?>" width="90" height="90" border="0" align="absmiddle"/>
                        </a>
                    </td>
                    <td>
                        <?php echo subString($value['filename'], 0, 60) ?> <br>
                        <?php if ($value['width'] && $value['height']): ?>
                            <?php echo $value['width'] ?>x<?php echo $value['height'] ?>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $value['addtime']; ?></td>
                    <td><a href="javascript: em_confirm(<?php echo $value['aid']; ?>, 'attachment', '<?php echo LoginAuth::genToken(); ?>');" class="badge badge-danger">删除</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    $("#menu_media").addClass('active');
    setTimeout(hideActived, 3600);

    //文件上传
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
