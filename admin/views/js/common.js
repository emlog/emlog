function getChecked(node) {
    let re = false;
    $('input.' + node).each(function (i) {
        if (this.checked) {
            re = true;
        }
    });
    return re;
}

function timestamp() {
    return new Date().getTime();
}

function em_confirm(id, property, token, extraQuery) {
    let url;
    let msg = '';
    let text = ''
    extraQuery = extraQuery || '';
    switch (property) {
        case 'article':
            url = 'article.php?action=del&gid=' + id;
            text = _langJS.delete_article;
            delArticle(msg, text, url, token)
            break;
        case 'draft':
            url = 'article.php?action=del&draft=1&gid=' + id;
            text = _langJS.delete_draft;
            delAlert(msg, text, url, token, _langJS.delete, property)
            break;
        case 'tw':
            url = 'twitter.php?action=del&id=' + id;
            text = _langJS.delete_twitter;
            delAlert(msg, text, url, token)
            break;
        case 'comment':
            url = 'comment.php?action=del&id=' + id;
            text = _langJS.delete_comment;
            delAlert(msg, text, url, token)
            break;
        case 'commentbyip':
            url = 'comment.php?action=delbyip&ip=' + id;
            text = _langJS.delete_comment_by_ip;
            delAlert(msg, text, url, token)
            break;
        case 'link':
            url = 'link.php?action=del&linkid=' + id;
            text = _langJS.delete_link;
            delAlert(msg, text, url, token)
            break;
        case 'navi':
            url = 'navbar.php?action=del&id=' + id;
            text = _langJS.delete_navi;
            delAlert(msg, text, url, token)
            break;
        case 'page':
            url = 'page.php?action=del&id=' + id;
            text = _langJS.delete_page;
            delAlert(msg, text, url, token)
            break;
        case 'media':
            url = 'media.php?action=delete&aid=' + id;
            if (extraQuery) {
                if (extraQuery[0] === '&' || extraQuery[0] === '?') {
                    url += extraQuery;
                } else {
                    url += '&' + extraQuery;
                }
            }
            text = _langJS.delete_media;
            delAlert(msg, text, url, token)
            break;
        case 'avatar':
            url = 'blogger.php?action=delicon';
            text = _langJS.delete_avatar;
            delAlert(msg, text, url, token)
            break;
        case 'sort':
            url = 'sort.php?action=del&sid=' + id;
            text = _langJS.delete_sort;
            delAlert(msg, text, url, token)
            break;
        case 'del_user':
            url = 'user.php?action=del&uid=' + id;
            text = _langJS.delete_user;
            delAlert(msg, text, url, token)
            break;
        case 'forbid_user':
            url = 'user.php?action=forbid&uid=' + id;
            text = _langJS.forbid_user;
            delAlert(msg, text, url, token, _langJS.forbid)
            break;
        case 'tpl':
            url = 'template.php?action=del&tpl=' + id;
            text = _langJS.delete_tpl;
            delAlert(msg, text, url, token)
            break;
        case 'reset_widget':
            url = 'widgets.php?action=reset';
            text = _langJS.reset_widget;
            delAlert(msg, text, url, token, _langJS.reset)
            break;
        case 'plu':
            url = 'plugin.php?action=del&plugin=' + id;
            text = _langJS.delete_plugin;
            delAlert(msg, text, url, token)
            break;
        case 'inactive_all_plugins':
            url = 'plugin.php?action=inactive_all';
            text = _langJS.close_all_plugins_confirm;
            delAlert(msg, text, url, token, _langJS.close)
            break;
        case 'media_sort':
            url = 'media.php?action=del_media_sort&id=' + id;
            text = _langJS.delete_media_sort;
            delAlert(msg, text, url, token)
            break;
        case 'ai_model':
            url = 'setting.php?action=delete_model&ai_model_key=' + id;
            text = _langJS.delete_ai_model;
            delAlert(msg, text, url, token)
            break;
    }
}

function infoAlert(msg) {
    layer.alert(msg, {
        icon: 2,
        shadeClose: true,
        title: '',
    });
}

function delAlert(msg, text, url, token, btnText) {
    btnText = btnText || _langJS.delete;
    // icon: 0 default, 1 ok, 2 err, 3 ask
    layer.confirm(text, {icon: 3, title: msg, skin: 'class-layer-danger', btn: [btnText, _langJS.cancel]}, function (index) {
        localStorage.setItem('alert_action_success', btnText);
        window.location = url + '&token=' + token;
        layer.close(index);
    });
}

function delAlert2(msg, text, actionClosure, btnText) {
    btnText = btnText || _langJS.delete;
    layer.confirm(text, {icon: 3, title: msg, skin: 'class-layer-danger', btn: [btnText, _langJS.cancel]}, function (index) {
        actionClosure(); // 执行闭包
        localStorage.setItem('alert_action_success', btnText);
        layer.close(index);
    });
}

function changeAuthorAlert() {
    layer.prompt({
        title: _langJS.input_new_author_id,
        formType: 0 // 单行输入框
    }, function(value, index) {
        $('#author').val(value); // 将输入的作者ID设置到隐藏的输入框中
        changeAuthor(); // 调用更改作者的函数
        layer.close(index);
    });
}

function delArticle(msg, text, url, token) {
    layer.confirm(text, {
        title: msg,
        icon: 3,
        btn: [_langJS.put_to_draft, '<span class="text-danger">' + _langJS.completely_delete + '</span>', _langJS.cancel]
    }, function (index) {
        window.location = url + '&token=' + token;
        layer.close(index);
    }, function (index) {
        localStorage.setItem('alert_action_success', _langJS.delete);
        window.location = url + '&rm=1&token=' + token;
        layer.close(index);
    }, function (index) {
        layer.close(index);
    });
}

function submitForm(formId, successMsg) {
    $.ajax({
        type: "POST",
        url: $(formId).attr('action'),
        data: $(formId).serialize(),
        success: function () {
            cocoMessage.success(successMsg || _langJS.save_success)
        },
        error: function (xhr) {
            const errorMsg = JSON.parse(xhr.responseText).msg;
            cocoMessage.error(errorMsg, 4000)
        }
    });
}

function focusEle(id) {
    try {
        document.getElementById(id).focus();
    } catch (e) {
    }
}

function hideActived() {
    $(".alert-success").slideUp(300);
    $(".alert-danger").slideUp(300);
}

function displayToggle(id) {
    const element = $("#" + id);
    const iconElement = element.prev().find(".icofont-simple-down, .icofont-simple-right");

    element.toggle();
    const isVisible = element.is(":visible");

    iconElement.attr("class", isVisible ? "icofont-simple-down" : "icofont-simple-right");
    localStorage.setItem('em_' + id, isVisible ? "down" : "right");
}

