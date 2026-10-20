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
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=ai"><?= _lang('setting_ai'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=api"><?= _lang('setting_api'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./blogger.php"><?= _lang('setting_profile'); ?></a></li>
    </ul>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <form action="setting.php?action=mail_save" method="post" name="mail_setting_form" id="mail_setting_form">
            <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
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
            <h4><?= _lang('mail_template'); ?></h4>
            <div class="my-3">
                <div class="mb-3 d-flex align-items-center flex-wrap" id="mail_template_box">
                    <span class="text-secondary mr-2"><?= _lang('select_template'); ?>：</span>
                    <a href="javascript:useDefaultTemplate();" class="badge badge-light border text-secondary px-3 py-2 mr-2 mb-1 shadow-sm" style="font-weight: 500; font-size: 13px; text-decoration: none;"><?= _lang('template_simple'); ?></a>
                    <a href="javascript:useDeepBlueTemplate();" class="badge badge-light border text-primary px-3 py-2 mr-2 mb-1 shadow-sm" style="font-weight: 500; font-size: 13px; text-decoration: none;"><?= _lang('template_deep_blue'); ?></a>
                    <a href="javascript:useGreenVibrantTemplate();" class="badge badge-light border text-success px-3 py-2 mr-2 mb-1 shadow-sm" style="font-weight: 500; font-size: 13px; text-decoration: none;"><?= _lang('template_green'); ?></a>
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
            <div class="form-group">
                <hr>
                <input type="submit" value="<?= _lang('save_setting'); ?>" class="btn btn-sm btn-success" />
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
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
                <input type="submit" value="<?= _lang('save_setting'); ?>" class="btn btn-sm btn-success" />
            </div>
        </div>
    </div>
</form>
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
<script>
    function updatePreview() {
        const htmlCode = htmlInput.value;
        const previewDocument = previewFrame.contentDocument;
        if (!previewDocument) {
            return;
        }
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
    <title>{{mail_site_title}}</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, 'PingFang SC', 'Hiragino Sans GB', 'Microsoft YaHei', sans-serif; margin: 0; padding: 0; background-color: #ffffff; color: #111827; -webkit-font-smoothing: antialiased;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #ffffff; padding: 48px 20px;">
        <tr>
            <td align="center">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="max-width: 580px; text-align: left;">
                    <tr>
                        <td style="padding-bottom: 20px; border-bottom: 2px solid #111827;">
                            <h1 style="font-size: 24px; font-weight: 700; margin: 0; color: #111827; letter-spacing: -0.5px; line-height: 1.2;">{{mail_site_title}}</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 36px 0 40px; font-size: 15px; line-height: 1.75; color: #374151;">
                            {{mail_content}}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 24px; border-top: 1px solid #e5e7eb; font-size: 12px; color: #6b7280; line-height: 1.6;">
                            来自 · <strong>{{mail_site_title}}</strong>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
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
    <title>{{mail_site_title}}</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'PingFang SC', 'Hiragino Sans GB', 'Microsoft YaHei', sans-serif; margin: 0; padding: 0; background-color: #f0f4f8; color: #0f172a; -webkit-font-smoothing: antialiased;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #f0f4f8; padding: 40px 16px;">
        <tr>
            <td align="center">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="max-width: 600px; background-color: #ffffff; border: 2px solid #0f172a; border-radius: 0px; box-shadow: 6px 6px 0px #0f172a;">
                    <tr>
                        <td style="background-color: #0b192c; padding: 24px 30px; border-bottom: 2px solid #0f172a;">
                            <h1 style="font-size: 20px; font-weight: 700; margin: 0; color: #ffffff; letter-spacing: 0.5px;">{{mail_site_title}}</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 32px 30px; font-size: 15px; line-height: 1.7; color: #1e293b; text-align: left;">
                            {{mail_content}}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 16px 30px; background-color: #f8fafc; border-top: 2px solid #0f172a; font-size: 12px; color: #475569;">
                            来自 · <span style="color: #0b192c; font-weight: bold;">{{mail_site_title}}</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
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
    <title>{{mail_site_title}}</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'PingFang SC', 'Hiragino Sans GB', 'Microsoft YaHei', sans-serif; margin: 0; padding: 0; background-color: #f4f7f4; color: #1c2e1c; -webkit-font-smoothing: antialiased;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #f4f7f4; padding: 40px 16px;">
        <tr>
            <td align="center">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="max-width: 580px; background-color: #ffffff; border-radius: 24px; border: 1px solid #dbe6db; box-shadow: 0 12px 36px rgba(44, 76, 44, 0.06); overflow: hidden;">
                    <tr>
                        <td style="padding: 32px 36px 16px; text-align: center;">
                            <h1 style="font-size: 21px; font-weight: 700; margin: 0; color: #1b3d1b; letter-spacing: 0.2px;">{{mail_site_title}}</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 24px 36px 36px; font-size: 15px; line-height: 1.8; color: #2a3d2a; text-align: left;">
                            {{mail_content}}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 18px 36px; background-color: #f4f8f4; border-top: 1px solid #e8f0e8; text-align: center; font-size: 12px; color: #5a755a; border-radius: 0 0 24px 24px;">
                            来自 · <span style="font-weight: 600; color: #2e602e;">{{mail_site_title}}</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
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
            var formData = $("#mail_setting_form").serialize();
            var testTo = $("input[name='testTo']").val();
            $.post("setting.php?action=mail_test", formData + "&testTo=" + testTo, function(data) {
                if (data === '') {
                    $("#testMailMsg").html("<small class='text-success'>发送成功</small>");
                } else {
                    $("#testMailMsg").html(data);
                }

            });
        })
    });
</script>