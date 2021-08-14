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
    $(".alert-success").hide();
    $(".alert-danger").hide();
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

function insert_media(fileurl, filename) {
    Editor.insertValue('[' + filename + '](' + fileurl + ')\n\n');
}

// act: 1 auto save, 2 manual save: click save button to save
function autosave(act) {
    var nodeid = "as_logid";
    var timeout = 30000;
    var url = "article_save.php?action=autosave";
    var title = $.trim($("#title").val());
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

    //check alias
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

    var btname = $("#savedf").val();
/*vot*/ $("#savedf").val(lang('saving'));
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
/*vot*/     $("#save_info").html(lang('saved_ok_time') + tm);
            $("#" + nodeid).val(logid);
            $("#savedf").attr("disabled", false).val(btname);
        } else {
            $("#savedf").attr("disabled", false).val(btname);
/*vot*/     $("#msg").html(lang('save_system_error')).addClass("alert-danger");
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

//Filter HTML tags
function removeHTMLTag(str) {
/*vot*/ str = str.replace(/<\/?[^>]*>/g, ''); //Remove HTML tags
/*vot*/ str = str.replace(/[ | ]*\n/g, '\n'); //Trim white spaces
    str = str.replace(/ /ig, '');
    return str;
}

// Select all forms
$(function () {
    $('#checkAll').click(function (event) {
        var tr_checkbox = $('table tbody tr').find('input[type=checkbox]');
        tr_checkbox.prop('checked', $(this).prop('checked'));
        event.stopPropagation();
    });
    // Click on the checkbox in each row of the table, and when the number of checkboxes selected in the table = the number of table rows, set the "checkAll" radio box in the header of the table to be selected, otherwise it is unselected
    $('table tbody tr').find('input[type=checkbox]').click(function (event) {
        var tbr = $('table tbody tr');
        $('#checkAll').prop('checked', tbr.find('input[type=checkbox]:checked').length == tbr.length ? true : false);
        event.stopPropagation();
    });
});

// editor.md的js钩子
var queue = new Array();
var hooks = {
    addAction: function(hook, func) {      
        if (typeof(queue[hook])=="undefined"||queue[hook] == null){
            queue[hook] = new Array();
        }        
        if (typeof func == 'function') {
            queue[hook].push(func);
        }
   },
   doAction: function(hook,obj) {
        try{
            for(var i=0; i < queue[hook].length; i++) {
                queue[hook][i](obj);
            }
        }catch(e) {}
    }
}