function initDisplayState(id) {
    const storedState = localStorage.getItem('em_' + id);
    const element = $("#" + id);
    const iconElement = element.prev().find(".icofont-simple-down, .icofont-simple-right");

    if (storedState) {
        const isVisible = storedState === "down";
        element.toggle(isVisible);
        iconElement.attr("class", isVisible ? "icofont-simple-down" : "icofont-simple-right");
    }
}

function doToggle(id) {
    $("#" + id).toggle();
}

function insertTag(tag, boxId) {
    var targetinput = $("#" + boxId).val();
    if (targetinput == '') {
        targetinput += tag;
    } else {
        var n = ',' + tag;
        targetinput += n;
    }
    $("#" + boxId).val(targetinput);
    if (boxId == "tag") $("#tag_label").hide();
}

function isalias(a) {
    var reg1 = /^[\w-]*$/;
    var reg2 = /^\d+$/;
    var reg3 = /^post(-\d+)?$/;
    if (!reg1.test(a)) {
        return 1;
    } else if (reg2.test(a)) {
        return 2;
    } else if (reg3.test(a)) {
        return 3;
    } else if (a === 't' || a === 'm' || a === 'admin') {
        return 4;
    } else {
        return 0;
    }
}

function checkform() {
    var a = $.trim($("#alias").val());
    var t = $.trim($("#title").val());

    if (typeof articleTextRecord !== "undefined") {  // 提交时，重置原文本记录值，防止出现离开提示
        articleTextRecord = $("textarea[name=logcontent]").text();
    } else {
        pageText = $("textarea").text();
    }
    if (0 == isalias(a)) {
        return true;
    } else {
        cocoMessage.error(_langJS.alias_format_error, 4000)
        $("#alias").focus();
        return false;
    }
}

function checkalias() {
    var a = $.trim($("#alias").val());
    if (1 == isalias(a)) {
        $("#alias_msg_hook").html('<span id="input_error">' + _langJS.alias_char_error + '</span>');
    } else if (2 == isalias(a)) {
        $("#alias_msg_hook").html('<span id="input_error">' + _langJS.alias_number_error + '</span>');
    } else if (3 == isalias(a)) {
        $("#alias_msg_hook").html('<span id="input_error">' + _langJS.alias_reserved_error + '</span>');
    } else if (4 == isalias(a)) {
        $("#alias_msg_hook").html('<span id="input_error">' + _langJS.alias_conflict_error + '</span>');
    } else {
        $("#alias_msg_hook").html('');
        $("#msg").html('');
    }
}

// act 1：Auto save 2：User manually saves
function autosave(act) {
    const nodeid = "as_logid";
    const timeout = 60000;
    const url = "article_save.php?action=autosave";
    const alias = $.trim($("#alias").val());
    const content = Editor.getMarkdown();
    let ishide = $.trim($("#ishide").val());
    if (ishide === "") {
        $("#ishide").val("y")
    }

    if (alias != '' && 0 != isalias(alias)) {
        cocoMessage.error(_langJS.alias_save_error, 4000)
        if (act == 0) {
            setTimeout("autosave(1)", timeout);
        }
        return;
    }
    // 编辑发布状态的文章时不自动保存
    if (act == 1 && ishide == 'n') {
        return;
    }
    // 内容为空时不自动保存
    if (act == 1 && content == "") {
        setTimeout("autosave(1)", timeout);
        return;
    }
    // 距离上次保存成功时间小于一秒时不允许手动保存
    if ((new Date().getTime() - Cookies.get('em_saveLastTime')) < 1000 && act != 1) return;

    const $savedf = $("#savedf");
    const btname = $savedf.val();
    $savedf.val(_langJS.saving).attr("disabled", "disabled");
    $('title').text('[' + _langJS.saving + '] ' + titleText);
    $.post(url, $("#addlog").serialize(), function (data) {
        data = $.trim(data);
        var isresponse = /.*autosave\_gid\:\d+\_.*/;
        if (isresponse.test(data)) {
            const getvar = data.match(/_gid:([\d]+)_/);
            const logid = getvar[1];
            const d = new Date();
            const h = d.getHours();
            const m = d.getMinutes();
            const tm = (h < 10 ? "0" + h : h) + ":" + (m < 10 ? "0" + m : m);
            $("#save_info").html(_langJS.saved_at + tm + " <a href=\"../?post=" + logid + "\" target=\"_blank\">" + _langJS.preview + "</a>");
            $('title').text('[' + _langJS.save_success + '] ' + titleText);
            setTimeout(function () {
                $('title').text(titleText);
            }, 2000);
            articleTextRecord = $("#addlog textarea[name=logcontent]").val(); // 保存成功后，将原文本记录值替换为现在的文本
            Cookies.set('em_saveLastTime', new Date().getTime()); // 把保存成功时间戳记录（或更新）到 cookie 中
            $("#" + nodeid).val(logid);
            $("#savedf").attr("disabled", false).val(btname);
        } else {
            $("#savedf").attr("disabled", false).val(btname);
            $("#save_info").html(_langJS.save_failed_reason).addClass("alert-danger");
            $('title').text('[' + _langJS.save_failed + '] ' + titleText);
        }
    });
    if (act == 1) {
        setTimeout("autosave(1)", timeout);
    }
}

// “页面”的 editor.md 编辑器 Ctrl + S 快捷键的自动保存动作
const pagetitle = $('title').text();

function pageSave() {
    document.addEventListener('keydown', function (e) {  // 阻止自动保存产生的浏览器默认动作
        if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
            e.preventDefault();
        }
    });
    const nodeid = "pageid";
    const url = "page.php?action=autosave";
    const alias = $.trim($("#alias").val());
    let ishide = $.trim($("#ishide").val());
    if (ishide === "") {
        $("#ishide").val("y")
    }

    if (alias != '' && 0 != isalias(alias)) {
        cocoMessage.error(_langJS.alias_save_error, 4000)
        return;
    }

    const $savedf = $("#savedf");
    const btname = $savedf.val();
    $savedf.val(_langJS.saving).attr("disabled", "disabled");
    $.post(url, $("#addlog").serialize(), function (data) {
        data = $.trim(data);
        var isresponse = /.*autosave\_gid\:\d+\_.*/;
        if (isresponse.test(data)) {
            const getvar = data.match(/_gid:([\d]+)_/);
            const pageid = getvar[1];
            const d = new Date();
            const h = d.getHours();
            const m = d.getMinutes();
            const tm = (h < 10 ? "0" + h : h) + ":" + (m < 10 ? "0" + m : m);
            $("#save_info").html(_langJS.saved_at + tm + " <a href=\"../?post=" + pageid + "\" target=\"_blank\">" + _langJS.preview + "</a>");
            $("#" + nodeid).val(pageid);
            $("#savedf").attr("disabled", false).val(btname);
            // 保存成功后更新pageText，避免页面离开时的错误提示
            if (typeof pageText !== 'undefined') {
                pageText = $("textarea").text();
            }
        } else {
            $("#savedf").attr("disabled", false).val(btname);
            $("#save_info").html(_langJS.save_failed).addClass("alert-danger");
        }
    });
}

