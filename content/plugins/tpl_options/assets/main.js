$(function () {
    //初始化变量
    var tplOptions = window.tplOptions;
    var body = $('body');
    var iframe = $('<iframe name="upload-image" src="about:blank" style="display:none"/>').appendTo(body);
    var optionArea = $('<div/>').insertAfter($('#content').find('.container-fluid .row')).addClass(attr('area')).slideUp();
    var loadingDom = $('<div />').appendTo(body);
    var message = $('<span />').appendTo($('#wrapper'));
    var goTopbtn = $('<span />').appendTo($('#wrapper')).attr({'id': 'goTopbtn', 'title': '返回顶部'});
    var tplBox = $('.tpl');
    var timer, input, targetInput, target, templateInput, template;
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
    var form = $('<form id="upload-form" target="upload-image" />').append(trueInput, targetInput = $('<input type="hidden" name="target">'), templateInput = $('<input type="hidden" name="template">')).appendTo(body).attr({
        action: tplOptions.uploadUrl, target: 'upload-image', enctype: 'multipart/form-data', method: 'post'
    });
    //插入设置按钮
    for (var tpl of Object.keys(tplOptions.templates)) {
        var now = document.querySelector('a[href*="em_confirm(\'' + tpl + '\',"]');
        var xps = document.createElement('a');
        xps.style.fontSize = '12px';
        xps.style.marginLeft = '4px';
        now.parentNode.appendChild(xps);
        $('<a class="btn btn-primary btn-sm">设置</span>').insertBefore(xps).addClass(attr('setting')).data('template', tpl);
    }
    //绑定事件
    body.on('click', '.' + attr('setting'), function () {
        $('.container-fluid .row').fadeToggle();
        $.ajax({
            url: tplOptions.baseUrl, data: {
                template: $(this).data('template')
            }, cache: false, beforeSend: function () {
                loading();
                editorMap = {};
            }, success: function (data) {
                optionArea.html(data).show(), tplBox.hide();
                window.setTimeout(function () {
                    initOptionSort();
                    initRichText();
                    setTimeout(function () {
                        loading(false);
                    }, 0);
                }, 1000);
            }
        });
    }).on('click', '.tpl-options-menu ul li', function () {
        $('.tpl-options-menu ul li').removeClass('active');
        $(this).addClass('active');
    }).on('click', '.tpl-options-close', function () {
        $('.container-fluid .row').fadeToggle();
        optionArea.slideUp(500), tplBox.show();
    }).on('click', '#goTopbtn', function () {
        $('body,html').animate({scrollTop: 0}, 500);
    }).on('click', '.option-name', function () {
        $(this).find('.option-description').fadeToggle();
        $(this).parent().find('.option-body').fadeToggle();
        if ($(this).parent().find('.option-ico').hasClass('upico')) {
            $(this).parent().find('.option-ico').removeClass('upico').addClass('downico');
        } else {
            $(this).parent().find('.option-ico').removeClass('downico').addClass('upico');
        }

    }).on('click', '.tpl-options-menu li', function () {
        //$('html,body').animate({scrollTop:$('#'+$(this).attr('data-id')).offset().top-80}, 500);
    }).on('click', '.tpl-options-menubtn', function () {
        $('.tpl-options-menu').fadeToggle();
    }).on('click', '.tpl-options-btns', function () {
        if ($(this).attr('data-type') == 1) {
            $(this).text('全部展开').attr('data-type', 0);
            $('.option-body').fadeOut();
            $('.option-description').fadeOut();
            $('.option-ico').removeClass('upico').addClass('downico');
        } else {
            $(this).text('全部收缩').attr('data-type', 1);
            $('.option-body').fadeIn();
            $('.option-description').fadeIn();
            $('.option-ico').removeClass('downico').addClass('upico');
        }
    }).on('click', '.option-sort-name', function () {
        var that = $(this);
        if (that.is('.selected')) {
            return;
        }
        var left = that.parent(), right = left.siblings('.option-sort-right');
        left.find('.selected').removeClass('selected');
        that.addClass('selected');
        right.find('.option-sort-option').removeClass('selected').eq(that.index()).addClass('selected');
    }).on('change', '.option-sort-select', function () {
        var that = $(this);
        var right = that.parent().siblings('.option-sort-right');
        right.find('.option-sort-option').removeClass('selected').eq(that.find('option:selected').index()).addClass('selected');
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
                showMsg(data.code, data.msg);
            }, error: function () {
                showMsg(1, '网络异常');
            }, complete: function () {
                // loading(false);
            }
        });
        return false;
    }).on('change', '.tpl-options-form input, .tpl-options-form textarea', function () {
        $('form.tpl-options-form').trigger('submit');
    });
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
            alert('上传失败：' + msg)
        }
        trueInput.val('');
        target = '';
        loading(false);
    };

    function initOptionSort() {
        $('.option-sort-left').each(function () {
            $(this).find('.option-sort-name:first').addClass('selected');
        });
        $('.option-sort-right').each(function () {
            $(this).find('.option-sort-option:first').addClass('selected');
        });
    }

    function loading(enable) {
        if (enable === undefined) {
            enable = true;
        }
        if (enable) {
            loadingDom.addClass('loading');
        } else {
            loadingDom.removeClass('loading');
        }
    }

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
$(window).scroll(function () {
    if ($(this).scrollTop() > 50) {
        $('#goTopbtn').fadeIn();
    } else {
        $('#goTopbtn').fadeOut();
    }
});

function TplShow(a) {
    $('.option').hide();
    $('.' + a).fadeIn();
}