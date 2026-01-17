<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800"><?= _lang('setting'); ?></h1>
</div>
<div class="panel-heading">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="./setting.php"><?= _lang('setting_basic'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=user"><?= _lang('setting_user'); ?></a></li>
        <li class="nav-item"><a class="nav-link active" href="./setting.php?action=mail"><?= _lang('setting_mail'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=seo"><?= _lang('setting_seo'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=api"><?= _lang('setting_api'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=ai"><?= _lang('setting_ai'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./blogger.php"><?= _lang('setting_profile'); ?></a></li>
    </ul>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <form action="setting.php?action=mail_save" method="post" name="mail_setting_form" id="mail_setting_form">
            <h4><?= _lang('mail_service'); ?></h4>
            <div class="form-group">
                <label><?= _lang('mail_sender'); ?></label>
                <input type="email" class="form-control" value="<?= $smtp_mail ?>" name="smtp_mail">
            </div>
            <div class="form-group">
                <label><?= _lang('smtp_password'); ?></label>
                <input type="password" name="smtp_pw" class="form-control" value="<?= $smtp_pw ?>" autocomplete="new-password">
            </div>
            <div class="form-group">
                <label><?= _lang('mail_sender_name'); ?></label>
                <input type="text" class="form-control" value="<?= $smtp_from_name ?>" name="smtp_from_name">
            </div>
            <div class="form-group">
                <label><?= _lang('smtp_server'); ?></label>
                <input type="text" class="form-control" value="<?= $smtp_server ?>" name="smtp_server">
            </div>
            <div class="form-group">
                <label><?= _lang('smtp_port_desc'); ?></label>
                <input type="number" class="form-control" value="<?= $smtp_port ?>" name="smtp_port">
            </div>
            <div class="form-group">
                <input type="button" value="<?= _lang('send_test'); ?>" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#testMail" />
            </div>
            <div class="alert alert-warning">
                <b><?= _lang('mail_config_example'); ?></b><br>
                <?= _lang('mail_example_content'); ?>
            </div>
            <!-- 设置接收邮箱的模态框 -->
            <div class="modal fade" id="testMail">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header border-0">
                            <h4 class="modal-title"><?= _lang('send_test'); ?></h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input class="form-control" type="email" name="testTo" placeholder="<?= _lang('input_receiver_email'); ?>">
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <div id="testMailMsg"></div>
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><?= _lang('close'); ?></button>
                            <button type="button" class="btn btn-success btn-sm" id="testSendBtn"><?= _lang('send'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <h4><?= _lang('mail_template'); ?></h4>
            <div class="my-3">
                <div class="mb-3" id="mail_template_box"><?= _lang('select_template'); ?>：<a href="javascript:useDefaultTemplate();"><?= _lang('template_simple'); ?></a>
                    <a href="javascript:useDeepBlueTemplate();"><?= _lang('template_deep_blue'); ?></a>
                    <a href="javascript:useGreenVibrantTemplate();"><?= _lang('template_green'); ?></a>
                    <span id="mail_template_box_ext"></span>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <textarea id="mail_template" name="mail_template" rows="10" class="form-control" placeholder="<?= _lang('mail_template_placeholder'); ?>"><?= $mail_template ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <iframe id="mail_review_frame"></iframe>
                    </div>
                </div>
                <div class="mb-3 mt-1 small" id="mail_template_vars"><?= _lang('mail_template_vars'); ?></div>
            </div>
            <h4><?= _lang('setting_mail'); ?></h4>
            <div class="custom-control custom-switch">
                <input class="custom-control-input" type="checkbox" value="y" name="mail_notice_comment" id="mail_notice_comment" <?= $conf_mail_notice_comment ?> />
                <label class="custom-control-label" for="mail_notice_comment"><?= _lang('mail_notice_comment'); ?></label>
            </div>
            <div class="custom-control custom-switch">
                <input class="custom-control-input" type="checkbox" value="y" name="mail_notice_post" id="mail_notice_post" <?= $conf_mail_notice_post ?>>
                <label class="custom-control-label" for="mail_notice_post"><?= _lang('mail_notice_post'); ?></label>
            </div>
            <div class="form-group">
                <hr>
                <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                <input type="submit" value="<?= _lang('save'); ?>" class="btn btn-sm btn-success" />
            </div>
        </form>
    </div>
</div>
<script>
    function updatePreview() {
        const htmlCode = htmlInput.value;
        const previewDocument = previewFrame.contentDocument;
        previewDocument.open();
        previewDocument.write(htmlCode);
        previewDocument.close();
    }

    function useDefaultTemplate() {
        const defaultTemplate = `<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f7f7f7;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 4px 16px rgba(0,0,0,.1);">
        <div style="border-bottom: 1px solid #e0e0e0; padding-bottom: 10px; margin-bottom: 20px;">
            <h1 style="font-size: 24px; margin: 0; color: #333;">{{mail_site_title}}</h1>
        </div>
        <div style="font-size: 16px; color: #333; line-height: 1.6;">
            <p>{{mail_content}}</p>
        </div>
        <div style="border-top: 1px solid #e0e0e0; padding-top: 10px; text-align: center; font-size: 12px; color: #888; margin-top: 20px;">
            <small>来自站点：{{mail_site_title}}</small>
        </div>
    </div>
</body>
</html>`;
        $('#mail_template').val(defaultTemplate);
        updatePreview();
    }

    function useDeepBlueTemplate() {
        const deepBlueTemplate = `<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{font-family:Arial,sans-serif;margin:0;padding:0;background:#f7f9fb}.container{max-width:600px;margin:0 auto;background:#fff;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,.1)}.header{background:#0066cc;color:#fff;padding:20px;text-align:center}.header h1{margin:0;font-size:24px}.content{padding:20px;color:#333;line-height:1.6}.footer{padding:15px;text-align:center;font-size:12px;color:#888;background:#f7f9fb}.divider{margin:20px 0;border-bottom:1px solid #e0e0e0}.cta-button{display:inline-block;background:#0066cc;color:#fff;padding:12px 20px;text-decoration:none;border-radius:30px;font-weight:bold;margin-top:20px}.cta-button:hover{background:#004d99}
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{mail_site_title}}</h1>
        </div>
        <div class="content">
            <p>{{mail_content}}</p>
            <div class="divider"></div>
        </div>
        <div class="footer">
            <small>来自站点：{{mail_site_title}}</small>
        </div>
    </div>
</body>
</html>`;
        $('#mail_template').val(deepBlueTemplate);
        updatePreview();
    }

    function useGreenVibrantTemplate() {
        const greenVibrantTemplate = `<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{font-family:'Arial',sans-serif;margin:0;padding:0;background:#e8f7ec}
        .container{max-width:600px;margin:0 auto;background:#ffffff;border-radius:12px;box-shadow:0 4px 16px rgba(0,0,0,.1)}
        .header{background:#4caf50;color:#fff;padding:20px;text-align:center;border-radius:12px 12px 0 0}
        .header h1{margin:0;font-size:28px;font-weight:bold}
        .content{padding:25px;color:#333333;line-height:1.8;text-align:center}
        .content p{font-size:18px;margin:0 0 20px}
        .content .cta-button{display:inline-block;background:#66bb6a;color:#fff;padding:14px 24px;text-decoration:none;border-radius:50px;font-weight:bold;font-size:18px;box-shadow:0 4px 8px rgba(0,0,0,.1);transition:background-color .3s ease-in-out}
        .content .cta-button:hover{background:#388e3c}
        .footer{padding:15px;text-align:center;font-size:14px;color:#777;background:#4caf50;border-radius:0 0 12px 12px}
        .footer small{display:block}
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{mail_site_title}}</h1>
        </div>
        <div class="content">
            <p>{{mail_content}}</p>
        </div>
        <div class="footer">
            <small>来自站点：{{mail_site_title}}</small>
        </div>
    </div>
</body>
</html>`;
        $('#mail_template').val(greenVibrantTemplate);
        updatePreview();
    }
    // mail template preview
    const htmlInput = document.getElementById('mail_template');
    const previewFrame = document.getElementById('mail_review_frame');
    updatePreview();
    htmlInput.addEventListener('input', updatePreview);

    $(function() {
        // menu
        $("#menu_category_sys").addClass('active');
        $("#menu_sys").addClass('show');
        $("#menu_setting").addClass('active');
        setTimeout(hideActived, 3600);

        // 提交表单
        $("#mail_setting_form").submit(function(event) {
            event.preventDefault();
            submitForm("#mail_setting_form");
        });

        // test sendmail
        $("#testSendBtn").click(function() {
            $("#testMailMsg").html("<small class='text-secondary'>发送中...</small>");
            $.post("setting.php?action=mail_test", $("#mail_setting_form").serialize(), function(data) {
                if (data === '') {
                    $("#testMailMsg").html("<small class='text-success'>发送成功</small>");
                } else {
                    $("#testMailMsg").html(data);
                }

            });
        })
    });
</script>