// toggle plugin
$.fn.toggleClick = function () {
    var functions = arguments;
    return this.click(function () {
        var iteration = $(this).data('iteration') || 0;
        functions[iteration].apply(this, arguments);
        iteration = (iteration + 1) % functions.length;
        $(this).data('iteration', iteration);
    });
};

function removeHTMLTag(str) {
    str = str.replace(/<\/?[^>]*>/g, ''); //去除HTML tag
    str = str.replace(/[ | ]*\n/g, '\n'); //去除行尾空白
    str = str.replace(/ /ig, '');
    return str;
}

// editor.md 的 js 钩子
var queue = new Array();
var hooks = {
    addAction: function (hook, func) {
        if (typeof (queue[hook]) == "undefined" || queue[hook] == null) {
            queue[hook] = new Array();
        }
        if (typeof func == 'function') {
            queue[hook].push(func);
        }
    },
    doAction: function (hook, obj) {
        try {
            for (var i = 0; i < queue[hook].length; i++) {
                queue[hook][i](obj);
            }
        } catch (e) {
        }
    }
}

// 粘贴上传图片函数
function imgPasteExpand(thisEditor) {
    var listenObj = document.querySelector("textarea").parentNode  // 要监听的对象
    var postUrl = './media.php?action=upload';  // emlog 的图片上传地址
    var emMediaPhpUrl = "./media.php?action=lib";  // emlog 的资源库地址,用于异步获取上传后的图片数据

    // 通过动态配置只读模式,阻止编辑器原有的粘贴动作发生,并恢复光标位置
    function preventEditorPaste() {
        let l = thisEditor.getCursor().line;
        let c = thisEditor.getCursor().ch - 3;

        thisEditor.config({readOnly: true,});
        thisEditor.config({readOnly: false,});
        thisEditor.setCursor({line: l, ch: c});
    }

    // 编辑器通过光标处位置前几位来替换文字
    function replaceByNum(text, num) {
        let l = thisEditor.getCursor().line;
        let c = thisEditor.getCursor().ch;

        thisEditor.setSelection({line: l, ch: (c - num)}, {line: l, ch: c});
        thisEditor.replaceSelection(text);
    }

    // 粘贴事件触发
    listenObj.addEventListener("paste", function (e) {
        if ($('.editormd-dialog').css('display') == 'block') return;  // 如果编辑器有对话框则退出
        if (!(e.clipboardData && e.clipboardData.items)) return;

        var pasteData = e.clipboardData || window.clipboardData; // 获取剪切板里的全部内容
        pasteAnalyseResult = new Array;  // 用于储存遍历分析后的结果

        for (var i = 0; i < pasteData.items.length; i++) {  // 遍历分析剪切板里的数据
            var item = pasteData.items[i];

            if ((item.kind == "file") && (item.type.match('^image/'))) {
                var imgData = item.getAsFile();
                if (imgData.size === 0) return;
                pasteAnalyseResult['type'] = 'img';
                pasteAnalyseResult['data'] = imgData;
                break;  // 当粘贴板中有图片存在时,跳出循环
            }
            ;
        }

        if (pasteAnalyseResult['type'] == 'img') {  // 如果剪切板中有图片,上传图片
            preventEditorPaste();
            uploadImg(pasteAnalyseResult['data']);
            return;
        }
    }, false);

    // 上传图片
    function uploadImg(img) {
        var formData = new FormData();
        var imgName = "粘贴上传" + new Date().getTime() + "." + img.name.split(".").pop();

        formData.append('file', img, imgName);
        thisEditor.insertValue(_langJS.uploading);
        $.ajax({
            url: postUrl, type: 'post', data: formData, processData: false, contentType: false, xhr: function () {
                var xhr = $.ajaxSettings.xhr();
                if (xhr.upload) {
                    thisEditor.insertValue("....");
                    xhr.upload.addEventListener('progress', function (e) {  // 用以显示上传进度
                        console.log(_langJS.upload_progress + e.loaded + ' / ' + e.total);
                        let percent = Math.floor(e.loaded / e.total * 100);
                        if (percent < 10) {
                            replaceByNum('..' + percent + '%', 4);
                        } else if (percent < 100) {
                            replaceByNum('.' + percent + '%', 4);
                        } else {
                            replaceByNum(percent + '%', 4);
                        }
                    }, false);
                }
                return xhr;
            }, success: function (result) {
                console.log(_langJS.upload_success_get_result);
                $.get(emMediaPhpUrl, function (resp) {
                    var image = resp.data.images[0];
                    if (image) {
                        console.log(_langJS.get_result_success)
                        replaceByNum(`![](${image.media_icon})`, 10);  // 这里的数字 10 对应着’上传中...100%‘是10个字符
                    } else {
                        console.log(_langJS.get_result_failed)
                        infoAlert(_langJS.get_result_failed);
                    }
                })
            }, error: function (result) {
                infoAlert(_langJS.upload_img_error);
                replaceByNum(_langJS.upload_img_error, 6);
            }
        })
    }
}

// 允许拖动编辑器底部边缘改变高度
function enableEditorResize(editorInstance, minHeight) {
    if (!editorInstance || !editorInstance.editor) return;
    var $editor = editorInstance.editor;
    if ($editor.find('.editormd-resize-handle').length > 0) return;

    minHeight = minHeight || 150;
    var $handle = $('<div class="editormd-resize-handle" title="拖拽调节编辑器高度"></div>');
    $editor.append($handle);

    $handle.on('mousedown', function(e) {
        e.preventDefault();
        var startY = e.clientY;
        var startHeight = $editor.outerHeight();

        $handle.addClass('dragging');
        var $overlay = $('<div style="position:fixed;top:0;left:0;right:0;bottom:0;z-index:99999;cursor:s-resize;"></div>');
        $('body').append($overlay);

        $(document).on('mousemove.editorResize', function(e) {
            var newHeight = startHeight + (e.clientY - startY);
            if (newHeight >= minHeight) {
                editorInstance.resize(null, newHeight);
            }
        });

        $(document).on('mouseup.editorResize', function() {
            $(document).off('.editorResize');
            $overlay.remove();
            $handle.removeClass('dragging');
        });
    });
}

/**
 * Editor.md 表格增强辅助器（悬浮工具栏与智能操作）
 * 为 Markdown 表格提供就地增行、增列、删行、删列及格式化对齐功能
 *
 * @param {Object} thisEditor Editor.md 实例
 * @return {void}
 */
