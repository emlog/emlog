$(function () {
    //初始化变量
    var tplOptions = window.tplOptions;
    var body = $('body');
    var iframe = $('<iframe name="upload-image" src="about:blank" style="display:none"/>').appendTo(body);
    var optionArea = $('<div/>').addClass(attr('area')).hide();
    mountOptionArea();
    var loadingDom = $('<div class="tpl-loading" />').appendTo(body);
    var message = $('<span />').appendTo($('#wrapper'));
    var tplBox = $('.tpl');
    var timer, input, targetInput, target, templateInput, template, mediaTargetWrap = null;
    var optionCache = {};
    var preloadState = {};
    var requestXhr = null;
    var loadingTimer = null;
    var trueInput = $('<input type="file" name="image">').css({
        position: 'absolute', margin: 0, visibility: 'hidden'
    }).on('change', function () {
        loading();
        target = input.data('target');
        targetInput.val(target);
        templateInput.val(template);
        form.submit();
    }).on('mouseleave', function () {
        trueInput.css('visibility', 'hidden');
        input.css('visibility', 'visible');
    });
    var form = $('<form id="upload-form" target="upload-image" />').append(trueInput, targetInput = $('<input type="hidden" name="target">'), templateInput = $('<input type="hidden" name="template">')).prependTo(body).attr({
        action: tplOptions.uploadUrl, target: 'upload-image', enctype: 'multipart/form-data', method: 'post'
    });
    //插入设置按钮
    for (var tpl of Object.keys(tplOptions.templates)) {
        var templateCards = document.querySelectorAll('.card[data-app-alias]');
        templateCards.forEach(function(card) {
            if (card.getAttribute('data-app-alias') === tpl) {
                var settingBtnContainer = card.querySelector('.setting-btn');
                if (settingBtnContainer) {
                    $('<a class="btn btn-outline-primary btn-sm"><i class="icofont-options"></i>' + tplOptions.lang.setting + '</a>')
                        .appendTo(settingBtnContainer)
                        .addClass(attr('setting'))
                        .attr('data-template', tpl);
                }
            }
        });
    }
    var firstSettingBtn = $('.' + attr('setting')).first();
    if (firstSettingBtn.length) {
        preloadTemplate(firstSettingBtn.data('template'));
    }

    // 拦截侧边栏菜单点击，实现无刷新切换
    $(document).on('click', 'a[href="template.php?setting=1"]', function(e) {
        if (window.location.pathname.endsWith('template.php')) {
            e.preventDefault();
            var activeSettingBtn = getCurrentTemplateSettingBtn();
            if (activeSettingBtn.length && !optionArea.is(':visible')) {
                activeSettingBtn.trigger('click');
            } else if (optionArea.is(':visible') && window.location.search.indexOf('setting=1') === -1) {
                window.history.pushState({}, '', 'template.php?setting=1');
            } else if (!activeSettingBtn.length && !isCurrentTemplateSupported()) {
                cocoMessage.error(tplOptions.lang.not_support, 2500);
            }
        }
    });

    $(document).on('click', 'a[href="template.php"]', function(e) {
        if (window.location.pathname.endsWith('template.php') && optionArea.is(':visible')) {
            e.preventDefault();
            $('.tpl-options-close').trigger('click');
        }
    });

    // 监听浏览器后退/前进按钮
    window.addEventListener('popstate', function(e) {
        var params = new URLSearchParams(window.location.search);
        if (params.get('setting') === '1') {
            if (!optionArea.is(':visible')) {
                var activeSettingBtn = getCurrentTemplateSettingBtn();
                if (activeSettingBtn.length) {
                    activeSettingBtn.trigger('click');
                } else if (!isCurrentTemplateSupported()) {
                    cocoMessage.error(tplOptions.lang.not_support, 2500);
                }
            }
        } else {
            if (optionArea.is(':visible')) {
                // 模拟点击关闭，但不触发 pushState
                document.getElementsByClassName("container-fluid")[0].children[0].style.cssText = 'display:flex !important';
                showTemplateList();
                optionArea.slideUp(500), tplBox.show();
            }
        }
    });

    //绑定事件
    body.on('click', '.' + attr('setting'), function () {
        var selectedTemplate = $(this).data('template') || $(this).attr('data-template') || tplOptions.currentTemplate;
        if (!selectedTemplate) {
            cocoMessage.error(tplOptions.lang.not_support, 2500);
            showTemplateList();
            return;
        }
        // 更新URL状态
        if (window.location.search.indexOf('setting=1') === -1) {
            window.history.pushState({}, '', 'template.php?setting=1');
        }
        if (optionCache[selectedTemplate] && isOptionMarkup(optionCache[selectedTemplate])) {
            hideTemplateList();
            renderOptionArea(optionCache[selectedTemplate]);
            return;
        }
        delete optionCache[selectedTemplate];
        if (requestXhr && requestXhr.readyState !== 4) {
            requestXhr.abort();
        }
        requestXhr = $.ajax({
            url: tplOptions.baseUrl, data: {
                template: selectedTemplate
            }, cache: false, beforeSend: function () {
                showLoadingWithDelay();
                editorMap = {};
            }, success: function (data) {
                if (isErrorResponse(data)) {
                    cocoMessage.error(readErrorMessage(data), 2500);
                    showTemplateList();
                    return;
                }
                if (!isOptionMarkup(data)) {
                    cocoMessage.error(tplOptions.lang.network_error, 2500);
                    showTemplateList();
                    return;
                }
                optionCache[selectedTemplate] = data;
                hideTemplateList();
                renderOptionArea(data);
            }, error: function (xhr, status) {
                if (status !== 'abort') {
                    cocoMessage.error(tplOptions.lang.network_error, 2500);
                    showTemplateList();
                }
            }, complete: function () {
                hideLoading();
                requestXhr = null;
            }
        });
    }).on('click', '.tpl-options-menu ul li,.tpl-nav-options ul li', function () {
        $('.tpl-options-menu ul li').removeClass('active');
        $('.tpl-nav-options ul li').removeClass('active');
        $(this).addClass('active');
    }).on('click', '.tpl-options-close', function () {
        document.getElementsByClassName("container-fluid")[0].children[0].style.cssText = 'display:flex !important';
        showTemplateList();
        optionArea.slideUp(500), tplBox.show();
        // 更新URL状态
        if (window.location.search.indexOf('setting=1') !== -1) {
            window.history.pushState({}, '', 'template.php');
        }
    }).on('click', '.tpl-options-menu li', function () {
        //$('html,body').animate({scrollTop:$('#'+$(this).attr('data-id')).offset().top-80}, 500);
    }).on('click', '.vtpl-menu,.vtpl-nav.show ul li,.fixed-body', function () {
        $('.vtpl-nav').toggleClass('show')
    }).on('click', '.tpl-options-menubtn', function () {
        $('.tpl-options-menu').fadeToggle();
    }).on('click', '.option-sort-tag-name', function () {
        var that = $(this);
        if (that.is('.selected')) {
            return;
        }
        var left = that.parent(), right = left.siblings('.option-sort-tag-right');
        left.find('.selected').removeClass('selected');
        that.addClass('selected');
        right.find('.option-sort-tag-option').removeClass('selected').eq(that.index()).addClass('selected');
    }).on('change', '.option-sort-tag-select', function () {
        var that = $(this);
        var right = that.parent().siblings('.option-sort-tag-right');
        right.find('.option-sort-tag-option').removeClass('selected').eq(that.find('option:selected').index()).addClass('selected');
    }).on('input propertychange paste change focus', '.chosen-search-input', function () {
        _this_val = $(this).val().replace(/(^\s*)|(\s*$)/g, "");
        let _this_data_opt = $(this).attr('data-opt')
        let _drop_item = $(this).parent().parent().next()
        let _drop_item_child = $(this).parent().parent().next().find('.chosen-results')
        if (_this_val === '') {
            _drop_item.css('clip', 'rect(0, 0, 0, 0)')
            _drop_item.css('clip-path', 'inset(100% 100%)')
            _drop_item.css('position', 'absolute')
            return
        }
        _drop_item.css('clip', 'auto')
        _drop_item.css('clip-path', 'none')
        _drop_item.css('position', 'relative')
        var formData = new FormData()
        formData.append("action", 'tpl_select_search')
        formData.append("kywd", $(this).val())
        formData.append("name", $(this).attr('data-s-name'))
        formData.append("type", _this_data_opt)
        $.ajax({
            url: $(this).attr('data-url') + 'content/plugins/tpl_options/actions/search.php',
            type: 'post',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function (data) {
                _drop_item_child.html(data)
            },
            error: function (data) {
                _drop_item_child.html(data)
            }
        });
    }).on('click', '.chosen-results .active-result', function () {
        let title = $(this).html()
        let name = $(this).attr('data-s-name')
        let gid = $(this).attr('data-id')
        let _search_filed = $(this).parent().parent().prev().find('.search-field')
        let _input_item = $(this).parent().parent().prev().find('.search-field').find('.chosen-search-input')
        let _drop_item = $(this).parent().parent()
        _search_filed.before('<li class="search-choice"><span>' + title + '</span><a class="search-choice-close"><i class="icofont-close"></i></a><input class="d-none" name="' + name + '[]" type="text" value="' + gid + '"></li>');
        _drop_item.css('clip', '')
        _drop_item.css('clip-path', '')
        _input_item.val('')
        _input_item.focus()
        $('form.tpl-options-form').trigger('submit');
    }).on('click', '.search-choice-close i', function () {
        $(this).parent().parent().remove()
        $('form.tpl-options-form').trigger('submit');
    }).on('click', '.tpl-block-title', function () {
        $(this).next().toggleClass('d-none')
        $(this).find('span').toggleClass('icofont-rounded-right')
        $(this).find('span').toggleClass('icofont-rounded-down')
    }).on('click', '.tpl-add-block', function () {
        let _name = $(this).attr('data-b-name')
        let _type = $(this).attr('data-type')
        let _url = $(this).attr('data-url')
        let type_html = ''
        if (_type === 'image') {
            type_html = '<div class="tpl-block-upload"><span>' + tplOptions.lang.title + '</span>' +
                '<input class="block-title-input" type="text" name="' + _name + '[title][]" value="">' +
                '<div class="tpl-image-preview"><img src=""></div><div class="tpl-block-upload-input">' +
                '<input type="text" name="' + _name + '[content][]" value="">' +
                '<a class="btn btn-outline-primary tpl-select-media" href="#mediaModal" data-toggle="modal" data-target="#mediaModal" data-mode="custom" data-media-type="image" data-btn-text="' + tplOptions.lang.choose_media + '" data-callback="tplOptionsUseMediaImage">' + tplOptions.lang.choose_media + '</a><label>\n' +
                '<a class="btn btn-primary">' + tplOptions.lang.upload + '</a>\n' +
                '<input class="d-none tpl-image" type="file" name="image" data-url="' + _url + '" accept="image/svg+xml,image/webp,image/avif,image/jpeg,image/jpg,image/png,image/gif">\n' +
                '</label>'
            type_html += '</div></div>';
        } else {
            type_html += '<div>' + tplOptions.lang.title + '</div>'
            type_html += '<input class="block-title-input" type="text" name="' + _name + '[title][]" value="">'
            type_html += '<div>' + tplOptions.lang.content + '</div>'
            if ($(this).parent().parent().hasClass('is-multi')) {
                type_html += '<textarea rows="5" name="' + _name + '[content][]"></textarea>'
            } else {
                type_html += '<input type="text" name="' + _name + '[content][]" value="">'
            }
        }
        $(this).before('<div class="tpl-block-item">\n' +
            '    <div class="tpl-block-head">\n' +
            '    <i class="tpl-block-clone icofont-ui-copy"></i>\n' +
            '    <i class="tpl-block-remove icofont-close icofont-md"></i>\n' +
            '    </div>\n' +
            '    <h4 class="tpl-block-title">\n' +
            '    <span class="tpl-block-title-icon icofont-rounded-right"></span>\n' +
            '    <item class="block-title-text"></item>' +
            '    </h4>\n' +
            '    <div class="tpl-block-content d-none">\n' +
            type_html +
            '    </div>\n' +
            '</div>')
        $('form.tpl-options-form').trigger('submit');
    }).on('change', '.tpl-image', function () {
        let obj = this;
        let file = $(this).prop('files')[0];
        let _url = $(this).attr('data-url')
        let _target_input = $(this).parent().parent().find('input[type="text"]')
        let _target_img = $(this).parent().parent().prev().find('img')
        let formData = new FormData();
        if (file === undefined || file === null) return
        formData.append("action", 'tpl_upload')
        formData.append("image", file)
        formData.append("origin_image", _target_input.val())
        $.ajax({
            url: _url + 'content/plugins/tpl_options/actions/tpl.php',
            type: 'post',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function (data) {
                let j_data = JSON.parse(data)
                if (j_data.code === 'success') {
                    _target_input.val(j_data.data)
                    _target_img.attr('src', j_data.data + '?' + new Date().getTime())
                    obj.value = ''
                    $('form.tpl-options-form').trigger('submit');
                } else {
                    cocoMessage.error(j_data.data, 2500);
                }
            },
            error: function (data) {
                cocoMessage.error('网络异常', 2500);
            }

        });

    }).on('click', '.tpl-select-media', function () {
        mediaTargetWrap = $(this).closest('.tpl-block-upload-input');
    }).on('click', '.tpl-block-remove', function () {
        if (confirm('真的要删除吗？')) {
            $(this).parent().parent().remove()
            $('form.tpl-options-form').trigger('submit');
        }
    }).on('click', '.tpl-block-clone', function () {
        let _this_clone = $(this).parent().parent().clone()
        $(this).parent().parent().after(_this_clone)
        $('form.tpl-options-form').trigger('submit');
    }).on('input change focus', '.block-title-input', function () {
        let _tar = $(this).parent().prev().find('item')
        if ($(this).parent().hasClass('tpl-block-upload')) {
            _tar = $(this).parent().parent().prev().find('item')
        }
        _tar.html($(this).val())
    }).on('click', '.vtpl-switch-item input[type="checkbox"]', function () {
        if ($(this).is(":checked")) {
            $(this).parent().parent().addClass('vtpl-checked')
        } else {
            $(this).parent().parent().removeClass('vtpl-checked')
        }
    }).on('mouseenter', '.tpl-options-form input[type="file"]', function () {
        input = $(this);
        trueInput.css(input.offset());
        input.css('visibility', 'hidden');
        trueInput.css('visibility', 'visible');
    }).on('submit', 'form.tpl-options-form', function () {
        var that = $(this);
        $.ajax({
            url: that.attr('action'), type: 'post', data: that.serialize(), cache: false, dataType: 'json', // beforeSend: loading,
            success: function (data) {
                if (data.code === 1) {
                    cocoMessage.error(data.msg, 2500);
                    return false;
                }
                cocoMessage.success(data.msg, 2500);
            }, error: function () {
                cocoMessage.error(tplOptions.lang.network_error, 2500);
            }, complete: function () {
                // loading(false);
            }
        });
        return false;
    }).on('change', '.tpl-options-form input:not(.chosen-search-input,.tpl-image), .tpl-options-form textarea', function () {
        $('form.tpl-options-form').trigger('submit');
    });

    if (+tplOptions.autoOpenSetting === 1) {
        tryAutoOpenCurrentSetting(60);
    }

    //定义方法
    var initRichText = (function () {
        var num = 0;
        return function () {
            $('.option-rich-text').each(function () {
                var that = $(this);
                if (that.attr('id') === undefined) {
                    that.attr('id', 'option-rich-text-' + (num++));
                }
                //loadEditor(that.attr('id'));
            });
            window.setTimeout(function () {
                for (var id in editorMap) {
                    editorMap[id].container[0].style.width = '';
                }
            }, 100);
        }
    })();
    window.setImage = function (src, path, code, msg) {
        if (code == 0) {
            $('[name="' + target + '"]').val(path).trigger('change');
            $('[data-name="' + target + '"]').attr('href', src).find('img').attr('src', src);
        } else {
            alert(tplOptions.lang.upload_failed + msg)
        }
        trueInput.val('');
        target = '';
        loading(false);
    };
    window.tplOptionsUseMediaImage = function (url) {
        if (!mediaTargetWrap || !mediaTargetWrap.length) {
            return;
        }
        var targetInput = mediaTargetWrap.find('input[type="text"]').first();
        var targetImg = mediaTargetWrap.prev('.tpl-image-preview').find('img');
        targetInput.val(url);
        targetImg.attr('src', url + '?' + new Date().getTime());
        $('#mediaModal').modal('hide');
        $('form.tpl-options-form').trigger('submit');
        mediaTargetWrap = null;
    };

    function initOptionSort() {
        $('.option-sort-tag-left').each(function () {
            $(this).find('.option-sort-tag-name:first').addClass('selected');
        });
        $('.option-sort-tag-right').each(function () {
            $(this).find('.option-sort-tag-option:first').addClass('selected');
        });
    }

    function loading(enable) {
        if (enable === undefined) {
            enable = true;
        }
        if (enable) {
            loadingDom.addClass('loading').show();
        } else {
            loadingDom.removeClass('loading').hide();
        }
    }

    function showLoadingWithDelay() {
        hideLoading();
        loadingTimer = window.setTimeout(function () {
            loading(true);
        }, 120);
    }

    function hideLoading() {
        if (loadingTimer) {
            window.clearTimeout(loadingTimer);
            loadingTimer = null;
        }
        loading(false);
    }

    function renderOptionArea(data) {
        mountOptionArea();
        optionArea.html(data).show();
        tplBox.hide();
        initOptionSort();
        initRichText();
    }

    function mountOptionArea() {
        if (optionArea.parent().length) {
            return;
        }
        var listRow = $('.container-fluid .row.app-list').first();
        if (listRow.length) {
            optionArea.insertAfter(listRow);
            return;
        }
        var anyRow = $('#content').find('.container-fluid .row').first();
        if (anyRow.length) {
            optionArea.insertAfter(anyRow);
            return;
        }
        var contentContainer = $('#content').find('.container-fluid').first();
        if (contentContainer.length) {
            optionArea.appendTo(contentContainer);
        } else {
            optionArea.appendTo(body);
        }
    }

    function hideTemplateList() {
        $('.container-fluid .row.app-list').fadeOut(120);
    }

    function showTemplateList() {
        $('.container-fluid .row.app-list').fadeIn(120);
    }

    function isOptionMarkup(data) {
        return String(data).indexOf('tpl-options-form') !== -1;
    }

    function parseErrorData(data) {
        if (typeof data === 'object' && data && data.code === 1) {
            return data;
        }
        if (typeof data !== 'string') {
            return null;
        }
        var trimData = $.trim(data);
        if (trimData.indexOf('{') !== 0) {
            return null;
        }
        try {
            var parsed = JSON.parse(trimData);
            if (parsed && parsed.code === 1) {
                return parsed;
            }
        } catch (e) {}
        return null;
    }

    function isErrorResponse(data) {
        return !!parseErrorData(data);
    }

    function readErrorMessage(data) {
        var parsed = parseErrorData(data);
        return parsed && parsed.msg ? parsed.msg : tplOptions.lang.network_error;
    }

    function preloadTemplate(templateName) {
        if (!templateName || preloadState[templateName]) {
            return;
        }
        preloadState[templateName] = true;
        $.ajax({
            url: tplOptions.baseUrl,
            data: {template: templateName},
            cache: false,
            success: function (data) {
                if (!isErrorResponse(data) && isOptionMarkup(data)) {
                    optionCache[templateName] = data;
                }
            }
        });
    }

    function getCurrentTemplateSettingBtn() {
        if (!tplOptions.currentTemplate) {
            return $();
        }
        return $('.' + attr('setting') + '[data-template="' + tplOptions.currentTemplate + '"]');
    }

    function isCurrentTemplateSupported() {
        if (!tplOptions.currentTemplate || !tplOptions.templates) {
            return false;
        }
        return Object.prototype.hasOwnProperty.call(tplOptions.templates, tplOptions.currentTemplate);
    }

    function tryAutoOpenCurrentSetting(retry) {
        var activeSettingBtn = getCurrentTemplateSettingBtn();
        if (activeSettingBtn.length) {
            activeSettingBtn.trigger('click');
            return;
        }
        if (retry <= 0) {
            if (!isCurrentTemplateSupported()) {
                cocoMessage.error(tplOptions.lang.not_support, 2500);
            }
            return;
        }
        window.setTimeout(function () {
            tryAutoOpenCurrentSetting(retry - 1);
        }, 80);
    }
    
    // 将loading函数暴露到全局作用域
    window.loading = loading;

    function showMsg(code, msg) {
        message.text(msg).show();
        if (code == 0) {
            message.attr('class', 'tpl-activebox');
            if (timer) {
                window.clearTimeout(timer);
            }
            timer = window.setTimeout(function () {
                message.hide();
            }, 2600);
        } else {
            message.attr('class', 'tpl-errorbox');
        }
    }

    function attr(name) {
        return tplOptions.prefix + name;
    }

    function loadEditor(id) {
        editorMap[id] = editorMap[id] || KindEditor.create('#' + id, {
            resizeMode: 1,
            allowUpload: false,
            allowImageUpload: false,
            allowFlashUpload: false,
            allowPreviewEmoticons: false,
            filterMode: false,
            afterChange: (function () {
                var t, i = 0;
                return function () {
                    var that = this;
                    if (t) {
                        window.clearTimeout(t);
                    }
                    if (i++ > 0) {
                        t = window.setTimeout(function () {
                            that.sync();
                            $(that.srcElement[0]).trigger('change');
                        }, 2000);
                    }
                }
            })(),
            urlType: 'domain',
            items: ['bold', 'italic', 'underline', 'strikethrough', 'forecolor', 'hilitecolor', 'fontname', 'fontsize', 'lineheight', 'removeformat', 'plainpaste', 'quickformat', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'justifyleft', 'justifycenter', 'justifyright', 'link', 'unlink', 'image', 'flash', 'table', 'emoticons', 'code', 'fullscreen', 'source']
        });
    }
});

function TplShow(a) {
    $('.option').hide();
    $('.' + a).fadeIn();
}

function block_drag_end() {
    $('form.tpl-options-form').trigger('submit');
}
