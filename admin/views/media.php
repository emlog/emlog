<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['active_mov'])): ?>
    <div class="alert alert-success"><?= _lang('move_success') ?></div><?php endif ?>
<?php if (isset($_GET['active_edit'])): ?>
    <div class="alert alert-success"><?= _lang('edit_success') ?></div><?php endif ?>
<?php if (isset($_GET['active_add'])): ?>
    <div class="alert alert-success"><?= _lang('add_success') ?></div><?php endif ?>
<?php if (isset($_GET['error_url'])): ?>
    <div class="alert alert-danger"><?= _lang('url_format_error') ?></div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger"><?= _lang('name_required') ?></div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800"><?= _lang('media_lib') ?></h1>
    <span>
        <a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target="#exampleModal"><i class="icofont-plus"></i> <?= _lang('upload_file') ?></a>
        <a href="#" class="btn btn-sm btn-primary shadow-sm mt-4" data-toggle="modal" data-target="#externalResourceModal"><i class="icofont-link"></i> <?= _lang('add_external_resource') ?></a>
    </span>
</div>
<?php if (User::isAdmin()): ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <a href="media.php" class="btn btn-sm btn-primary mr-2 my-1"><?= _lang('all_media') ?></a>
            <?php foreach ($sorts as $key => $val):
                $cur_tab = $val['id'] == $sid ? "btn-primary" : "btn-success";
            ?>
                <div class="btn-group mr-2 my-1">
                    <a href="media.php?sid=<?= $val['id'] ?>" class="btn btn-sm <?= $cur_tab ?>"><?= $val['sortname'] ?></a>
                    <button type="button" class="btn <?= $cur_tab ?> btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-expanded="false"></button>
                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#editModal" data-id="<?= $val['id'] ?>" data-sortname="<?= $val['sortname'] ?>"><?= _lang('edit') ?></a>
                        <a class="dropdown-item text-danger" href="javascript: em_confirm(<?= $val['id'] ?>, 'media_sort', '<?= LoginAuth::genToken() ?>');"><?= _lang('delete') ?></a>
                    </div>
                </div>
            <?php endforeach ?>
            <?php if ($sorts): ?>
                <a href="media.php?sid=na" class="btn btn-sm <?= $sid === 'na' ? "btn-primary" : "btn-light" ?> mr-2 my-1"><?= _lang('uncategorized') ?></a>
            <?php endif ?>
            <a href="#" class="btn btn-light btn-sm my-1" data-toggle="modal" data-target="#mediaSortModal"><i class="icofont-plus"></i> <?= _lang('category') ?></a>
        </div>
        <div class="d-flex align-items-center mb-3 mb-sm-0">
            <div class="mr-2">
                <?php if ($show === 'grid'): ?>
                    <a href="media.php?show=list">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="24" height="24">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M8 6L21 6.00078M8 12L21 12.0008M8 18L21 18.0007M3 6.5H4V5.5H3V6.5ZM3 12.5H4V11.5H3V12.5ZM3 18.5H4V17.5H3V18.5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                        </svg>
                    </a>
                <?php else: ?>
                    <a href="media.php?show=grid">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="24" height="24">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M3.5 3.5H10.5V10.5H3.5V3.5Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M3.5 13.5H10.5V20.5H3.5V13.5Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M13.5 3.5H20.5V10.5H13.5V3.5Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M13.5 13.5H20.5V20.5H13.5V13.5Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                        </svg>
                    </a>
                <?php endif ?>
            </div>
            <div class="flex-fill">
                <input type="text" class="form-control datepicker" value="<?= $dateTime ?>" placeholder="<?= _lang('view_date_before') ?>">
            </div>
            <div class="ml-2">
                <form action="./media.php" method="get" class="form-inline w-100">
                    <div class="input-group">
                        <input type="text" name="keyword" value="<?= $keyword ?>" class="form-control small" placeholder="<?= _lang('search_media_placeholder') ?>">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-success" type="submit">
                                <i class="icofont-search-2"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>
