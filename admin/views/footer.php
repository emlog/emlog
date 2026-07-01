<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
</div>
</div>
<a class="scroll-to-top" href="#page-top">
    <i class="icofont-rounded-up"></i>
</a>
<footer class="sticky-footer bg-white">
    <div class="text-right my-auto mr-4">
        <small><a href="https://www.emlog.net" target="_blank">EMLOG</a> - <?= ucfirst(Option::EMLOG_VERSION) ?></small>
    </div>
</footer>
<!-- AI Chat Modal -->
<link rel="stylesheet" href="./views/css/markdown.css?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>">
<script src="./editor.md/lib/marked.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
<div class="modal fade" id="aiChatModal" tabindex="-1" role="dialog" aria-labelledby="aiChatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-2">
                <h5 class="modal-title" id="aiChatModalLabel"><?= _lang('ai_chat') ?></h5>
                <button type="button" class="btn btn-xs btn-outline-danger ml-auto mr-3" id="clear-chat-btn" title="<?= _lang('clear_history_title') ?>" style="font-size: 11px; padding: 1px 5px;">
                    <?= _lang('clear_history') ?>
                </button>
                <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div id="chat-box" style="height: 500px; overflow-y: scroll; border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; border-radius: 8px;">
                    <!-- Chat messages will appear here -->
                </div>
                <form id="chat-form">
                    <div class="input-group">
                        <textarea class="form-control" id="chat-input" placeholder="<?= _lang('input_message') ?>" rows="1" style="resize: none; overflow: hidden;"></textarea>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit" id="send-btn"><?= _lang('send') ?></button>
                        </div>
                    </div>
                    <div class="mt-2 d-flex justify-content-between align-items-center flex-wrap" style="gap: 5px;">
                        <button type="button" class="btn btn-xs btn-outline-info" id="btn-em-help" style="font-size: 11px; padding: 2px 6px;"><i class="icofont-search-document"></i> @em-help <?= _lang('ai_em_help_btn') ?></button>
                        <div class="text-muted text-xs">
                            <?= _lang('model_label') ?><?php if (AI::model()): ?><a href="./setting.php?action=ai" class="text-primary font-weight-bold"><?= AI::model() ?></a><?php else: ?><a href="./setting.php?action=ai" class="text-danger font-weight-bold"><?= _lang('no_ai_model') ?></a><?php endif; ?>
                        </div>
                    </div>
                </form>
                <script>
                    $(document).ready(function() {
                        AIChat.init();
                    });
                </script>
            </div>
        </div>
    </div>
</div>
<!-- Shortcut Modal -->
<div class="modal fade" id="shortcutModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="shortcutModalLabel"><?= _lang('shortcut') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="index.php?action=add_shortcut" method="post">
                <div class="modal-body" id="shortcutModalBody">
                    <p class="text-center"><?= _lang('loading') ?></p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?= _lang('cancel') ?></button>
                    <button type="submit" class="btn btn-sm btn-success"><?= _lang('save') ?></button>
                </div>
            </form>

        </div>
    </div>