function enableEditorTableHelper(thisEditor) {
    if (!thisEditor || !thisEditor.cm) return;
    var cm = thisEditor.cm;
    var $wrapper = $(cm.getWrapperElement());
    if ($wrapper.find('.editormd-table-toolbar').length > 0) return;

    var $toolbar = $('<div class="editormd-table-toolbar">' +
        '<span class="table-tool-title"><i class="icofont-table mr-1"></i>表格</span>' +
        '<a href="javascript:;" class="table-tool-btn" data-act="addRowBelow" title="在当前行下方插入行">+ 行↓</a>' +
        '<a href="javascript:;" class="table-tool-btn" data-act="addRowAbove" title="在当前行上方插入行">+ 行↑</a>' +
        '<span class="table-tool-sep"></span>' +
        '<a href="javascript:;" class="table-tool-btn" data-act="addColRight" title="在当前列右侧插入列">+ 列→</a>' +
        '<a href="javascript:;" class="table-tool-btn" data-act="addColLeft" title="在当前列左侧插入列">+ 列←</a>' +
        '<span class="table-tool-sep"></span>' +
        '<a href="javascript:;" class="table-tool-btn btn-danger-tool" data-act="deleteRow" title="删除当前行">- 行</a>' +
        '<a href="javascript:;" class="table-tool-btn btn-danger-tool" data-act="deleteCol" title="删除当前列">- 列</a>' +
        '<span class="table-tool-sep"></span>' +
        '<a href="javascript:;" class="table-tool-btn" data-act="format" title="美化对齐表格">对齐</a>' +
    '</div>');
    $wrapper.append($toolbar);

    // 字符显示宽度（中文字符占2）与字符串重复
    function charW(s) { return (s || '').replace(/[\u4e00-\u9fa5\uff00-\uffef]/g, 'aa').length; }
    function rep(s, n) { return n > 0 ? (s.repeat ? s.repeat(n) : new Array(n + 1).join(s)) : ''; }

    // 拆分单行单元格
    function parseRowCells(line) {
        var s = line.trim().replace(/^\||\|$/g, ''), cells = [], cur = '', esc = false;
        for (var i = 0; i < s.length; i++) {
            var c = s[i];
            if (esc) { cur += c; esc = false; }
            else if (c === '\\') { cur += c; esc = true; }
            else if (c === '|') { cells.push(cur.trim()); cur = ''; }
            else { cur += c; }
        }
        cells.push(cur.trim());
        return cells;
    }

    // 格式化表格并输出字符偏移映射
    function formatMarkdownTable(rows) {
        var maxCols = 0;
        rows.forEach(function(r) { if (r.length > maxCols) maxCols = r.length; });
        if (!maxCols) return { text: '', cellPositions: [] };

        var colWidths = new Array(maxCols).fill(3);
        rows.forEach(function(r, rIdx) {
            if (rIdx === 1) return;
            r.forEach(function(val, cIdx) {
                colWidths[cIdx] = Math.max(colWidths[cIdx], charW(val));
            });
        });

        var lines = [], cellPositions = [];
        rows.forEach(function(r, rIdx) {
            var parts = [], currentCh = 2, rowPos = [];
            for (var c = 0; c < maxCols; c++) {
                var val = r[c] || '', targetW = colWidths[c], cellText = '';
                if (rIdx === 1) {
                    var l = val.charAt(0) === ':', rt = val.slice(-1) === ':';
                    cellText = (l ? ':' : '-') + rep('-', Math.max(3, targetW) - (l ? 1 : 0) - (rt ? 1 : 0)) + (rt ? ':' : '-');
                } else {
                    cellText = val + rep(' ', targetW - charW(val));
                }
                rowPos.push({ startCh: currentCh, endCh: currentCh + cellText.length, contentEndCh: currentCh + val.length });
                parts.push(cellText);
                currentCh += cellText.length + (c < maxCols - 1 ? 3 : 2);
            }
            cellPositions.push(rowPos);
            lines.push('| ' + parts.join(' | ') + ' |');
        });
        return { text: lines.join('\n'), cellPositions: cellPositions };
    }

    // 探测光标所在表格
    function detectMarkdownTable(cursor) {
        var curLine = cursor.line, totalLines = cm.lineCount();
        var curText = cm.getLine(curLine);
        if (!curText || curText.indexOf('|') === -1) return null;

        var startLine = curLine, endLine = curLine;
        while (startLine > 0 && cm.getLine(startLine - 1).indexOf('|') !== -1 && cm.getLine(startLine - 1).trim() !== '') startLine--;
        while (endLine < totalLines - 1 && cm.getLine(endLine + 1).indexOf('|') !== -1 && cm.getLine(endLine + 1).trim() !== '') endLine++;

        var sepLine = -1, sepRegex = /^\s*\|?\s*:?-{2,}:?\s*(\|\s*:?-{2,}:?\s*)+\|?\s*$/;
        for (var l = startLine; l <= endLine; l++) {
            if (sepRegex.test(cm.getLine(l))) { sepLine = l; break; }
        }
        if (sepLine === -1 || sepLine - 1 < startLine || curLine < sepLine - 1) return null;

        var headerLine = sepLine - 1, rows = [], maxCols = 0;
        for (var i = headerLine; i <= endLine; i++) {
            var parsed = parseRowCells(cm.getLine(i));
            maxCols = Math.max(maxCols, parsed.length);
            rows.push(parsed);
        }
        if (!maxCols) return null;

        rows.forEach(function(r, idx) {
            while (r.length < maxCols) r.push(idx === 1 ? '---' : (idx === 0 ? '表头' : '数据'));
        });

        var before = curText.substring(0, cursor.ch);
        var pipes = (before.match(/(^|[^\\])\|/g) || []).length;
        var col = curText.trim().charAt(0) === '|' ? Math.max(0, pipes - 1) : pipes;

        return {
            startLine: headerLine,
            endLine: endLine,
            currentRow: curLine - headerLine,
            currentCol: Math.min(col, maxCols - 1),
            totalCols: maxCols,
            rows: rows
        };
    }

    // 更新工具栏浮动位置
    function updateToolbar() {
        var cursor = cm.getCursor(), table = detectMarkdownTable(cursor);
        if (!table) return $toolbar.hide();

        var charPos = cm.charCoords(cursor, "local"), scrollInfo = cm.getScrollInfo();
        var top = charPos.top - scrollInfo.top - 36, left = charPos.left - scrollInfo.left;
        if (top < 5) top = charPos.bottom - scrollInfo.top + 6;

        var wrapperW = $wrapper.width(), toolW = $toolbar.outerWidth() || 330;
        left = Math.max(10, Math.min(left, wrapperW - toolW - 15));
        $toolbar.css({ top: top + 'px', left: left + 'px' }).show();
    }

    // 执行增删改动作
    function executeTableAction(action) {
        var cursor = cm.getCursor(), table = detectMarkdownTable(cursor);
        if (!table) return;

        var rows = table.rows, curR = table.currentRow, curC = table.currentCol;
        var targetR = curR, targetC = curC;

        if (action === 'addRowBelow' || action === 'addRowAbove') {
            targetR = (action === 'addRowBelow') ? (curR <= 1 ? 2 : curR + 1) : Math.max(2, curR);
            var newRow = [];
            for (var i = 0; i < table.totalCols; i++) newRow.push('数据');
            rows.splice(targetR, 0, newRow);
        } else if (action === 'addColRight' || action === 'addColLeft') {
            targetC = (action === 'addColRight') ? curC + 1 : curC;
            rows.forEach(function(r, idx) {
                r.splice(targetC, 0, idx === 0 ? '表头' : (idx === 1 ? '---' : '数据'));
            });
        } else if (action === 'deleteRow') {
            if (curR <= 1) return layer && layer.msg && layer.msg('表头和分隔行不可删除');
            rows.splice(curR, 1);
            if (rows.length <= 2) {
                var newRow = [];
                for (var i = 0; i < table.totalCols; i++) newRow.push('数据');
                rows.push(newRow);
            }
            targetR = Math.max(2, curR - 1);
        } else if (action === 'deleteCol') {
            if (table.totalCols <= 1) return layer && layer.msg && layer.msg('表格至少保留一列');
            rows.forEach(function(r) { r.splice(curC, 1); });
            targetC = Math.max(0, curC - 1);
        } else if (action === 'format') {
            layer && layer.msg && layer.msg('表格已对齐美化');
        }

        var formatted = formatMarkdownTable(rows);
        cm.replaceRange(formatted.text, { line: table.startLine, ch: 0 }, { line: table.endLine, ch: cm.getLine(table.endLine).length });

        var nextLine = table.startLine + targetR;
        if (formatted.cellPositions[targetR] && formatted.cellPositions[targetR][targetC]) {
            var pos = formatted.cellPositions[targetR][targetC];
            if (action !== 'format' && pos.startCh < pos.contentEndCh) {
                cm.setSelection({ line: nextLine, ch: pos.startCh }, { line: nextLine, ch: pos.contentEndCh });
            } else {
                cm.setCursor({ line: nextLine, ch: pos.contentEndCh });
            }
        }
        cm.focus();
        setTimeout(updateToolbar, 30);
    }

    $toolbar.on('mousedown', '.table-tool-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        executeTableAction($(this).data('act'));
    });

    cm.on('cursorActivity', updateToolbar);
    cm.on('scroll', updateToolbar);
    cm.on('blur', function() {
        setTimeout(function() { if (!$toolbar.is(':hover')) $toolbar.hide(); }, 200);
    });
}

