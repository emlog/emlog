<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<?php if (isset($_GET['active_del'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('media_deleted_ok')?></div><?php endif; ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<!--vot--><h1 class="h3 mb-0 text-gray-800"><?=lang('resouce_manage')?></h1>
<!--vot--><a href="#" class="d-none d-sm-inline-block btn btn-success shadow-sm" data-toggle="modal" data-target="#exampleModal"><i class="icofont-plus"></i> <?=lang('upload_files')?></a>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th><input type="checkbox" id="checkAll"/></th>
<!--vot-->      <th><?=lang('preview')?></th>
<!--vot-->      <th><?=lang('status')?></th>
<!--vot-->      <th><?=lang('time')?></th>
<!--vot-->      <th><?=lang('operation')?></th>
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
<!--vot-->          <td><a href="javascript: em_confirm(<?php echo $value['aid']; ?>, 'media', '<?php echo LoginAuth::genToken(); ?>');" class="badge badge-danger"><?=lang('delete')?></a>
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
<!--vot-->      <h5 class="modal-title" id="exampleModalLabel"><?=lang('upload_files')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="./media.php?action=upload_multi" class="dropzone" id="my-awesome-dropzone"></form>
            </div>

        </div>
    </div>
</div>

<script src="./views/js/dropzone.min.js"></script>

<script>
    $("#menu_media").addClass('active');
    setTimeout(hideActived, 3600);

    $('#exampleModal').on('hidden.bs.modal', function (e) {
        window.location.reload();
    })

</script>
