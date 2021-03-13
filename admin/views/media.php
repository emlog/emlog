<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<div class="container-fluid">
    <?php if (isset($_GET['active_del'])): ?>
        <div class="alert alert-success">删除成功</div><?php endif; ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">资源管理</h1>
    </div>
    <form action="link.php?action=link_taxis" method="post">
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
                            <td><a href="javascript: em_confirm(<?php echo $value['aid']; ?>, 'attachment', '<?php echo LoginAuth::genToken(); ?>');">删除</a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>
<script>
    $("#menu_media").addClass('active');
    setTimeout(hideActived, 3600);
</script>