/**
 * 为 Editor.md 编辑器工具栏提供文字颜色和背景色拾取功能
 *
 * @param {Object} thisEditor Editor.md 实例
 * @return {void}
 */
function enableEditorColorHelper(thisEditor) {
    if (!thisEditor || !thisEditor.editor || !thisEditor.cm) return;
    var cm = thisEditor.cm, $editor = $(thisEditor.editor);
    var editorId = thisEditor.id || 'default', popId = 'editormd-color-popover-' + editorId;
    if ($editor.data('color-helper-inited')) return;
    $editor.data('color-helper-inited', true);

    $('#' + popId).remove();

    var lang = typeof _langJS !== 'undefined' ? _langJS : {};
    var colors = {
        text: ['#e03131', '#e8590c', '#f59f00', '#2f9e44', '#0ca678', '#1098ad', '#1c7ed6', '#4263eb', '#7048e8', '#ae3ec9', '#d6336c', '#212529'],
        bg: ['#ffe3e3', '#ffe8cc', '#ffec99', '#d3f9d8', '#c3fae8', '#c5f6fa', '#d0ebff', '#dbe4ff', '#e5dbff', '#f3d9fa', '#fcc2d7', '#f1f3f5']
    };

    function renderSwatches(list) {
        return list.map(function(c) {
            return '<span class="color-swatch" data-color="' + c + '" style="background-color:' + c + ';" title="' + c + '"></span>';
        }).join('');
    }

    var $popover = $('<div id="' + popId + '" class="editormd-color-popover" style="display:none;">' +
        '<div class="color-popover-tabs">' +
            '<span class="color-tab active" data-type="text">' + (lang.md_text_color || '文字颜色') + '</span>' +
            '<span class="color-tab" data-type="bg">' + (lang.md_bg_color || '背景颜色') + '</span>' +
        '</div>' +
        '<div class="color-palette">' + renderSwatches(colors.text) + '</div>' +
        '<div class="color-popover-footer">' +
            '<label class="custom-color-label" title="' + (lang.md_custom_color || '自定义') + '">' +
                '<span>' + (lang.md_custom_color || '自定义') + '</span>' +
                '<input type="color" class="custom-color-input" value="#e03131">' +
            '</label>' +
            '<a href="javascript:;" class="color-clear-btn">' + (lang.md_clear_color || '恢复默认') + '</a>' +
        '</div>' +
    '</div>').appendTo($editor);

    var savedSel = null, currentMode = 'text';

    function apply(color) {
        cm.focus();
        var sel = savedSel || { from: cm.getCursor('from'), to: cm.getCursor('to'), text: cm.getSelection() };
        var text = sel.text || (color ? '文本' : '');
        var repl = color ? '<span style="' + (currentMode === 'text' ? 'color:' : 'background-color:') + ' ' + color + ';">' + text + '</span>'
                         : (sel.text ? sel.text.replace(/<span style="(color|background-color):\s*[^";]+;">(.*?)<\/span>/gi, '$2') : '');
        cm.replaceRange(repl, sel.from, sel.to);
        if (color && !sel.text) {
            var offset = ('<span style="' + (currentMode === 'text' ? 'color:' : 'background-color:') + ' ' + color + ';">').length;
            cm.setSelection({ line: sel.from.line, ch: sel.from.ch + offset }, { line: sel.from.line, ch: sel.from.ch + offset + text.length });
        }
        $popover.hide();
        savedSel = null;
    }

    $popover.on('click', '.color-tab', function(e) {
        e.stopPropagation();
        currentMode = $(this).data('type');
        $popover.find('.color-tab').removeClass('active');
        $(this).addClass('active');
        $popover.find('.color-palette').html(renderSwatches(colors[currentMode]));
        $popover.find('.custom-color-input').val(currentMode === 'text' ? '#e03131' : '#ffe3e3');
    }).on('click', '.color-swatch', function(e) {
        e.stopPropagation();
        apply($(this).data('color'));
    }).on('click', '.color-clear-btn', function(e) {
        e.stopPropagation();
        apply(null);
    }).on('change', '.custom-color-input', function() {
        apply($(this).val());
    });

    function toggleColorPopover(btnEl, e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        var $targetBtn = $(btnEl || $editor.find('.editormd-menu .fa[name="color"]').closest('a'));
        if ($targetBtn.length === 0) return;
        if ($popover.is(':visible')) { $popover.hide(); savedSel = null; return; }
        savedSel = { from: cm.getCursor('from'), to: cm.getCursor('to'), text: cm.getSelection() };
        var bOff = $targetBtn.offset(), eOff = $editor.offset();
        var left = Math.max(0, Math.min(bOff.left - eOff.left, $editor.width() - 206));
        $popover.css({ top: (bOff.top - eOff.top + $targetBtn.outerHeight() + 4) + 'px', left: left + 'px' }).fadeIn(100);
    }

    // 注册为 editormd 自定义工具栏动作，保证 editormd 原生工具栏事件能直接触发
    if (typeof editormd !== 'undefined' && editormd.toolbarHandlers) {
        editormd.toolbarHandlers.color = function() {
            toggleColorPopover();
        };
    }

    // 事件委托：支持直接点击颜色图标或按钮
    $editor.on('click', '.editormd-menu a:has(.fa[name="color"]), .editormd-menu a.editormd-color-btn, .editormd-menu .fa[name="color"]', function(e) {
        toggleColorPopover($(this).closest('a')[0] || this, e);
    });

    $(document).on('mousedown.em_c_' + editorId + ' keydown.em_c_' + editorId, function(e) {
        if (e.type === 'keydown' && e.key !== 'Escape') return;
        if (!$(e.target).closest($popover).length && !$(e.target).closest('.editormd-menu a:has(.fa[name="color"]), .editormd-menu a.editormd-color-btn, .editormd-menu .fa[name="color"]').length) {
            $popover.hide();
        }
    });
}

// 把粘贴上传图片与高度拖拽拉伸函数，挂载到位于文章编辑器、页面编辑器、微语编辑器处的 js 钩子处
hooks.addAction("loaded", imgPasteExpand);
hooks.addAction("page_loaded", imgPasteExpand);
hooks.addAction("twitter_loaded", imgPasteExpand);
hooks.addAction("loaded", enableEditorResize);
hooks.addAction("page_loaded", enableEditorResize);
hooks.addAction("twitter_loaded", enableEditorResize);
hooks.addAction("loaded", enableEditorTableHelper);
hooks.addAction("page_loaded", enableEditorTableHelper);
hooks.addAction("loaded", enableEditorColorHelper);
hooks.addAction("page_loaded", enableEditorColorHelper);
hooks.addAction("twitter_loaded", enableEditorColorHelper);

function checkUpdate() {
    const updateModal = $("#update-modal");
    const updateModalLoading = $("#update-modal-loading");
    const updateModalMsg = $("#update-modal-msg");
    const updateModalChanges = $("#update-modal-changes");
    const updateModalBtn = $("#update-modal-btn");

    updateModal.modal({
        backdrop: 'static',
        keyboard: false
    });
    updateModal.modal('show');
    updateModalLoading.addClass("spinner-border text-primary");

    let rep_msg = "";
    let rep_changes = "";
    let rep_btn = "";

    updateModalMsg.html(rep_msg);
    updateModalChanges.html(rep_changes);
    updateModalBtn.html(rep_btn);

    $.get("./upgrade.php?action=check_update", function (result) {
        if (result.code === 1001) {
            rep_msg = _langJS.update_register_msg;
        } else if (result.code === 1002) {
            rep_msg = _langJS.latest_version;
        } else if (result.code === 200) {
            rep_msg = _langJS.new_version_available + `<span class="text-danger">${result.data.version}</span> <br><br>`;
            rep_changes = "<b>" + _langJS.update_content + "</b>:<br>" + result.data.changes;

            // 检查 cdn_sql 和 cdn_file 是否为空
            let sqlFile = result.data.cdn_sql || result.data.sql;
            let fileFile = result.data.cdn_file || result.data.file;

            rep_btn = `<hr><a href="javascript:doUp('${fileFile}','${sqlFile}');" id="upbtn" class="btn btn-success btn-sm">${_langJS.update_now}</a>`;
        } else {
            rep_msg = _langJS.check_update_failed;
        }

        updateModalLoading.removeClass();
        updateModalMsg.html(rep_msg);
        updateModalChanges.html(rep_changes);
        updateModalBtn.html(rep_btn);
    });
}

function doUp(source, upSQL) {
    const updateModalLoading = $("#update-modal-loading");
    const updateModalMsg = $("#update-modal-msg");
    const updateModalChanges = $("#update-modal-changes");
    const upmsg = $("#upmsg");
    const upbtn = $("#upbtn");

    updateModalLoading.addClass("spinner-border text-primary");
    updateModalMsg.html(_langJS.uploading_wait);
    updateModalChanges.html("");

    $.post("./upgrade.php?action=update", {
        source: source,
        upsql: upSQL
    }, function (data) {
        upmsg.removeClass();
        if (data.includes("succ")) {
            upbtn.text(_langJS.refresh_page);
            upbtn.attr('href', './');
            updateModalMsg.html(_langJS.update_success_html);
        } else if (data.includes("error_register")) {
            updateModalMsg.html(_langJS.update_register_msg);
            $("#update-modal-btn").empty();
        } else if (data.includes("error_down")) {
            updateModalMsg.html(_langJS.download_error);
        } else if (data.includes("error_zip")) {
            updateModalMsg.html(_langJS.unzip_error);
        } else if (data.includes("error_dir")) {
            updateModalMsg.html(_langJS.dir_error);
        } else {
            updateModalMsg.html(_langJS.update_error);
        }

        updateModalLoading.removeClass();
    });
}

function initCheckboxState(id) {
    const isChecked = localStorage.getItem(id) === 'true';
    $('#' + id).prop('checked', isChecked);
}

function toggleCheckbox(id) {
    const isChecked = $('#' + id).prop('checked');
    localStorage.setItem(id, isChecked);
}

/**
 * 初始化快捷入口工具栏
 * 
 * @return void
 */
function initShortcutBar() {
    // 快捷入口已常态化显示，无需 hover 控制逻辑
}

/**
 * 封装复选框全选逻辑
 * @param {string} checkAllSelector 全选按钮选择器
 * @param {string} containerSelector 复选框容器选择器
 */
function initCheckboxSelectAll(checkAllSelector, containerSelector) {
    $(checkAllSelector).click(function () {
        let cardCheckboxes = $(containerSelector).find('input[type=checkbox]');
        cardCheckboxes.prop('checked', $(this).prop('checked'));
    });

    $(containerSelector).find('input[type=checkbox]').click(function () {
        let allChecked = true;
        $(containerSelector).find('input[type=checkbox]').each(function () {
            if (!$(this).prop('checked')) {
                allChecked = false;
                return false;
            }
        });
        $(checkAllSelector).prop('checked', allChecked);
    });
}

/**
 * 自动调整textarea高度的通用方法
 * @param {jQuery|string} selector - jQuery对象或选择器字符串
 * @param {Object} options - 配置选项
 * @param {number} options.minHeight - 最小高度，默认33px
 * @param {number} options.maxHeight - 最大高度，默认无限制
 * @param {number} options.padding - 额外的内边距，默认2px
 */
function autoResizeTextarea(selector, options = {}) {
    const defaults = {
        minHeight: 33,
        maxHeight: null,
        padding: 2
    };
    
    const config = Object.assign(defaults, options);
    
    function bindResize($textarea) {
        $textarea.on('input propertychange', function() {
            const element = this;
            element.style.height = 'auto';
            
            let newHeight = element.scrollHeight + config.padding;
            
            // 应用最小高度限制
            if (newHeight < config.minHeight) {
                newHeight = config.minHeight;
            }
            
            // 应用最大高度限制
            if (config.maxHeight && newHeight > config.maxHeight) {
                newHeight = config.maxHeight;
                element.style.overflowY = 'auto';
            } else {
                element.style.overflowY = 'hidden';
            }
            
            element.style.height = newHeight + 'px';
        });
        
        // 初始化时也调整一次
        $textarea.trigger('input');
    }
    
    // 处理不同类型的选择器
    if (typeof selector === 'string') {
        $(selector).each(function() {
            bindResize($(this));
        });
    } else if (selector instanceof jQuery) {
        selector.each(function() {
            bindResize($(this));
        });
    }
}

/**
 * 初始化页面中所有带有 auto-resize-textarea 类的文本域
 */
function initAutoResizeTextareas() {
    autoResizeTextarea('.auto-resize-textarea');
}

$(function () {
    // 复选框全选
    initCheckboxSelectAll('#checkAllItem', '.checkboxContainer');

    // 应用商店：应用安装
    $(document).on('click', '.installBtn', function (e) {
        e.preventDefault();
        let link = $(this);
        let down_url = link.data('url');
        let type = link.data('type');
        var installText = typeof _langJS !== 'undefined' && _langJS.store_install ? _langJS.store_install : '安装';
        link.html('<i class="icofont-spinner icofont-spin mr-1"></i>安装中…');
        link.parent().prev(".installMsg").html("").addClass("spinner-border text-primary");
    
        let url = './store.php?action=install&type=' + type + '&source=' + down_url;
        $.get(url, function (data) {
            if (link.hasClass('modal-install-btn')) {
                link.html('<i class="icofont-download mr-1"></i>' + installText);
            } else {
                link.text(installText);
            }
            if (data.code === 0) {
                cocoMessage.success(data.msg, 8000);
            } else {
                cocoMessage.error(data.msg, 8000);
            }
            link.parent().prev(".installMsg").removeClass("spinner-border text-primary");
        }, 'json');
    });

    /**
     * 应用商店：查看应用详情弹窗监听与页面载入处理
     */
    $('#appModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var name = button.data('name');
        var url = button.data('url');
        var buy_url = button.data('buy-url');
        var download_url = button.data('download-url');
        var type = button.data('type');
        var modal = $(this);

        modal.find('.modal-body').empty();
        modal.find('.modal-title').text(name);

        if (buy_url && $.trim(buy_url) !== '') {
            modal.find('.modal-buy-url').attr('href', buy_url).removeClass('d-none').show();
        } else {
            modal.find('.modal-buy-url').addClass('d-none').hide();
        }

        var $installBtn = modal.find('.modal-install-btn');
        if (download_url && $.trim(download_url) !== '') {
            var installText = typeof _langJS !== 'undefined' && _langJS.store_install ? _langJS.store_install : '安装';
            $installBtn.data('url', download_url)
                       .data('type', type || '')
                       .html('<i class="icofont-download mr-1"></i>' + installText)
                       .removeClass('d-none')
                       .show();
        } else {
            // 没有下载链接（如未购买收费应用）则隐藏安装按钮
            $installBtn.addClass('d-none').hide();
        }

        var loadingSpinner = '<div class="spinner-border spinner-border-sm text-primary ml-2 align-middle" role="status" style="width: 1rem; height: 1rem;"><span class="sr-only">Loading...</span></div>';
        modal.find('.modal-title').append(loadingSpinner);

        var iframe = $('<iframe>', {
            'class': 'iframe-content',
            'src': url,
            'frameborder': 0
        });

        iframe.on('load', function () {
            modal.find('.spinner-border').remove();
        });

        modal.find('.modal-body').append(iframe);
    });

    // 删除提示
    const alert_action_success = localStorage.getItem('alert_action_success')
    if (localStorage.getItem('alert_action_success')) {
        cocoMessage.success(alert_action_success + _langJS.success);
        localStorage.removeItem('alert_action_success');
    }
})

