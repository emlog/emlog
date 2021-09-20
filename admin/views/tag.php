<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active_del'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('tag_delete_ok')?></div><?php endif; ?>
<?php if (isset($_GET['active_edit'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('tag_modify_ok')?></div><?php endif; ?>
<?php if (isset($_GET['error_a'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('tag_select')?></div><?php endif; ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<!--vot--><h1 class="h3 mb-0 text-gray-800"><?=lang('tag_management')?></h1>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <div>
			<?php if ($tags): ?>
                <p>
					<?php foreach ($tags as $key => $value): ?>
                        <a href="#" class="badge badge-primary" data-toggle="modal" data-target="#editModal" data-tid="<?php echo $value['tid']; ?>"
                           data-tagname="<?php echo $value['tagname']; ?>">
							<?php echo $value['tagname']; ?>
                        </a>
					<?php endforeach; ?>
                </p>
			<?php else: ?>
<!--vot-->      <p style="margin:20px 30px"><?=lang('tags_no_info')?></p>
			<?php endif; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
<!--vot-->      <h5 class="modal-title" id="exampleModalLabel"><?=lang('tag_edit')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="tag.php?action=update_tag">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="tagname" name="tagname" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="" id="tid" name="tid"/>
<!--vot-->          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><?=lang('cancel')?></button>
<!--vot-->          <button type="submit" class="btn btn-sm btn-success"><?=lang('save')?></button>
<!--vot-->          <a class="btn btn-sm btn-outline-danger" href="javascript:deltags();"><?=lang('delete')?></a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#menu_category_content").addClass('active');
    $("#menu_content").addClass('show');
    $("#menu_tag").addClass('active');
    setTimeout(hideActived, 2600);

    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var tagname = button.data('tagname')
        var tid = button.data('tid')
        var modal = $(this)
        modal.find('.modal-body input').val(tagname)
        modal.find('.modal-footer input').val(tid)
    })

    function deltags() {
        var tid = $('#tid').val()
/*vot*/ if(!confirm('<?=lang('tag_delete_sure')?>')) {
            return;
        }
        window.open("./tag.php?action=del_tag&token=<?php echo LoginAuth::genToken(); ?>&tid=" + tid, "_self");
    }
</script>
