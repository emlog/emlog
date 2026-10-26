<?php
defined('EMLOG_ROOT') || exit('access denied!');

$MediaSort_Model = new MediaSort_Model();
$mediaSorts = $MediaSort_Model->getSorts();
?>
<div class="modal fade" id="mediaModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="exampleModalLabel"><?= _lang('media_lib') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap" style="gap: 8px;">
                    <div><a href="#" id="mediaAdd" class="btn btn-sm btn-success shadow-sm"><?= _lang('upload_file') ?></a></div>
                    <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                        <?php if (User::haveEditPermission() && isset($mediaSorts) && $mediaSorts): ?>
                            <select class="form-control" id="media-sort-select" style="width: auto;">
                                <option value=""><?= _lang('select_media_category') ?></option>
                                <?php foreach ($mediaSorts as $v): ?>
                                    <option value="<?= $v['id'] ?>"><?= $v['sortname'] ?></option>
                                <?php endforeach ?>
                            </select>
                        <?php endif ?>
                        <div class="position-relative" style="width: 220px;">
                            <input type="text" class="form-control" id="media-search-keyword" placeholder="<?= _lang('search_media_placeholder') ?>" aria-label="<?= _lang('search') ?>" autocomplete="off" style="padding-right: 32px;">
                            <button type="button" class="btn btn-link text-muted p-0 position-absolute" id="media-search-btn" style="right: 10px; top: 50%; transform: translateY(-50%); border: none; background: transparent; box-shadow: none; line-height: 1;" title="<?= _lang('search') ?>">
                                <i class="icofont-search-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <form action="media.php?action=operate_media" method="post" name="form_media" id="form_media">
                    <div class="row" id="image-list"></div>
                    <div class="text-center">
                        <button type="button" class="btn btn-success btn-sm mt-2" id="load-more"><?= _lang('load_more') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="dropzone-previews" style="display: none;"></div>
<input type="hidden" id="media_lib_token" value="<?= LoginAuth::genToken() ?>">
<script src="./views/js/dropzone.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
<script src="./views/js/media-lib.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>