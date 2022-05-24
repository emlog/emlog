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
    let url, msg;
    switch (property) {
        case 'tw':
            url = 'twitter.php?action=del&id=' + id;
/*vot*/     msg = lang('twitter_del_sure');
            break;
        case 'comment':
            url = 'comment.php?action=del&id=' + id;
/*vot*/     msg = lang('comment_del_sure');
            break;
        case 'commentbyip':
            url = 'comment.php?action=delbyip&ip=' + id;
/*vot*/     msg = lang('comment_ip_del_sure');
            break;
        case 'link':
            url = 'link.php?action=dellink&linkid=' + id;
/*vot*/     msg = lang('link_del_sure');
            break;
        case 'navi':
            url = 'navbar.php?action=del&id=' + id;
/*vot*/     msg = lang('navi_del_sure');
            break;
        case 'media':
            url = 'media.php?action=delete&aid=' + id;
/*vot*/     msg = lang('attach_del_sure');
            break;
        case 'avatar':
            url = 'blogger.php?action=delicon';
/*vot*/     msg = lang('avatar_del_sure');
            break;
        case 'sort':
            url = 'sort.php?action=del&sid=' + id;
/*vot*/     msg = lang('category_del_sure');
            break;
        case 'del_user':
            url = 'user.php?action=del&uid=' + id;
/*vot*/     msg = lang('user_del_sure');
            break;
        case 'forbid_user':
            url = 'user.php?action=forbid&uid=' + id;
/*vot*/     msg = lang('user_disable_sure');
            break;
        case 'tpl':
            url = 'template.php?action=del&tpl=' + id;
/*vot*/     msg = lang('template_del_sure');
            break;
        case 'reset_widget':
            url = 'widgets.php?action=reset';
/*vot*/     msg = lang('plugin_reset_sure');
            break;
        case 'plu':
            url = 'plugin.php?action=del&plugin=' + id;
/*vot*/     msg = lang('plugin_del_sure');
            break;
    }
    if (confirm(msg)) {
        window.location = url + '&token=' + token;
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

    if (typeof articleTextRecord !== "undefined") {  // When submitting, reset the original text record value to prevent the leaving prompt from appearing
        articleTextRecord = $("textarea[name=logcontent]").text();
    } else {
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
    // Manual saving is not allowed when the last successful save time is less than one second
    if ((new Date().getTime() - Cookies.get('em_saveLastTime')) < 1000 && act != 1) {
/*vot*/ alert(lang('too_quick'));
        return;
    }
    var btname = $("#savedf").val();
/*vot*/ $("#savedf").val(lang('saving'));
/*vot*/ $('title').text(lang('saving_in') + titleText);
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
/*vot*/     $('title').text(lang('saved_ok') + titleText);
/*vot*/     articleTextRecord = $("textarea[name=logcontent]").text();  // After the save is successful, replace the original text record value with the current text
/*vot*/     Cookies.set('em_saveLastTime', new Date().getTime());  // Put (or update) the save success timestamp into a cookie
            $("#" + nodeid).val(logid);
            $("#savedf").attr("disabled", false).val(btname);
        } else {
            $("#savedf").attr("disabled", false).val(btname);
/*vot*/     $("#msg").html(lang('save_system_error')).addClass("alert-danger");
/*vot*/     $('title').text(lang('save_failed') + titleText);
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

// Paste upload image
function imgPasteExpand(thisEditor) {
    var listenObj = document.querySelector("textarea").parentNode  // Object to listen for
    var postUrl = './media.php?action=upload';  // emlog image upload address
    var emMediaPhpUrl = "./media.php?action=lib";  // The resource library address of emlog, which is used to asynchronously obtain the uploaded image data

    // By dynamically configuring the read-only mode, the original paste action of the editor is prevented and the cursor position is restored
    function preventEditorPaste() {
        let l = thisEditor.getCursor().line;
        let c = thisEditor.getCursor().ch - 3;

        thisEditor.config({readOnly: true,});
        thisEditor.config({readOnly: false,});
        thisEditor.setCursor({line: l, ch: c});

        let saveHotKey = {  // Editor bug , the custom hotkey will be deleted after the interface is refreshed, so it needs to be reset
            "Ctrl-S": function (cm) {
                autosave(2);
            },
            "Cmd-S": function (cm) {
                autosave(2);
            }
        };
        thisEditor.addKeyMap(saveHotKey);
    }

    // The editor replaces the text by the first few digits of the cursor position
    function replaceByNum(text, num) {
        let l = thisEditor.getCursor().line;
        let c = thisEditor.getCursor().ch;

        thisEditor.setSelection({line: l, ch: (c - num)}, {line: l, ch: c});
        thisEditor.replaceSelection(text);
    }

    // Paste event fires
    listenObj.addEventListener("paste", function (e) {
        if ($('.editormd-dialog').css('display') == 'block') return;  // Exit if editor has dialog
        if (!(e.clipboardData && e.clipboardData.items)) return;

        var pasteData = e.clipboardData || window.clipboardData; // Get the entire contents of the clipboard
        pasteAnalyseResult = new Array;  // Used to store the results of traversal analysis

        for(var i = 0; i < pasteData.items.length; i++) {  // Traverse the data in the analysis clipboard
            var item = pasteData.items[i];

            if ((item.kind == "file") && (item.type.match('^image/'))) {
                var imgData = item.getAsFile();
                if (imgData.size === 0) return;
                pasteAnalyseResult['type'] = 'img';
                pasteAnalyseResult['data'] = imgData;
                break;  // When there is a picture in the pasteboard, jump out of the loop
            }
            ;
        }

        if (pasteAnalyseResult['type'] == 'img') {  // If there is a picture in the clipboard, upload the picture
            preventEditorPaste();
            uploadImg(pasteAnalyseResult['data']);
            return;
        }
    }, false);

    // Upload image
    function uploadImg(img) {
        var formData = new FormData();
/*vot*/ var imgName = lang('paste_upload') + new Date().getTime() + "." + img.name.split(".").pop();

        formData.append('file', img, imgName);
/*vot*/ thisEditor.insertValue(lang('uploading'));
        $.ajax({
            url: postUrl,
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function () {
                var xhr = $.ajaxSettings.xhr();
                if (xhr.upload) {
                    thisEditor.insertValue("....");
                    xhr.upload.addEventListener('progress', function (e) {  // Show upload progress
/*vot*/                 console.log(lang('progress') + e.loaded + ' / ' + e.total);
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
            },
            success: function (result) {
                let imgUrl, thumbImgUrl;
/*vot*/         console.log(lang('upload_ok_get_result'));
                $.get(emMediaPhpUrl, function( data) {  // Get the result asynchronously, append to the editor
/*vot*/             console.log(lang('result_ok'));
                    imgUrl = data.match(/[a-zA-z]+:\/[^\s\"\']*/g)[0];
                    thumbImgUrl = data.match(/[a-zA-z]+:\/[^\s\"\']*/g)[1];
                        replaceByNum(`[![](${imgUrl})](${thumbImgUrl})`, 10);  // The number 10 here corresponds to 'Uploading...100%' which is 10 characters
                })
            },
            error: function (result) {
/*vot*/         alert(lang('upload_failed_error'));
/*vot*/         replaceByNum(lang('upload_failed_error'), 6);
            }
        })
    }
}

// Attach the paste upload image function to the js hook located in the article editor and page editor
hooks.addAction("loaded", imgPasteExpand);
hooks.addAction("page_loaded", imgPasteExpand);

// Setting interface, if you set "Automatic address detection", set input to read-only to indicate that this item is invalid
$(document).ready(function () {
    // Check the page after loading
    if ($("#detect_url").prop("checked")) {
        $("[name=blogurl]").attr("readonly", "readonly")
    }

    $("#detect_url").click(function () {
        if ($(this).prop("checked")) {
            $("[name=blogurl]").attr("readonly", "readonly")
        } else {
            $("[name=blogurl]").removeAttr("readonly")
        }
    })
})