/**
 * 初始化树形拖拽排序与折叠功能
 * @param {Object} options 配置参数
 * @param {string} options.tableSelector 表格选择器，如 '#dataTable'
 * @param {boolean} options.hasHierarchy 是否有父子层级关系
 * @param {string} options.storagePrefix 存储折叠状态的 localStorage 前缀，如有层级则必填
 */
function initTreeSortable(options) {
    const defaults = {
        tableSelector: '#dataTable',
        hasHierarchy: false,
        storagePrefix: 'em_folded_'
    };
    const config = Object.assign(defaults, options);
    const $tbody = $(config.tableSelector).find('tbody');

    if (config.hasHierarchy) {
        // 拖拽主项时连带子项一起移动，子项也支持在列表内上下排序
        $tbody.sortable({
            items: '> tr.tree-parent, > tr.tree-child',
            handle: '.drag-handle',
            /**
             * 拖拽开始回调函数
             */
            start: function(e, ui) {
                if (ui.item.hasClass('tree-parent')) {
                    var id = ui.item.data('id');
                    $tbody.find('.tree-child[data-pid="' + id + '"]').hide();
                }
            },
            /**
             * 拖拽结束后，处理主项连带移动，以及子项出界智能弹回纠偏，保持父子级物理顺序
             */
            stop: function(e, ui) {
                if (ui.item.hasClass('tree-parent')) {
                    var id = ui.item.data('id');
                    var children = $tbody.find('.tree-child[data-pid="' + id + '"]');
                    ui.item.after(children);
                    // 仅在主项未折叠的情况下显示子项
                    if (ui.item.attr('data-folded') !== 'true') {
                        children.show();
                    }
                } else if (ui.item.hasClass('tree-child')) {
                    var pid = ui.item.data('pid');
                    // 寻找拖拽放置后，其上方的第一个主项
                    var currentParent = ui.item.prevAll('.tree-parent').first();
                    var currentParentId = currentParent.data('id');

                    if (currentParentId !== pid) {
                        // 如果移出了原本父项的地盘，执行智能吸附纠偏
                        var realParent = $tbody.find('.tree-parent[data-id="' + pid + '"]');
                        if (ui.item.index() < realParent.index()) {
                            // 往上拖出界，移回父项正下方首位
                            realParent.after(ui.item);
                        } else {
                            // 往下拖出界，移回父项子列表末尾
                            var siblings = $tbody.find('.tree-child[data-pid="' + pid + '"]').not(ui.item);
                            if (siblings.length > 0) {
                                siblings.last().after(ui.item);
                            } else {
                                realParent.after(ui.item);
                            }
                        }
                    }
                }
            }
        }).disableSelection();

        /**
         * 主项折叠/展开点击事件
         */
        $(config.tableSelector).on('click', '.fold-btn', function() {
            var btn = $(this);
            var id = btn.data('id');
            var parentRow = btn.closest('.tree-parent');
            var children = $tbody.find('.tree-child[data-pid="' + id + '"]');
            var icon = btn.find('i');

            if (icon.hasClass('icofont-simple-down')) {
                // 折叠
                children.hide();
                icon.removeClass('icofont-simple-down').addClass('icofont-simple-right');
                parentRow.attr('data-folded', 'true');
                localStorage.setItem(config.storagePrefix + id, 'true');
            } else {
                // 展开
                children.show();
                icon.removeClass('icofont-simple-right').addClass('icofont-simple-down');
                parentRow.removeAttr('data-folded');
                localStorage.removeItem(config.storagePrefix + id);
            }
        });

        /**
         * 初始化各项的折叠状态
         */
        $(config.tableSelector).find('.fold-btn').each(function() {
            var btn = $(this);
            var id = btn.data('id');
            var parentRow = btn.closest('.tree-parent');
            var children = $tbody.find('.tree-child[data-pid="' + id + '"]');
            var icon = btn.find('i');

            if (localStorage.getItem(config.storagePrefix + id) === 'true') {
                children.hide();
                icon.removeClass('icofont-simple-down').addClass('icofont-simple-right');
                parentRow.attr('data-folded', 'true');
            }
        });
    } else {
        // 没有父子层级，仅执行常规的一级拖动排序
        $tbody.sortable({
            handle: '.drag-handle'
        }).disableSelection();
    }
}