<form action="media.php?action=operate_media" method="post" name="form_media" id="form_media">
    <?php if ($show === 'list'): ?>
        <!-- 列表模式 -->
        <div class="card shadow mb-4">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped table-hover dataTable no-footer">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAllItem" /></th>
                            <th><?= _lang('media_name') ?></th>
                            <th><?= _lang('file_size') ?></th>
                            <th><?= _lang('creator') ?></th>
                            <th><?= _lang('time') ?></th>
                            <th><?= _lang('operation') ?></th>
                        </tr>
                    </thead>
                    <tbody class="checkboxContainer">
                        <?php foreach ($medias as $key => $value):
                            $media_url = getFileUrl($value['filepath']);
                            $sort_name = $value['sortname'];
                            $media_name = $value['filename'];
                            $author = $user_cache[$value['author']]['name'];
                            if (isImage($value['mimetype'])) {
                                $media_icon = '🖼️';
                                $img_viewer = 'class="highslide" onclick="return hs.expand(this)"';
                            } elseif (isZip($value['filename'])) {
                                $media_icon = "📦";
                                $img_viewer = '';
                            } elseif (isVideo($value['mimetype'])) {
                                $media_icon = "🎬";
                                $img_viewer = '';
                            } elseif (isAudio($value['filename'])) {
                                $media_icon = "🎧";
                                $img_viewer = '';
                            } else {
                                $media_icon = "";
                                $img_viewer = '';
                            }
                        ?>
                            <tr>
                                <td style="width: 20px;"><input type="checkbox" name="aids[]" value="<?= $value['aid'] ?>" class="aids" /></td>
                                <td>
                                    <?= $media_icon ?>
                                    <a href="<?= $media_url ?>" <?= $img_viewer ?> target="_blank"><?= $media_name ?></a> <span class="badge badge-success"><?= $sort_name ?></span>
                                    <br><span class="small"><?= _lang('source_file') ?>：<a href="#" class="copy-link text-muted" data-toggle="popover" data-url="<?= $media_url ?>"><?= $media_url ?></a></span>
                                    <?php if ($value['width'] && $value['height']): ?>
                                        <br><span class="small"><?= _lang('image_size') ?>：<?= $value['width'] ?>x<?= $value['height'] ?></span>
                                    <?php endif ?>
                                </td>
                                <td><?= $value['attsize'] ?></td>
                                <td>
                                    <?php if (User::haveEditPermission()): ?>
                                        <a href="./media.php?uid=<?= $value['author'] ?>"><?= $author ?> </a>
                                    <?php else: ?>
                                        <?= $author ?>
                                    <?php endif; ?>
                                </td>
                                <td><?= $value['addtime'] ?></td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#editMediaModal" data-id="<?= $value['aid'] ?>" data-filename="<?= $media_name ?>" class="badge badge-success"><?= _lang('rename') ?></a>
                                    <a href="#" data-toggle="modal" data-target="#moveMediaModal" data-id="<?= $value['aid'] ?>" data-sortid="<?= $value['sortid'] ?>" class="badge badge-primary"><?= _lang('move') ?></a>
                                    <a href="javascript: em_confirm(<?= $value['aid'] ?>, 'media', '<?= LoginAuth::genToken() ?>');" class="badge badge-danger"><?= _lang('delete') ?></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="row checkboxContainer">
            <!-- 宫格卡片模式 -->
            <?php foreach ($medias as $key => $value):
                $media_url = getFileUrl($value['filepath']);
                $thumbnail_url = $value['thumbnail_url'];
                $sort_name = $value['sortname'];
                $media_name = $value['filename'];
                $author = $user_cache[$value['author']]['name'];
                if (isImage($value['mimetype'])) {
                    $media_icon = getFileUrl($value['filepath_thum']);
                    $img_viewer = 'class="highslide" onclick="return hs.expand(this)"';
                } elseif (isZip($value['filename'])) {
                    $media_icon = "./views/images/zip.webp";
                    $img_viewer = '';
                } elseif (isVideo($value['mimetype'])) {
                    $media_icon = "./views/images/video.webp";
                    $img_viewer = '';
                } elseif (isAudio($value['filename'])) {
                    $media_icon = "./views/images/audio.webp";
                    $img_viewer = '';
                } else {
                    $media_icon = "./views/images/fnone.webp";
                    $img_viewer = '';
                }
            ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm hover-shadow-lg">
                        <a href="<?= $media_url ?>" <?= $img_viewer ?> target="_blank"><img class="card-img-top" loading="lazy" src="<?= $media_icon ?>" /></a>
                        <div class="card-body">
                            <p class="card-text text-muted small">
                                <a href="#" data-toggle="modal" data-target="#editMediaModal" data-id="<?= $value['aid'] ?>" data-filename="<?= $media_name ?>"><?= $media_name ?></a> <span class="badge badge-success"><?= $sort_name ?></span><br>
                                <?= _lang('time') ?>：<?= $value['addtime'] ?><br>
                                <?= _lang('creator') ?>：
                                <?php if (User::haveEditPermission()): ?>
                                    <a href="./media.php?uid=<?= $value['author'] ?>"><?= $author ?> </a>
                                <?php else: ?>
                                    <?= $author ?>
                                <?php endif; ?><br>
                                <?= _lang('file_size') ?>：<?= $value['attsize'] ?>
                                <?php if ($value['width'] && $value['height']): ?>
                                    ，<?= _lang('image_size') ?>：<?= $value['width'] ?>x<?= $value['height'] ?>
                                <?php endif ?><br>
                                <?= _lang('source_file') ?>：<a href="#" class="copy-link text-muted" data-toggle="popover" data-url="<?= $media_url ?>"><?= $media_url ?></a><br>
                                <a href="#" class="copy-link" data-toggle="popover" data-url="<?= $media_url ?>"><?= _lang('original_file_url') ?></a>
                                <?php if ($value['alias'] && isZip($value['filename'])):
                                    $media_down_url = BLOG_URL . '?resource_alias=' . $value['alias'];
                                    $media_down_url_pub = BLOG_URL . '?resource_alias=' . $value['alias'] . '&resource_filename=' . $value['filename_without_ext'];
                                ?>
                                    ｜ <a href="#" class="copy-link" data-toggle="popover" data-url="<?= $media_down_url_pub ?>"><?= _lang('public_download_url') ?></a>
                                    ｜ <a href="#" class="copy-link" data-toggle="popover" data-url="<?= $media_down_url ?>"><?= _lang('login_download_url') ?></a> （<?= _lang('download') ?><?= $value['download_count'] ?>）
                                <?php endif ?>
                                <?php if ($thumbnail_url): ?>
                                    ｜ <a href="#" class="copy-link" data-toggle="popover" data-url="<?= $thumbnail_url ?>"><?= _lang('thumbnail_url') ?></a>
                                <?php endif ?>
                            </p>
                            <p class="card-text d-flex justify-content-between">
                                <span>
                                    <a href="javascript: em_confirm(<?= $value['aid'] ?>, 'media', '<?= LoginAuth::genToken() ?>');" class="text-danger small mr-2"><?= _lang('delete') ?></a>
                                    <a href="#" data-toggle="modal" data-target="#moveMediaModal" data-id="<?= $value['aid'] ?>" data-sortid="<?= $value['sortid'] ?>" class="text-primary small"><?= _lang('move') ?></a>
                                </span>
                                <input type="checkbox" name="aids[]" value="<?= $value['aid'] ?>" class="aids" />
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php if ($count > 0): ?>
        <div class="form-row align-items-center">
            <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
            <input name="operate" id="operate" value="" type="hidden" />
            <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                    <input type="checkbox" class="custom-control-input" id="checkAllItem">
                    <label class="custom-control-label" for="checkAllItem"><?= _lang('select_all') ?></label>
                </div>
            </div>
            <a href="javascript:mediaact('del');" class="btn btn-outline-danger btn-sm"><?= _lang('delete') ?></a>
            <div class="col-auto my-1 form-inline">
                <?php if (User::isAdmin()): ?>
                    <select name="sort" id="sort" onChange="changeSort(this);" class="form-control form-control-sm m-1">
                        <option value="" selected="selected"><?= _lang('move_to') ?></option>
                        <?php foreach ($sorts as $key => $value): ?>
                            <option value="<?= $value['id'] ?>"><?= $value['sortname'] ?></option>
                        <?php endforeach; ?>
                        <option value="0"><?= _lang('uncategorized') ?></option>
                    </select>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</form>
