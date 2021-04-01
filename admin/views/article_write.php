<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<h1 class="h3 mb-4 text-gray-800"><?php echo $containertitle; ?></h1>
<form action="article_save.php?action=add" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
    <!--文章内容-->
    <div class="row">
        <div class="col-xl-8">
            <div id="msg"></div>
            <div id="post" class="form-group">
                <div>
                    <input type="text" name="title" id="title" value="<?php echo $title; ?>" class="form-control" placeholder="文章标题"/>
                </div>
                <div id="post_bar">
                    <a href="#" class="text-muted small my-3" data-toggle="modal" data-target="#addModal"><i class="icofont-plus"></i> 上传文件\图片</a>
                </div>
				<?php doAction('adm_writelog_head'); ?>
                <span id="asmsg"></span>
                <input type="hidden" name="as_logid" id="as_logid" value="<?php echo $logid; ?>">
                <textarea id="logcontent" name="logcontent""><?php echo $content; ?></textarea>
                <div class="show_advset" onclick="displayToggle('advset', 1);">文章摘要<i class="icofont-simple-right"></i></div>
                <div id="advset">
                    <textarea id="logexcerpt" name="logexcerpt"><?php echo $excerpt; ?></textarea>
                </div>
            </div>
            <div class=line></div>
        </div>
        <!--文章侧边栏-->
        <div class="col-xl-4">
            <div class="panel panel-default">
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

<!--资源库-->
<div class="modal fade bd-example-modal-lg" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">资源库</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>

        </div>
    </div>
</div>

<script>
    setTimeout("autosave(0)", 60000);
    $("#menu_category_content").addClass('active');
    $("#menu_content").addClass('show');
    $("#menu_write").addClass('active');


    ClassicEditor.create(document.querySelector('#logcontent'), {
        toolbar: {
            items: [
                'heading', '|',
                'fontfamily', 'fontsize', '|',
                'alignment', '|',
                'fontColor', 'fontBackgroundColor', '|',
                'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', '|',
                'link', '|',
                'outdent', 'indent', '|',
                'bulletedList', 'numberedList', 'todoList', '|',
                'code', 'codeBlock', '|',
                'insertTable', '|',
                'uploadImage', 'blockQuote', '|',
                'undo', 'redo'
            ],
            shouldNotGroupWhenFull: true
        }
    }).catch(error => {
        console.error(error);
    });

    ClassicEditor.create(document.querySelector('#logexcerpt'), {
        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
        heading: {
            options: [
                {model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph'},
                {model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1'},
                {model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2'}
            ]
        }
    }).catch(error => {
        console.error(error);
    });


    $("#alias").keyup(function () {
        checkalias();
    });

</script>