</div>
</div>
</div>
<?php doAction('adm_footer') ?>
<script src="./views/js/sb-admin-2.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
<script src="./views/js/ai-chat.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
<script>
    $(function() {
        // Scroll to top button appear
        $(document).on('scroll', function() {
            var scrollDistance = $(this).scrollTop();
            if (scrollDistance > 100) {
                $('.scroll-to-top').fadeIn();
            } else {
                $('.scroll-to-top').fadeOut();
            }
        });
        // Smooth scrolling using jQuery easing
        $(document).on('click', 'a.scroll-to-top', function(e) {
            var $anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: ($($anchor.attr('href')).offset().top)
            }, 1000, 'easeInOutExpo');
            e.preventDefault();
        });

        // 时间选择控件
        $.timepicker.regional['zh-CN'] = {
            timeOnlyTitle: '<?= _lang('select_time') ?>',
            timeText: '<?= _lang('time') ?>',
            hourText: '<?= _lang('hour') ?>',
            minuteText: '<?= _lang('minute') ?>',
            secondText: '<?= _lang('second') ?>',
            millisecText: '<?= _lang('millisecond') ?>',
            microsecText: '<?= _lang('microsecond') ?>',
            timezoneText: '<?= _lang('timezone') ?>',
            currentText: '<?= _lang('current_time') ?>',
            closeText: '<?= _lang('close') ?>',
            timeFormat: 'HH:mm',
            timeSuffix: '',
            amNames: ['AM', 'A'],
            pmNames: ['PM', 'P'],
            isRTL: false,
            prevText: '<?= _lang('prev_month') ?>',
            nextText: '<?= _lang('next_month') ?>',
            showMonthAfterYear: true,
            weekHeader: '<?= _lang('week') ?>',
            yearSuffix: '<?= _lang('year') ?>',
        };
        $.timepicker.setDefaults($.timepicker.regional['zh-CN']);
        let dayNamesMin = <?= json_encode(_lang('day_names_min')) ?>;
        let monthNamesShort = <?= json_encode(_lang('month_names_short')) ?>;
        const screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
        let _left = screenWidth < 1200 ? 0 : 50;
        $(".datepicker").length && $(".datepicker").datetimepicker({
            controlType: "select",
            dayNamesMin: dayNamesMin,
            monthNamesShort: monthNamesShort,
            changeMonth: true,
            changeYear: true,
            yearRange: "c-30:c+10",
            showSecond: true,
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss",
            beforeShow: function(input, inst) {
                setTimeout(function() {
                    inst.dpDiv.css({
                        top: $(".datepicker.active").offset().top + 50,
                        left: $(".datepicker.active").offset().left - _left
                    });
                }, 0);
            },
            onClose: function(dateText, inst) {
                typeof onDatepickerClose === "function" && onDatepickerClose(dateText, inst);
            }
        });
        $('body').on('focus', '.datepicker', function() {
            let _this = $(this)
            $('.datepicker').removeClass('active')
            _this.addClass('active')
        })



        // Initialize shortcut bar hover effect
        initShortcutBar();
        $('#shortcutModal').on('show.bs.modal', function(event) {
            const modalBody = $('#shortcutModalBody');
            modalBody.html('<p class="text-center"><?= _lang('loading') ?></p>');
            const currentShortcuts = <?php echo json_encode($shortcuts); ?>;
            $.ajax({
                url: 'index.php?action=get_all_shortcuts',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (!response.code && response.data) {
                        modalBody.empty();
                        if (!response.data.length) {
                            modalBody.html('<p class="text-center"><?= _lang('no_shortcuts') ?></p>');
                            return;
                        }
                        response.data.forEach((item, index) => {
                            const isChecked = currentShortcuts.some(s =>
                                s.name === item.name && s.url === item.url
                            );
                            var $div = $('<div class="custom-control custom-checkbox custom-control-inline mb-2 mr-3"></div>');
                            var $checkbox = $('<input>', {
                                type: 'checkbox',
                                name: 'shortcut[]',
                                id: 'shortcut-' + index,
                                value: item.name + '||' + item.url,
                                checked: isChecked,
                                class: 'custom-control-input'
                            });
                            var $label = $('<label>', {
                                for: 'shortcut-' + index,
                                class: 'custom-control-label',
                                style: 'cursor: pointer;',
                                text: item.name
                            });
                            $div.append($checkbox, $label);
                            modalBody.append($div);
                        });
                    } else {
                        modalBody.html('<?= _lang('load_failed') ?>' + (response.msg || '<?= _lang('unknown_error') ?>'));
                    }
                },
                error: (_, __, error) => modalBody.html('<?= _lang('load_failed') ?>' + error)
            });
        });
    });
</script>
</body>

</html>