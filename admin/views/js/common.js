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

function em_confirm(id, property, token) {
    let url;
    let msg = '';
    let text = ''
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
        case 'media':
            url = 'media.php?action=delete&aid=' + id;
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

// 把粘贴上传图片函数，挂载到位于文章编辑器、页面编辑器处的 js 钩子处
hooks.addAction("loaded", imgPasteExpand);
hooks.addAction("page_loaded", imgPasteExpand);

function checkUpdate() {
    const updateModal = $("#update-modal");
    const updateModalLoading = $("#update-modal-loading");
    const updateModalMsg = $("#update-modal-msg");
    const updateModalChanges = $("#update-modal-changes");
    const updateModalBtn = $("#update-modal-btn");

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

    $.get(`./upgrade.php?action=update&source=${source}&upsql=${upSQL}`, function (data) {
        upmsg.removeClass();
        if (data.includes("succ")) {
            upbtn.text(_langJS.refresh_page);
            upbtn.attr('href', './');
            updateModalMsg.html(_langJS.update_success_html);
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

function initShortcutBar() {
    var $bar = $('#shortcut-bar-container');
    var $content = $('#shortcut-bar-content');
    $bar.hover(
        function() {
            $content.css('width', '800px');
        },
        function() {
            $content.css('width', '0');
        }
    );
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
        link.text('安装中…');
        link.parent().prev(".installMsg").html("").addClass("spinner-border text-primary");
    
        let url = './store.php?action=install&type=' + type + '&source=' + down_url;
        $.get(url, function (data) {
            link.text('安装');
            if (data.code === 0) {
                cocoMessage.success(data.msg, 8000);
            } else {
                cocoMessage.error(data.msg, 8000);
            }
            link.parent().prev(".installMsg").removeClass("spinner-border text-primary");
        }, 'json');
    });

    // 应用商店：查看应用信息
    $('#appModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var name = button.data('name');
        var url = button.data('url');
        var buy_url = button.data('buy-url');
        var modal = $(this);

        modal.find('.modal-body').empty();
        modal.find('.modal-title').html(name);
        modal.find('.modal-buy-url').attr('href', buy_url);

        var loadingSpinner = '<div class="spinner-border text-primary ml-3"><span class="sr-only">Loading...</span></div>';
        modal.find('.modal-title').append(loadingSpinner);

        var iframe = $('<iframe>', {
            'class': 'iframe-content',
            'src': url,
            'frameborder': 0
        });

        iframe.on('load', function () {
            $('.spinner-border').remove();
        });

        modal.find('.modal-body').append(iframe);
    });

    // 删除提示
    const alert_action_success = localStorage.getItem('alert_action_success')
    if (localStorage.getItem('alert_action_success')) {
        cocoMessage.success(alert_action_success + '成功');
        localStorage.removeItem('alert_action_success');
    }
})
