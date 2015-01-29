$(function() {
    $('#side-menu').metisMenu();
});
//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse')
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse')
        }

        height = (this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    })
})
/*
 * metismenu - v1.0.3
 * Easy menu jQuery plugin for Twitter Bootstrap 3
 * https://github.com/onokumus/metisMenu
 *
 * Made by Osman Nuri Okumuş
 * Under MIT License
 */
;(function ($, window, document, undefined) {

    var pluginName = "metisMenu",
        defaults = {
            toggle: true
        };
        
    function Plugin(element, options) {
        this.element = element;
        this.settings = $.extend({}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    Plugin.prototype = {
        init: function () {

            var $this = $(this.element),
                $toggle = this.settings.toggle;

            if (this.isIE() <= 9) {
                $this.find("li.active").has("ul").children("ul").collapse("show");
                $this.find("li").not(".active").has("ul").children("ul").collapse("hide");
            } else {
                $this.find("li.active").has("ul").children("ul").addClass("collapse in");
                $this.find("li").not(".active").has("ul").children("ul").addClass("collapse");
            }

            $this.find("li").has("ul").children("a").on("click", function (e) {
                e.preventDefault();

                $(this).parent("li").toggleClass("active").children("ul").collapse("toggle");

                if ($toggle) {
                    $(this).parent("li").siblings().removeClass("active").children("ul.in").collapse("hide");
                }
            });
        },

        isIE: function() {//https://gist.github.com/padolsey/527683
            var undef,
                v = 3,
                div = document.createElement("div"),
                all = div.getElementsByTagName("i");

            while (
                div.innerHTML = "<!--[if gt IE " + (++v) + "]><i></i><![endif]-->",
                all[0]
            ) {
                return v > 4 ? v : undef;
            }
        }
    };

    $.fn[ pluginName ] = function (options) {
        return this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName, new Plugin(this, options));
            }
        });
    };

})(jQuery, window, document);