<div class="page"><?= $page ?> </div>
<div class="d-flex justify-content-center mb-4 small">
    <div class="form-inline d-flex flex-wrap justify-content-center align-items-center">
        <label for="perpage_num" class="mr-2"><?= _lang('total') ?> <?= $count ?>, <?= _lang('per_page') ?></label>
        <select name="perpage_num" id="perpage_num" class="form-control form-control-sm w-auto" onChange="changePerPage(this);">
            <option value="12" <?= ($perPage == 12) ? 'selected' : '' ?>>12</option>
            <option value="24" <?= ($perPage == 24) ? 'selected' : '' ?>>24</option>
            <option value="60" <?= ($perPage == 60) ? 'selected' : '' ?>>60</option>
            <option value="120" <?= ($perPage == 120) ? 'selected' : '' ?>>120</option>
            <option value="600" <?= ($perPage == 600) ? 'selected' : '' ?>>600</option>
        </select>
        <script>
            function changePerPage(select) {
                const params = new URLSearchParams(window.location.search);
                params.set('perpage_num', select.value);
                params.set('page', '1');
                window.location.search = params.toString();
            }
        </script>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="exampleModalLabel"><?= _lang('upload_file') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="./media.php?action=upload<?= '&sid=' . $sid ?>" class="dropzone" id="up-form"></form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="externalResourceModal" tabindex="-1" role="dialog" aria-labelledby="externalResourceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="externalResourceModalLabel"><?= _lang('add_external_resource') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="./media.php?action=add_external_resource<?= '&sid=' . $sid ?>" method="post" id="external-resource-form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="external_url"><?= _lang('external_resource_url') ?></label>
                        <input type="url" class="form-control" id="external_url" name="external_url" placeholder="" required>
                        <small class="form-text text-muted"><?= _lang('external_resource_tip') ?></small>
                    </div>
                    <div class="form-group">
                        <label for="resource_name"><?= _lang('media_name') ?></label>
                        <input type="text" class="form-control" id="resource_name" name="resource_name" placeholder="">
                        <small class="form-text text-muted"><?= _lang('resource_name_tip') ?></small>
                    </div>
                    <?php if (User::isAdmin()): ?>
                        <div class="form-group">
                            <label for="resource_sort"><?= _lang('resource_sort') ?></label>
                            <select class="form-control" id="resource_sort" name="resource_sort">
                                <option value="0"><?= _lang('uncategorized') ?></option>
                                <?php foreach ($sorts as $sort): ?>
                                    <option value="<?= $sort['id'] ?>" <?= $sort['id'] == $sid ? 'selected' : '' ?>><?= $sort['sortname'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer border-0">
                    <input name="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?= _lang('cancel') ?></button>
                    <button type="submit" class="btn btn-sm btn-primary"><?= _lang('add_resource') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="mediaSortModal" tabindex="-1" role="dialog" aria-labelledby="mediaSortModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="mediaSortModalLabel"><?= _lang('add_media_category') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="media.php?action=add_media_sort" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="sortname"><?= _lang('category_name') ?></label>
                        <input class="form-control" id="sortname" maxlength="255" name="sortname" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?= _lang('cancel') ?></button>
                    <button type="submit" class="btn btn-sm btn-success"><?= _lang('save') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="exampleModalLabel"><?= _lang('edit_media_category') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="media.php?action=update_media_sort">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="sortname" name="sortname" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <input type="hidden" value="" id="id" name="id" />
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?= _lang('cancel') ?></button>
                    <button type="submit" class="btn btn-sm btn-success"><?= _lang('save') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editMediaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="exampleModalLabel"><?= _lang('edit_media') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="media.php?action=update_media">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="filename"><?= _lang('media_name') ?></label>
                        <input type="text" class="form-control" id="filename" name="filename" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <input type="hidden" value="" id="id" name="id" />
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?= _lang('cancel') ?></button>
                    <button type="submit" class="btn btn-sm btn-success"><?= _lang('save') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="moveMediaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="exampleModalLabel"><?= _lang('move_to_sort') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="media.php?action=operate_media">
                <div class="modal-body">
                    <div class="d-flex flex-wrap" style="max-height: 400px; overflow-y: auto;">
                        <label class="btn btn-outline-success btn-sm m-1 rounded">
                            <input type="radio" name="sort" value="0" autocomplete="off" hidden> <?= _lang('uncategorized') ?>
                        </label>
                        <?php foreach ($sorts as $key => $value): ?>
                            <label class="btn btn-outline-success btn-sm m-1 rounded">
                                <input type="radio" name="sort" value="<?= $value['id'] ?>" autocomplete="off" hidden> <?= $value['sortname'] ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <input type="hidden" name="operate" value="move" />
                    <input type="hidden" name="token" value="<?= LoginAuth::genToken() ?>" />
                    <input type="hidden" name="aids[]" id="move_aid" value="" />
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?= _lang('cancel') ?></button>
                    <button type="submit" class="btn btn-sm btn-success"><?= _lang('save') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="./views/js/dropzone.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
<link rel="stylesheet" type="text/css" href="./views/components/highslide/highslide.css?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>" />
<script src="./views/components/highslide/highslide.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
<script>
    Dropzone.options.upForm = {
        paramName: "file",
        maxFilesize: 20480, // 20G
        timeout: 3600000,
        init: function() {
            this.on("error", function(file, response) {
                // alert(response);
            });
        }
    };
    $(function() {
        $("#menu_media").addClass('active');
        setTimeout(hideActived, 3600);
        $('#exampleModal').on('hidden.bs.modal', function(e) {
            window.location.reload();
        });

        $('#editModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var sortname = button.data('sortname')
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body input').val(sortname)
            modal.find('.modal-footer input').val(id)
        })

        $('#editMediaModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var filename = button.data('filename')
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body input').val(filename)
            modal.find('.modal-footer input').val(id)
        })

        $('#moveMediaModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var sortid = button.data('sortid')
            var modal = $(this)
            modal.find('#move_aid').val(id)

            // Initial selection state
            modal.find('.btn').removeClass('active');
            var $radio = modal.find('input[name="sort"][value="' + sortid + '"]');
            $radio.prop('checked', true);
            $radio.closest('.btn').addClass('active');
        })

        // Update active style on click
        $('#moveMediaModal').on('change', 'input[name="sort"]', function() {
            $('#moveMediaModal .btn').removeClass('active');
            $(this).closest('.btn').addClass('active');
        });

        if (window.outerWidth > 767) {
            hs.graphicsDir = './views/components/highslide/graphics/';
            hs.wrapperClassName = 'rounded-white';
        } else {
            $('.highslide').removeAttr('onclick') // 如果是移动端，则不使用 highslide 功能
        }

        // copy url
        $('.copy-link').click(function(e) {
            e.preventDefault();
            var link = $(this).data('url');
            navigator.clipboard.writeText(link);
            $(this).popover({
                content: '<?= _lang('copy_success') ?>',
                placement: 'top',
                trigger: 'manual'
            }).popover('show');
            setTimeout(() => $(this).popover('hide'), 1000);
        });
    });

    // 日期选择器关闭的回调函数
    function onDatepickerClose(dateText, inst) {
        if (dateText) {
            var date = new Date(dateText);
            var formattedDate = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
            var url = 'media.php?date=' + formattedDate;
            window.location.href = url;
        }
    }

    function mediaact(act) {
        if (getChecked('aids') === false) {
            infoAlert('<?= _lang('select_delete_media') ?>');
            return;
        }

        if (act === 'del') {
            delAlert2('', '<?= _lang('confirm_delete_media') ?>', function() {
                $("#operate").val(act);
                $("#form_media").submit();
            })
            return;
        }
        $("#operate").val(act);
        $("#form_media").submit();
    }

    // 更改分类
    function changeSort(obj) {
        if (getChecked('aids') === false) {
            infoAlert('<?= _lang('select_move_media') ?>');
            return;
        }
        if ($('#sort').val() === '') return;
        $("#operate").val('move');
        $("#form_media").submit();
    }
</script>