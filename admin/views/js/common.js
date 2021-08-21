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
            var msg = "你确定要删除该评论吗？";
            break;
        case 'commentbyip':
            var urlreturn = "comment.php?action=delbyip&ip=" + id;
            var msg = "你确定要删除来自该IP的所有评论吗？";
            break;
        case 'link':
            var urlreturn = "link.php?action=dellink&linkid=" + id;
            var msg = "你确定要删除该链接吗？";
            break;
        case 'navi':
            var urlreturn = "navbar.php?action=del&id=" + id;
            var msg = "你确定要删除该导航吗？";
            break;
        case 'media':
            var urlreturn = "media.php?action=delete&aid=" + id;
            var msg = "你确定要删除该媒体文件吗？";
            break;
        case 'avatar':
            var urlreturn = "blogger.php?action=delicon";
            var msg = "你确定要删除头像吗？";
            break;
        case 'sort':
            var urlreturn = "sort.php?action=del&sid=" + id;
            var msg = "你确定要删除该分类吗？";
            break;
        case 'user':
            var urlreturn = "user.php?action=del&uid=" + id;
            var msg = "你确定要删除该用户吗？";
            break;
        case 'tpl':
            var urlreturn = "template.php?action=del&tpl=" + id;
            var msg = "你确定要删除该模板吗？";
            break;
        case 'reset_widget':
            var urlreturn = "widgets.php?action=reset";
            var msg = "你确定要恢复组件设置到初始状态吗？这样会丢失你自定义的组件。";
            break;
        case 'plu':
            var urlreturn = "plugin.php?action=del&plugin=" + id;
            var msg = "你确定要删除该插件吗？";
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
        alert("链接别名错误");
        $("#alias").focus();
        return false;
    }
}

function checkalias() {
    var a = $.trim($("#alias").val());
    if (1 == isalias(a)) {
        $("#alias_msg_hook").html('<span id="input_error">别名错误，应由字母、数字、下划线、短横线组成</span>');
    } else if (2 == isalias(a)) {
        $("#alias_msg_hook").html('<span id="input_error">别名错误，不能为纯数字</span>');
    } else if (3 == isalias(a)) {
        $("#alias_msg_hook").html('<span id="input_error">别名错误，不能为\'post\'或\'post-数字\'</span>');
    } else if (4 == isalias(a)) {
        $("#alias_msg_hook").html('<span id="input_error">别名错误，与系统链接冲突</span>');
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

// act: 1 auto save, 2 manual save：click save button to save,
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

    // 检查别名
    if (alias != '' && 0 != isalias(alias)) {
        $("#msg").show().html("链接别名错误，自动保存失败");
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

    var btname = $("#savedf").val();
    $("#savedf").val("正在保存中...");
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
            $("#save_info").html("保存于：" + tm);
            $("#" + nodeid).val(logid);
            $("#savedf").attr("disabled", false).val(btname);
        } else {
            $("#savedf").attr("disabled", false).val(btname);
            $("#msg").html("网络或系统出现异常...保存可能失败").addClass("alert-danger");
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

// 过滤HTML标签
function removeHTMLTag(str) {
    str = str.replace(/<\/?[^>]*>/g, ''); //去除HTML tag
    str = str.replace(/[ | ]*\n/g, '\n'); //去除行尾空白
    str = str.replace(/ /ig, '');
    return str;
}

// 表格全选
$(function () {
    $('#checkAll').click(function (event) {
        var tr_checkbox = $('table tbody tr').find('input[type=checkbox]');
        tr_checkbox.prop('checked', $(this).prop('checked'));
        event.stopPropagation();
    });
    // 点击表格每一行的checkbox，表格所有选中的checkbox数 = 表格行数时，则将表头的‘checkAll’单选框置为选中，否则置为未选中
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