function getChecked(node) {
    var re = false;
    $('input.'+node).each(function(i){
        if (this.checked) {
            re = true;
        }
    });
    return re;
}
function timestamp(){
    return new Date().getTime();
}
function em_confirm (id, property, token) {
    switch (property){
        case 'tw':
            var urlreturn="twitter.php?action=del&id="+id;
            var msg = "你确定要删除该条微语吗？";break;
        case 'comment':
            var urlreturn="comment.php?action=del&id="+id;
            var msg = "你确定要删除该评论吗？";break;
        case 'commentbyip':
            var urlreturn="comment.php?action=delbyip&ip="+id;
            var msg = "你确定要删除来自该IP的所有评论吗？";break;
        case 'link':
            var urlreturn="link.php?action=dellink&linkid="+id;
            var msg = "你确定要删除该链接吗？";break;
        case 'navi':
            var urlreturn="navbar.php?action=del&id="+id;
            var msg = "你确定要删除该导航吗？";break;
        case 'backup':
            var urlreturn="data.php?action=renewdata&sqlfile="+id;
            var msg = "你确定要导入该备份文件吗？";break;
        case 'attachment':
            var urlreturn="attachment.php?action=del_attach&aid="+id;
            var msg = "你确定要删除该附件吗？";break;
        case 'avatar':
            var urlreturn="blogger.php?action=delicon";
            var msg = "你确定要删除头像吗？";break;
        case 'sort':
            var urlreturn="sort.php?action=del&sid="+id;
            var msg = "你确定要删除该分类吗？";break;
        case 'page':
            var urlreturn="page.php?action=del&gid="+id;
            var msg = "你确定要删除该页面吗？";break;
        case 'user':
            var urlreturn="user.php?action=del&uid="+id;
            var msg = "你确定要删除该用户吗？";break;
        case 'tpl':
            var urlreturn="template.php?action=del&tpl="+id;
            var msg = "你确定要删除该模板吗？";break;
        case 'reset_widget':
            var urlreturn="widgets.php?action=reset";
            var msg = "你确定要恢复组件设置到初始状态吗？这样会丢失你自定义的组件。";break;
        case 'plu':
            var urlreturn="plugin.php?action=del&plugin="+id;
            var msg = "你确定要删除该插件吗？";break;
    }
    if(confirm(msg)){window.location = urlreturn + "&token="+token;}else {return;}
}
function focusEle(id){try{document.getElementById(id).focus();}catch(e){}}
function hideActived(){
    $(".alert-success").hide();
    $(".alert-danger").hide();
    //$(".error").hide();
}
function displayToggle(id, keep){
    $("#"+id).toggle();
    if (keep == 1){$.cookie('em_'+id,$("#"+id).css('display'),{expires:365});}
    if (keep == 2){$.cookie('em_'+id,$("#"+id).css('display'));}
}
function isalias(a){
    var reg1=/^[\u4e00-\u9fa5\w-]*$/;
    var reg2=/^[\d]+$/;
    var reg3=/^post(-\d+)?$/;
    if(!reg1.test(a)) {
        return 1;
    }else if(reg2.test(a)){
        return 2;
    }else if(reg3.test(a)){
        return 3;
    }else if(a=='t' || a=='m' || a=='admin'){
        return 4;
    } else {
        return 0;
    }
}
function checkform(){
    var a = $.trim($("#alias").val());
    var t = $.trim($("#title").val());
    if (t==""){
        alert("标题不能为空");
        $("#title").focus();
        return false;
    }else if(0 == isalias(a)){
        return true;
    }else {
        alert("链接别名错误");
        $("#alias").focus();
        return false
    };
}
function checkalias(){
    var a = $.trim($("#alias").val());
    if (1 == isalias(a)){
        $("#alias_msg_hook").html('<span id="input_error">别名错误，应由字母、数字、下划线、短横线组成</span>');
    }else if (2 == isalias(a)){
        $("#alias_msg_hook").html('<span id="input_error">别名错误，不能为纯数字</span>');
    }else if (3 == isalias(a)){
        $("#alias_msg_hook").html('<span id="input_error">别名错误，不能为\'post\'或\'post-数字\'</span>');
    }else if (4 == isalias(a)){
        $("#alias_msg_hook").html('<span id="input_error">别名错误，与系统链接冲突</span>');
    }else {
        $("#alias_msg_hook").html('');
        $("#msg").html('');
    }
}
function addattach_img(fileurl,imgsrc,aid, width, height, alt){
    if (editorMap['content'].designMode === false){
        alert('请先切换到所见所得模式');
    }else if (imgsrc != "") {
        editorMap['content'].insertHtml('<a target=\"_blank\" href=\"'+fileurl+'\" id=\"ematt:'+aid+'\"><img src=\"'+imgsrc+'\" title="点击查看原图" alt=\"'+alt+'\" border=\"0\" width="'+width+'" height="'+height+'"/></a>');
    }
}
function addattach_file(fileurl,filename,aid){
    if (editorMap['content'].designMode === false){
        alert('请先切换到所见所得模式');
    } else {
        editorMap['content'].insertHtml('<span class=\"attachment\"><a target=\"_blank\" href=\"'+fileurl+'\" >'+filename+'</a></span>');
    }
}
function insertTag (tag, boxId){
    var targetinput = $("#"+boxId).val();
    if(targetinput == ''){
        targetinput += tag;
    }else{
        var n = ',' + tag;
        targetinput += n;
    }
    $("#"+boxId).val(targetinput);
    if (boxId == "tag")
        $("#tag_label").hide();
}
//act:0 auto save,1 click attupload,2 click savedf button, 3 save page, 4 click page attupload
function autosave(act){
    var nodeid = "as_logid";
    if (act == 3 || act == 4){
        editorMap['content'].sync();
        var url = "page.php?action=autosave";
        var title = $.trim($("#title").val());
        var alias = $.trim($("#alias").val());
        var template = $.trim($("#template").val());
        var logid = $("#as_logid").val();
        var content = $('#content').val();
        var pageurl = $.trim($("#url").val());
        var allow_remark = $("#page_options #allow_remark").attr("checked") == 'checked' ? 'y' : 'n';
        var is_blank = $("#page_options #is_blank").attr("checked") == 'checked' ? 'y' : 'n';
        var token = $.trim($("#token").val());
        var ishide = $.trim($("#ishide").val());
        var ishide = ishide == "" ? "y" : ishide;
        var querystr = "content="+encodeURIComponent(content)
                    +"&title="+encodeURIComponent(title)
                    +"&alias="+encodeURIComponent(alias)
                    +"&template="+encodeURIComponent(template)
                    +"&allow_remark="+allow_remark
                    +"&is_blank="+is_blank
                    +"&url="+pageurl
                    +"&token="+token
                    +"&ishide="+ishide
                    +"&as_logid="+logid;
    }else{
        editorMap['content'].sync();
        editorMap['excerpt'].sync();
        var url = "save_log.php?action=autosave";
        var title = $.trim($("#title").val());
        var alias = $.trim($("#alias").val());
        var sort = $.trim($("#sort").val());
        var postdate = $.trim($("#postdate").val());
        var date = $.trim($("#date").val());
        var logid = $("#as_logid").val();
        var author = $("#author").val();
        var content = $('#content').val();
        var excerpt = $('#excerpt').val();
        var tag = $.trim($("#tag").val());
        var top = $("#post_options #top").attr("checked") == 'checked' ? 'y' : 'n';
        var sortop = $("#post_options #sortop").attr("checked") == 'checked' ? 'y' : 'n';
        var allow_remark = $("#post_options #allow_remark").attr("checked") == 'checked' ? 'y' : 'n';
        var allow_tb = $("#post_options #allow_tb").attr("checked") == 'checked' ? 'y' : 'n';
        var password = $.trim($("#password").val());
        var ishide = $.trim($("#ishide").val());
        var token = $.trim($("#token").val());
        var ishide = ishide == "" ? "y" : ishide;
        var querystr = "content="+encodeURIComponent(content)
                    +"&excerpt="+encodeURIComponent(excerpt)
                    +"&title="+encodeURIComponent(title)
                    +"&alias="+encodeURIComponent(alias)
                    +"&author="+author
                    +"&sort="+sort
                    +"&postdate="+postdate
                    +"&date="+date
                    +"&tag="+encodeURIComponent(tag)
                    +"&top="+top
                    +"&sortop="+sortop
                    +"&allow_remark="+allow_remark
                    +"&allow_tb="+allow_tb
                    +"&password="+password
                    +"&token="+token
                    +"&ishide="+ishide
                    +"&as_logid="+logid;
    }
    //check alias
    if(alias != '') {
        if (0 != isalias(alias)){
            $("#msg").html("<span class=\"msg_autosave_error\">链接别名错误，自动保存失败</span>");
            if(act == 0){setTimeout("autosave(0)",60000);}
            return;
        }
    }
    if(act == 0){
        if(ishide == 'n'){return;}
        if (content == ""){
            setTimeout("autosave(0)",60000);
            return;
        }
    }
    if(act == 1 || act == 4){
        var gid = $("#"+nodeid).val();
        if (gid != -1){return;}
    }
    $("#msg").html("<span class=\"msg_autosave_do\">正在保存...</span>");
    var btname = $("#savedf").val();
    $("#savedf").val("正在保存");
    $("#savedf").attr("disabled", "disabled");
    $.post(url, querystr, function(data){
        data = $.trim(data);
        var isrespone=/autosave\_gid\:\d+\_df\:\d*\_/;
        if(isrespone.test(data)){
            var getvar = data.match(/\_gid\:([\d]+)\_df\:([\d]*)\_/);
            var logid = getvar[1];
            if (act == 0 || act == 1 || act == 2){
                var dfnum = getvar[2];
                if(dfnum > 0){$("#dfnum").html("("+dfnum+")")};
            }
            $("#"+nodeid).val(logid);
            var digital = new Date();
            var hours = digital.getHours();
            var mins = digital.getMinutes();
            var secs = digital.getSeconds();
            $("#msg_2").html("<span class=\"ajax_remind_1\">成功保存于 "+hours+":"+mins+":"+secs+" </span>");
            $("#savedf").attr("disabled", false);
            $("#savedf").val(btname);
            $("#msg").html("");
        }else{
            $("#savedf").attr("disabled", false);
            $("#savedf").val(btname);
            $("#msg").html("<span class=\"msg_autosave_error\">网络或系统出现异常...保存可能失败</span>");
        }
    });
    if(act == 0){
        setTimeout("autosave(0)",60000);
    }
}
//toggle plugin
$.fn.toggleClick = function(){
    var functions = arguments ;
    return this.click(function(){
            var iteration = $(this).data('iteration') || 0;
            functions[iteration].apply(this, arguments);
            iteration = (iteration + 1) % functions.length ;
            $(this).data('iteration', iteration);
    });
};
function selectAllToggle(){
    $("#select_all").toggleClick(function () {$(".ids").prop("checked", "checked");},function () {$(".ids").removeAttr("checked");});
}