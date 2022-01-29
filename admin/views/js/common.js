function getChecked(node) {
    var re = false;
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
    switch (property) {
        case 'tw':
            var urlreturn = "twitter.php?action=del&id=" + id;
/*vot*/     var msg = lang('twitter_del_sure');
            break;
        case 'comment':
            var urlreturn = "comment.php?action=del&id=" + id;
/*vot*/     var msg = lang('comment_del_sure');
            break;
        case 'commentbyip':
            var urlreturn = "comment.php?action=delbyip&ip=" + id;
/*vot*/     var msg = lang('comment_ip_del_sure');
            break;
        case 'link':
            var urlreturn = "link.php?action=dellink&linkid=" + id;
/*vot*/     var msg = lang('link_del_sure');
            break;
        case 'navi':
            var urlreturn = "navbar.php?action=del&id=" + id;
/*vot*/     var msg = lang('navi_del_sure');
            break;
        case 'media':
            var urlreturn = "media.php?action=delete&aid=" + id;
/*vot*/     var msg = lang('attach_del_sure');
            break;
        case 'avatar':
            var urlreturn = "blogger.php?action=delicon";
/*vot*/     var msg = lang('avatar_del_sure');
            break;
        case 'sort':
            var urlreturn = "sort.php?action=del&sid=" + id;
/*vot*/     var msg = lang('category_del_sure');
            break;
        case 'user':
            var urlreturn = "user.php?action=del&uid=" + id;
/*vot*/     var msg = lang('user_del_sure');
            break;
        case 'tpl':
            var urlreturn = "template.php?action=del&tpl=" + id;
/*vot*/     var msg = lang('template_del_sure');
            break;
        case 'reset_widget':
            var urlreturn = "widgets.php?action=reset";
/*vot*/     var msg = lang('plugin_reset_sure');
            break;
        case 'plu':
            var urlreturn = "plugin.php?action=del&plugin=" + id;
/*vot*/     var msg = lang('plugin_del_sure');
            break;
    }
    if (confirm(msg)) {
        window.location = urlreturn + "&token=" + token;
    } else {
        return;
    }
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

function displayToggle(id, keep) {
    $("#" + id).toggleClass(id + "_hidden");
    icon_tog ? $(".icofont-simple-right").attr("class", "icofont-simple-down") : $(".icofont-simple-down").attr("class", "icofont-simple-right");
    icon_tog = !icon_tog;
    if (keep == 1) {
        Cookies.set('em_' + id, $("#" + id).css('visibility'), {expires: 365})
    }
    if (keep == 2) {
        Cookies.set('em_' + id, $("#" + id).css('visibility'))
    }
}

function isalias(a) {
    var reg1 = /^[\u4e00-\u9fa5\w-]*$/;
    var reg2 = /^[\d]+$/;
    var reg3 = /^post(-\d+)?$/;
    if (!reg1.test(a)) {
        return 1;
    } else if (reg2.test(a)) {
        return 2;
    } else if (reg3.test(a)) {
        return 3;
    } else if (a == 't' || a == 'm' || a == 'admin') {
        return 4;
    } else {
        return 0;
    }
}
function checkform() {
    var a = $.trim($("#alias").val());
    var t = $.trim($("#title").val());

    if(typeof articleTextRecord !== "undefined"){  // 提交时，重置原文本记录值，防止出现离开提示
        articleTextRecord = $("textarea[name=logcontent]").text();
    }else{
        pageText = $("textarea").text();
    }
    if (0 == isalias(a)) {
        return true;
    } else {
/*vot*/ alert(lang('alias_link_error'));
        $("#alias").focus();
        return false;
    }
}

function checkalias() {
    var a = $.trim($("#alias").val());
    if (1 == isalias(a)) {
/*vot*/ $("#alias_msg_hook").html('<span id="input_error">'+lang('alias_invalid_chars')+'</span>');
    } else if (2 == isalias(a)) {
/*vot*/ $("#alias_msg_hook").html('<span id="input_error">'+lang('alias_digital')+'</span>');
    } else if (3 == isalias(a)) {
/*vot*/ $("#alias_msg_hook").html('<span id="input_error">'+lang('alias_format_must_be')+'</span>');
    } else if (4 == isalias(a)) {
/*vot*/ $("#alias_msg_hook").html('<span id="input_error">'+lang('alias_system_conflict')+'</span>');
    } else {
        $("#alias_msg_hook").html('');
        $("#msg").html('');
    }
}

function insert_media_img(fileurl, imgsrc) {
    Editor.insertValue('[![](' + imgsrc + ')](' + fileurl + ')\n\n');
}

function insert_media_video(fileurl) {
    Editor.insertValue('<video class=\"video-js\" controls preload=\"auto\" width=\"100%\" data-setup=\'{"aspectRatio":"16:9"}\'> <source src="' + fileurl + '" type=\'video/mp4\' > </video>');
}

function insert_media(fileurl, filename) {
    Editor.insertValue('[' + filename + '](' + fileurl + ')\n\n');
}

function insert_conver(imgsrc) {
    $('#cover_image').attr('src', imgsrc);
    $('#cover').val(imgsrc);
    $('#cover_rm').show();
}

// act: 1 auto save, 2 manual save: click save button to save
function autosave(act) {
    var nodeid = "as_logid";
    var timeout = 30000;
    var url = "article_save.php?action=autosave";
    var title = $.trim($("#title").val());
    var cover = $.trim($("#cover").val());
    var alias = $.trim($("#alias").val());
    var sort = $.trim($("#sort").val());
    var postdate = $.trim($("#postdate").val());
    var date = $.trim($("#date").val());
    var logid = $("#as_logid").val();
    var author = $("#author").val();
    var content = Editor.getMarkdown();
    var excerpt = Editor_summary.getMarkdown();
    var tag = $.trim($("#tag").val());
    var top = $("#top").is(":checked") ? 'y' : 'n';
    var sortop = $("#sortop").is(":checked") ? 'y' : 'n';
    var allow_remark = $("#allow_remark").is(":checked") ? 'y' : 'n';
    var password = $.trim($("#password").val());
    var ishide = $.trim($("#ishide").val());
    var token = $.trim($("#token").val());
    var ishide = ishide == "" ? "y" : ishide;
    var querystr = "logcontent=" + encodeURIComponent(content)
        + "&logexcerpt=" + encodeURIComponent(excerpt)
        + "&title=" + encodeURIComponent(title)
        + "&cover=" + encodeURIComponent(cover)
        + "&alias=" + encodeURIComponent(alias)
        + "&author=" + author
        + "&sort=" + sort
        + "&postdate=" + postdate
        + "&date=" + date
        + "&tag=" + encodeURIComponent(tag)
        + "&top=" + top
        + "&sortop=" + sortop
        + "&allow_remark=" + allow_remark
        + "&password=" + password
        + "&token=" + token
        + "&ishide=" + ishide
        + "&as_logid=" + logid;

    // check alias
    if (alias != '' && 0 != isalias(alias)) {
/*vot*/ $("#msg").show().html(lang('alias_link_error_not_saved'));
        if (act == 0) {
            setTimeout("autosave(1)", timeout);
        }
        return;
    }
    // Do not automatically save when editing published article
    if (act == 1 && ishide == 'n') {
        return;
    }
    // Do not save automatically when the content is empty 
    if (act == 1 && content == "") {
        setTimeout("autosave(1)", timeout);
        return;
    }
    // 距离上次保存成功时间小于一秒时不允许手动保存
    if((new Date().getTime() - Cookies.get('em_saveLastTime')) < 1000 && act != 1){
        alert("请勿频繁操作！");
        return;
    }
    var btname = $("#savedf").val();
/*vot*/ $("#savedf").val(lang('saving'));
    $('title').text('[保存中] ' + titleText);
    $("#savedf").attr("disabled", "disabled");
    $.post(url, querystr, function (data) {
        data = $.trim(data);
        var isresponse = /autosave\_gid\:\d+\_df\:\d*\_/;
        if (isresponse.test(data)) {
            var getvar = data.match(/\_gid\:([\d]+)\_df\:([\d]*)\_/);
            var logid = getvar[1];
            var d = new Date();
            var h = d.getHours();
            var m = d.getMinutes();
            var s = d.getSeconds();
            var tm = (h < 10 ? "0" + h : h) + ":" + (m < 10 ? "0" + m : m) + ":" + (s < 10 ? "0" + s : s);
/*vot*/     $("#save_info").html(lang('saved_ok_time')+ tm);
            $('title').text('[保存成功] ' + titleText);
            articleTextRecord = $("textarea[name=logcontent]").text();  // 保存成功后，将原文本记录值替换为现在的文本
            Cookies.set('em_saveLastTime',new Date().getTime());  // 把保存成功时间戳记录（或更新）到 cookie 中
            $("#" + nodeid).val(logid);
            $("#savedf").attr("disabled", false).val(btname);
        } else {
            $("#savedf").attr("disabled", false).val(btname);
/*vot*/     $("#msg").html(lang('save_system_error')).addClass("alert-danger");
            $('title').text('[保存失败] ' + titleText);
        }
    });
    if (act == 1) {
        setTimeout("autosave(1)", timeout);
    }
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

// Filter HTML tags
function removeHTMLTag(str) {
/*vot*/ str = str.replace(/<\/?[^>]*>/g, ''); //Remove HTML tags
/*vot*/ str = str.replace(/[ | ]*\n/g, '\n'); //Trim white spaces
    str = str.replace(/ /ig, '');
    return str;
}

// Select all forms
$(function () {
    $('#checkAll').click(function (event) {
        let tr_checkbox = $('table tbody tr').find('input[type=checkbox]');
        tr_checkbox.prop('checked', $(this).prop('checked'));
        event.stopPropagation();
    });
    // Click on the checkbox in each row of the table, and when the number of checkboxes selected in the table = the number of table rows, set the "checkAll" radio box in the header of the table to be selected, otherwise it is unselected
    $('table tbody tr').find('input[type=checkbox]').click(function (event) {
        let tbr = $('table tbody tr');
        $('#checkAll').prop('checked', tbr.find('input[type=checkbox]:checked').length == tbr.length ? true : false);
        event.stopPropagation();
    });
});

// Select all cards
$(function () {
    $('#checkAllCard').click(function (event) {
        let card_checkbox = $('.card-body').find('input[type=checkbox]');
        card_checkbox.prop('checked', $(this).prop('checked'));
        event.stopPropagation();
    });
    $('.card-body').find('input[type=checkbox]').click(function (event) {
        let cards = $('.card-body');
        $('#checkAllCard').prop('checked', cards.find('input[type=checkbox]:checked').length == cards.length ? true : false);
        event.stopPropagation();
    });
});

// editor.md js hook
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
function imgPasteExpand(thisEditor){
    var listenObj    = document.querySelector("textarea").parentNode  // 要监听的对象
    var postUrl      = './media.php?action=upload';  // emlog 的图片上传地址
    var emMediaPhpUrl= "./media.php?action=lib";  // emlog 的资源库地址,用于异步获取上传后的图片数据

    // 通过动态配置只读模式,阻止编辑器原有的粘贴动作发生,并恢复光标位置
    function preventEditorPaste(){
        let l = thisEditor.getCursor().line;
        let c = thisEditor.getCursor().ch - 3;

        thisEditor.config({ readOnly: true, });
        thisEditor.config({ readOnly: false,});
        thisEditor.setCursor({line:l, ch:c});

        let saveHotKey = {  // 编辑器的 bug , 界面刷新后会删除自定义的热键，所以要重新设置
            "Ctrl-S": function (cm) {
                autosave(2);
            },
            "Cmd-S": function (cm) {
                autosave(2);
            }
        };
        thisEditor.addKeyMap(saveHotKey);
    }

    // 编辑器通过光标处位置前几位来替换文字
    function replaceByNum(text,num){
        let l = thisEditor.getCursor().line;
        let c = thisEditor.getCursor().ch;

        thisEditor.setSelection({line:l, ch:(c - num)}, {line:l, ch:c});
        thisEditor.replaceSelection(text);
    }

    // 粘贴事件触发
    listenObj.addEventListener("paste", function (e) {
        if ($('.editormd-mask').css('display') == 'block') return;  // 如果编辑器有对话框则退出
        if ( !(e.clipboardData && e.clipboardData.items) ) return;

        var pasteData = e.clipboardData || window.clipboardData; // 获取剪切板里的全部内容
        pasteAnalyseResult = new Array;  // 用于储存遍历分析后的结果

        for(var i = 0; i < pasteData.items.length; i++) {  // 遍历分析剪切板里的数据
            var item = pasteData.items[i];

            if((item.kind == "file") && (item.type.match('^image/'))){
                var imgData = item.getAsFile();
                if (imgData.size === 0) return;
                pasteAnalyseResult['type'] = 'img';
                pasteAnalyseResult['data'] = imgData;
                break;  // 当粘贴板中有图片存在时,跳出循环
            };
        }

        if(pasteAnalyseResult['type'] == 'img') {  // 如果剪切板中有图片,上传图片
            preventEditorPaste();
            uploadImg(pasteAnalyseResult['data']);
            return;
        } 
    }, false);

    // 上传图片
    function uploadImg(img){
        var formData = new FormData();
        var imgName="粘贴上传"+new Date().getTime()+"."+img.name.split(".").pop();

        formData.append('file', img, imgName);
        thisEditor.insertValue("上传中...");
        $.ajax({
            url: postUrl,
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() { 
                var xhr = $.ajaxSettings.xhr();
                if (xhr.upload) {
                    thisEditor.insertValue("....");
                    xhr.upload.addEventListener('progress', function(e) {  // 用以显示上传进度  
                        console.log('进度(byte)：' + e.loaded + ' / ' + e.total);
                        let percent = Math.floor(e.loaded / e.total * 100);
                        if(percent < 10){
                            replaceByNum('..'+percent+'%',4);
                        }else if(percent < 100){
                            replaceByNum('.'+percent+'%',4);
                        }else{
                            replaceByNum(percent+'%',4);
                        }
                    }, false);
                }
                return xhr;
            },
            success:function(result){
                if(result == 'success'){
                    let imgUrl, thumbImgUrl;
                    console.log('上传成功！正在获取结果...');
                    $.get(emMediaPhpUrl,function(data){  // 异步获取结果,追加到编辑器
                        console.log('获取结果成功！');
                        imgUrl = data.match(/(?<=href\=\").*?(?=\"\s)/)[0];
                        thumbImgUrl = data.match(/(?<=src\=\").*?(?=\")/)[0];
                        replaceByNum(`[![](${imgUrl})](${thumbImgUrl})`,10);  // 这里的数字 10 对应着’上传中...100%‘是10个字符
                    })
                }else{
                    alert('未知错误');
                    replaceByNum('未知错误',6);
                }
            },
            error:function(result){
                alert('上传失败,图片类型错误或网络错误');
                replaceByNum('上传失败,图片类型错误或网络错误',6);
            }
        })
    }
}

// 把粘贴上传图片函数，挂载到位于文章编辑器、页面编辑器处的 js 钩子处
hooks.addAction("loaded", imgPasteExpand);
hooks.addAction("page_loaded", imgPasteExpand);