/**
 * 计算文本字数（英文单词计为1字，汉字、标点符号、特殊字符每个计为1字，空白字符不计入）
 * @param {string} str 待统计的文本内容
 * @returns {number} 统计的字数
 */
function countWords(str) {
    if (!str) return 0;
    var matches = str.match(/[a-zA-Z0-9]+(?:[-'][a-zA-Z0-9]+)*|[^\s]/gu);
    return matches ? matches.length : 0;
}

/**
 * 更新编辑器字数展示
 * @param {string} content 编辑器 Markdown 内容
 * @param {string} [targetSelector='#editor-word-count-num'] 展示字数的目标元素选择器
 */
function updateWordCount(content, targetSelector) {
    var count = countWords(content);
    $(targetSelector || '#editor-word-count-num').text(count);
}

/**
 * 渲染侧边栏插件与模板更新红点提示
 */
function renderAppUpdateDots() {
    var hasPluginUpdate = localStorage.getItem('emlog_has_plugin_update') === '1';
    var hasTemplateUpdate = localStorage.getItem('emlog_has_template_update') === '1';

    var $pluMenu = $("#menu_category_ext .nav-link");
    if ($pluMenu.length) {
        if (hasPluginUpdate) {
            if ($pluMenu.find('.sidebar-update-dot').length === 0) {
                $pluMenu.find('span').append('<i class="sidebar-update-dot"></i>');
            }
        } else {
            $pluMenu.find('.sidebar-update-dot').remove();
        }
    }

    var $tplMenu = $("#menu_tpl");
    var $viewMenu = $("#menu_category_view > .nav-link");
    var isViewExpanded = $('#menu_view').hasClass('show') || ($viewMenu.length && !$viewMenu.hasClass('collapsed')) || ($tplMenu.is(':visible'));

    if (hasTemplateUpdate) {
        if ($tplMenu.length && $tplMenu.find('.sidebar-update-dot').length === 0) {
            $tplMenu.append('<i class="sidebar-update-dot"></i>');
        }
        if ($viewMenu.length && $viewMenu.find('.sidebar-update-dot').length === 0) {
            $viewMenu.find('span').append('<i class="sidebar-update-dot"></i>');
        }
        // 外观与模板无论何时都不要同时展示红点：只要外观处于展开状态或模板子菜单可见，就隐藏外观主菜单上的红点
        if (isViewExpanded) {
            $viewMenu.find('.sidebar-update-dot').hide();
        } else {
            $viewMenu.find('.sidebar-update-dot').show();
        }
    } else {
        if ($tplMenu.length) {
            $tplMenu.find('.sidebar-update-dot').remove();
        }
        if ($viewMenu.length) {
            $viewMenu.find('.sidebar-update-dot').remove();
        }
    }
}

$(document).ready(function () {
    renderAppUpdateDots();

    // 监听外观折叠菜单的展开与收起，展开时只展示在模板上，收起时恢复外观上的提示（确保二者绝不同时展示）
    $('#menu_view').on('show.bs.collapse shown.bs.collapse', function () {
        $('#menu_category_view > .nav-link .sidebar-update-dot').hide();
    }).on('hide.bs.collapse hidden.bs.collapse', function () {
        if (localStorage.getItem('emlog_has_template_update') === '1') {
            $('#menu_category_view > .nav-link .sidebar-update-dot').show();
        }
    });

    // 监听文章折叠菜单的展开与收起，展开时只展示在子菜单文章上，收起时恢复主菜单上的提示（确保二者绝不同时展示）
    var $contentMenu = $('#menu_category_content > .nav-link');
    var isContentExpanded = $('#menu_content').hasClass('show') || ($contentMenu.length && !$contentMenu.hasClass('collapsed')) || ($('#menu_log').is(':visible'));
    if (isContentExpanded) {
        $contentMenu.find('.sidebar-update-dot').hide();
    }
    $('#menu_content').on('show.bs.collapse shown.bs.collapse', function () {
        $('#menu_category_content > .nav-link .sidebar-update-dot').hide();
    }).on('hide.bs.collapse hidden.bs.collapse', function () {
        $('#menu_category_content > .nav-link .sidebar-update-dot').show();
    });
});


