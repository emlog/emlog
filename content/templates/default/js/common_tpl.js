"use strict"

/**
 * jqurey 的动画扩展“缓进缓出”
 */
jQuery.extend(jQuery.easing, {
    easeInOut: function (x, t, b, c, d) {
        if ((t /= d / 2) < 1) return c / 2 * t * t + b
        return -c / 2 * ((--t) * (t - 2) - 1) + b
    }
})

var myBlog = {
    /**
     * 初始化
     */
    init: function () {
        this.tocAnalyse()  // toc目录生成
        this.backToTop()   // 返回顶部功能初始化
        if ($("#comment-info").length === 0) {  // 大屏幕登录状态，评论框下两角变圆角
            $(".commentform #comment").css("height", "140px")
                .css('border-radius', '10px')
        }
        $("#commentform").attr("onsubmit", "return myBlog.comSubmitTip()")  // 评论提交在表单验证未通过的情况下是不能提交的
    },
    replyBtn: null,
    /**
     * 回复
     */
    toggleCommentInput: function ($t) {
        var $ele, getpid, $com_board, currentPid
        $ele = $t.parent().parent()
        getpid = $ele.parent().attr("id")
        $com_board = $("#comment-post")
        currentPid = $("#comment-pid").attr("value") || "0"

        if (currentPid === "0") {
            $ele.append($com_board)
            $("#comment-pid").attr("value", getpid)
            $("#comments").addClass("com-bottom")
            this.replyBtn = $t
            $t.hide()
            $("#cancel-reply").show()
        } else if (currentPid === getpid) {
            this.cancelReply()
        } else {
            this.restoreReplyBtn()
            $ele.append($com_board)
            $("#comment-pid").attr("value", getpid)
            $("#comments").addClass("com-bottom")
            this.replyBtn = $t
            $t.hide()
            $("#cancel-reply").show()
        }
    },
    restoreReplyBtn: function () {
        if (this.replyBtn && this.replyBtn.length) {
            this.replyBtn.show()
        }
        this.replyBtn = null
    },
    cancelReply: function () {
        $("#comment-pid").attr("value", "0")
        $("#comments").append($("#comment-post")).removeClass("com-bottom")
        $("#cancel-reply").hide()
        this.restoreReplyBtn()
    },

    /**
     * 手机点击展开导航按钮 - 侧边栏滑出效果
     */
    navToggle: function ($t) {
        var $navbar = $("#navbarResponsive");
        var $overlay = $(".nav-overlay");
        
        // 如果遮罩层不存在，创建它
        if ($overlay.length === 0) {
            $overlay = $('<div class="nav-overlay"></div>');
            $('body').append($overlay);
        }
        
        // 切换菜单显示状态
        if ($navbar.hasClass('show')) {
            // 隐藏菜单
            $navbar.removeClass('show');
            $overlay.removeClass('show');
        } else {
            // 显示菜单
            $navbar.addClass('show');
            $overlay.addClass('show');
        }
        
        // 点击遮罩层关闭菜单
        $overlay.off('click').on('click', function() {
            $navbar.removeClass('show');
            $overlay.removeClass('show');
        });
    },
    /**
     * 定位大屏状态下的导航下拉框位置
     */
    calMargin: function ($t) {
        if (window.outerWidth < 992) return
        var $childMenu, menuWidth, count

        menuWidth = 135  // 大屏幕端的子导航下拉框宽度(px)，可根据需要修改
        count = ($t.outerWidth() - menuWidth) / 2 + "px"
        $childMenu = $t.siblings('.dropdown-menus')

        $childMenu.css("width", menuWidth + "px")
            .css("margin-left", count)
    },
    /**
     * 提交评论前对表单的验证
     */
    comTip: '', comSubmitTip: function (value) {
        if (value === 'judge') {
            let mailReg = /^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$/

            let mail = $('#info_m').val()

            if (typeof mail !== "undefined" && mail !== '' && !mailReg.test(mail)) {
                this.comTip = "邮箱格式错误！"
            } else {
                this.comTip = ''
            }
        } else {
            if (this.comTip !== '') {
                alert(this.comTip)
                return false
            } else {
                return true
            }
        }
    },
    /**
     * 显示(隐藏)验证码模态窗
     */
    viewModal: function () {
        var $modal, $lock
        $modal = $(".modal-dialog,.lock-screen")
        $lock = $(".lock-screen")

        $('body,html').toggleClass('scroll-fix')
        $modal.fadeToggle()
        $("input[name='imgcode']").attr("autocomplete", "off")
    },
    /**
     * 点击刷新验证码
     */
    captchaRefresh: function ($t) {
        var timestamp = new Date().getTime()
        var blogUrl = $("#blog_url").val();

        $t.attr("src", blogUrl + "/include/lib/checkcode.php?" + timestamp)
    },
    /**
     * 图片在点击时，将略缩图转化为原图
     */
    toggleImgSrc: function ($t) {
        $t.addClass('zoomFocus')
        $t.attr('src2', $t.attr('src'))
        $t.attr('src', $t.parent().attr('sourcesrc'))
    },
    /**
     * 归档下拉框的值被改变，跳转到相应日期文章的链接
     */
    jumpLink: function ($t) {
        $(window).attr("location", $t.val())
    },
    /**
     * toc 效果
     *
     * 启用 toc 目录方式: 在文章最开头写上'[toc]'或者'<!--[toc]-->',最好是单独一行
     */
    tocFlag: /<!--\s*\[toc\]\s*-->|\[toc\]/i,  // 判断 toc 是否声明（兼容 [toc] 与 <!--[toc]-->）
    tocArray: new Array(),  // 储存toc的数组
    tocSetArray: function () {  // 设置toc的数组内填数据
        var $titles = $("#emlogEchoLog h1, #emlogEchoLog h2, #emlogEchoLog h3, #emlogEchoLog h4, #emlogEchoLog h5, #emlogEchoLog h6")

        for (var i = 0; i < $titles.length; i++) {  // 将标签数据依次存入数组
            let $tit = $("#emlogEchoLog [toc-date='title']:eq(" + i + ")")
            myBlog.tocArray[i] = new Array()

            myBlog.tocArray[i]['type'] = $tit.prop('tagName').substring(1)
            myBlog.tocArray[i]['content'] = $tit.text()
            myBlog.tocArray[i]['pos'] = $tit.offset().top
            myBlog.tocArray[i]['id'] = $tit.text()
            $tit.attr("id", myBlog.tocArray[i]['id'])
        }
    },
    /**
     * toc 分析（toc 效果程序的入口）
     */
    tocAnalyse: function () {
        if ($("#emlogEchoLog").length === 0) return  // 不在阅读页面  退出
        var $echoLog = $("#emlogEchoLog")
        var logHtml = $echoLog.html() || ""

        if (!this.tocFlag.test(logHtml)) return  // 未声明 toc 标签，退出
        $echoLog.html(logHtml.replace(this.tocFlag, ""))  // 去除 toc 声明

        var $logCon = $(".log-con")
        var logConMar = parseInt($logCon.css("margin-left"))
        var $titles = $("#emlogEchoLog h1, #emlogEchoLog h2, #emlogEchoLog h3, #emlogEchoLog h4, #emlogEchoLog h5, #emlogEchoLog h6")

        if ($titles.length > 0) {
            if (window.outerWidth > 1275 || window.outerWidth === 0) {
                $logCon.css("margin-left", logConMar + 150 + 'px')  // 文章正文向右偏移 150px
            }
        } else {
            return  // 未发现标题（h标签） 退出
        }

        $titles.attr("toc-date", "title")
        this.tocSetArray()
        this.tocRender()
        this.tocMobileSet()
    },
    /**
     * toc 目录渲染
     */
    tocRender: function () {
        var tocHtml = ''
        var data = this.tocArray
        var $logcon = $(".log-con")
        var padNum = (window.outerWidth < 1276 && window.outerWidth !== 0) ? 0 : parseInt($logcon.css("margin-left")) - 270
        var judgeN = 0
        var chilPad = 4
        var minType = 6

        for (var i = 0; i < data.length; i++) {
            if (data[i]['type'] < minType) minType = data[i]['type']
        }
        tocHtml = tocHtml + '<div class="toc-con" style="left:' + padNum + 'px" id="toc-con">'	// 渲染
        tocHtml = tocHtml + '<a href="javascript:void(0);" class="close-toc mh" id="closeToc">x</a>'
        tocHtml = tocHtml + '<div style="height:calc(100vh - 70px);overflow-y:scroll;" ><ul>'
        for (var i = 0; i < data.length; i++) {
            let k = minType
            let itemType = data[i]['type']
            let isPadding = ''
            let isBold = ['', '']

            if (itemType !== judgeN) isPadding = 'style="padding-top:' + chilPad + 'px"'
            tocHtml = tocHtml + '<li ' + isPadding + ' id="to' + i + '" title="' + data[i]['content'] + '" >'
            if (itemType === minType) {
                isBold[0] = '<b>'
                isBold[1] = '</b>'
            }
            while (k < itemType) {
                tocHtml = tocHtml + '&nbsp;&nbsp;&nbsp;&nbsp;'
                k++
            }
            tocHtml = tocHtml + isBold[0] + data[i]['content'] + isBold[1] + '</li>'
            judgeN = itemType
        }
        tocHtml = tocHtml + '</ul></div></div>'
        $logcon.before(tocHtml)

        function tocSetListen() {  // 批量添加监听事件
            for (var i = 0; i < data.length; i++) {
                let tempPos = myBlog.tocArray[i]["pos"]
                $('#to' + i).off("click");
                $('#to' + i).bind("click", function () {
                    window.onscroll = function () {
                        tocSetPos()
                    }
                    $('body,html').animate({scrollTop: tempPos}, 300, function () {
                        tocGetPos()
                        window.onscroll = function () {
                            tocSetPos();
                            tocGetPos()
                        }
                    })
                })
            }
        }

        function tocSetPos() {  // 判断位置和设置定位样式
            let articleTop = 200

            if (document.documentElement.scrollTop > articleTop) {
                $("#toc-con").css("position", "fixed")
                    .css("top", "0px")
            } else {
                $("#toc-con").css("position", "absolute")
                    .css("top", articleTop + "px")
            }
        }

        function tocGetPos() {  // 获取位置并改变指定标题颜色
            let $tempItem
            let dataArr = myBlog.tocArray

            $('#toc-con li').css('color', 'unset').attr('isRed', 'n')
            for (var i = 0; i < dataArr.length; i++) {
                let winPos = document.documentElement.scrollTop + 30
                if (winPos > dataArr[i]['pos']) $tempItem = $('#to' + i)
            }
            if ($tempItem) {
                $tempItem.css('color', 'red').attr('isRed', 'y')
            } else {
                return
            }
            let redScreenPos = $("li[isred='y']").offset().top - document.documentElement.scrollTop
            let tocHeight = $("#toc-con div").outerHeight()
            let tocPos = $("#toc-con div").scrollTop()

            if (redScreenPos > tocHeight) {  // 根据文章阅读位置来调整 toc 滚动条位置
                $("#toc-con div").scrollTop($("li[isred='y']").offset().top - tocHeight)
            } else if (redScreenPos < 0) {
                $("#toc-con div").scrollTop(tocPos + redScreenPos - (tocHeight / 2))
            } else {
                if (redScreenPos > (tocHeight / 2)) $("#toc-con div").scrollTop(tocPos + 10)
                if (redScreenPos < (tocHeight / 2 - 40)) $("#toc-con div").scrollTop(tocPos - 10)
            }
        }

        tocSetListen()
        tocSetPos()
        window.onscroll = function () {
            tocSetPos();
            tocGetPos()
        }  // 滚轮事件
        $('#toc-con div').mouseover(function () {  // 根据鼠标位置来调整滚轮事件
            window.onscroll = function () {
                tocSetPos()
            }
        }).mouseout(function () {
            window.onscroll = function () {
                tocSetPos();
                tocGetPos()
            }
        })

        setInterval(function () {  // 每 1.5 秒刷新一次 toc 监听事件和 toc 目录坐标
            tocSetListen()
            myBlog.tocSetArray()
        }, 1500)
    },
    /**
     * toc 目录移动端的部分设置
     */
    tocMobileSet: function () {
        if (window.outerWidth === 0) return  // Chrome 浏览器对新窗口打开的页面，会设置 width 为 0
        if (window.outerWidth > 1275) return
        $(".toc-con").toggle()
        $("[toc-date='title']").append('<a class="toc-link">[目录]</a>')

        $(".toc-link").click(function (e) {  // 添加监听事件
            $(".toc-con").show()
            e.stopPropagation()  // 阻止事件冒泡
        }),

            $("html").click(function (e) {
                if ($(".toc-con") && $(".toc-con").css("display") === "block") {
                    $(".toc-con").hide()
                }
                e.stopPropagation()
            })
    },
    /**
     * 桌面端的 toc 目录关闭
     */
    tocClose: function () {
        let logLeftMar = parseInt($(".log-con").css('margin-left')) - 150;

        $(".toc-con").toggle()
        $(".log-con").css("margin-left", logLeftMar + 'px')
    },
    /**
     * 返回顶部逻辑
     */
    backToTop: function () {
        var $backToTop = $("#back-to-top");
        
        // 滚动监听
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $backToTop.fadeIn();
            } else {
                $backToTop.fadeOut();
            }
        });

        // 点击事件
        $backToTop.click(function () {
            $('body,html').animate({scrollTop: 0}, 500);
            return false;
        });
    }

}

var authModal = {
    init: function () {
        this.$modal = $("#auth-modal")
        this.$mask = $("#auth-modal-mask")
        if (!this.$modal.length || !this.$mask.length) {
            return
        }
        this.$title = $("#auth-modal-title")
        this.$subtitle = $("#auth-modal-subtitle")
        this.$alert = $("#auth-modal-alert")
        this.$panels = this.$modal.find("[data-auth-panel]")
        this.$signinForm = $("#auth-signin-form")
        this.$signupForm = $("#auth-signup-form")
        this.$resetForm = $("#auth-reset-form")
        this.$resetPanel = this.$panels.filter('[data-auth-panel="reset"]')
        this.$resetSubmit = this.$resetForm.find(".auth-submit")
        this.$resetStepOne = this.$resetForm.find(".auth-reset-step-1")
        this.$resetStepTwo = this.$resetForm.find(".auth-reset-step-2")
        this.$sendMailBtn = $("#auth-send-mail-code")
        this.bindEvents()
    },
    bindEvents: function () {
        var self = this
        $(document).on("click", "[data-auth-open]", function (e) {
            e.preventDefault()
            var panel = $(this).attr("data-auth-open") || "signin"
            self.open(panel)
        })
        $("#auth-modal-close, #auth-modal-mask").on("click", function () {
            self.close()
        })
        this.$modal.on("click", function (e) {
            if (e.target === this) {
                self.close()
            }
        })
        $(document).on("keydown", function (e) {
            if (e.key === "Escape" && self.$modal.is(":visible")) {
                self.close()
            }
        })
        this.$modal.on("click", "[data-auth-captcha]", function () {
            self.refreshCaptcha($(this))
        })
        this.$signinForm.on("submit", function (e) {
            e.preventDefault()
            self.submitSignIn()
        })
        this.$signupForm.on("submit", function (e) {
            e.preventDefault()
            self.submitSignUp()
        })
        this.$resetForm.on("submit", function (e) {
            e.preventDefault()
            self.submitReset()
        })
        this.$sendMailBtn.on("click", function () {
            self.sendMailCode()
        })
    },
    open: function (panel) {
        this.switchPanel(panel)
        this.clearAlert()
        this.$mask.fadeIn(120)
        this.$modal.fadeIn(150).attr("aria-hidden", "false")
        $("body,html").addClass("scroll-fix")
    },
    close: function () {
        this.$modal.fadeOut(120).attr("aria-hidden", "true")
        this.$mask.fadeOut(100)
        $("body,html").removeClass("scroll-fix")
        this.clearAlert()
    },
    switchPanel: function (panel) {
        var $target = this.$panels.filter('[data-auth-panel="' + panel + '"]')
        if (!$target.length) {
            $target = this.$panels.filter('[data-auth-panel="signin"]')
        }
        this.$panels.hide()
        $target.show()
        this.$title.text($target.attr("data-title") || "")
        this.$subtitle.text($target.attr("data-subtitle") || "")
        if ($target.is(this.$resetPanel)) {
            this.resetResetFlow()
        }
    },
    /**
     * 重置找回密码流程为第一步（输入注册邮箱）。
     */
    resetResetFlow: function () {
        if (!this.$resetForm.length) {
            return
        }
        this.$resetForm[0].reset()
        this.setResetStep(1)
        this.refreshAllCaptcha()
    },
    /**
     * 根据步骤切换找回密码表单字段与按钮文案。
     */
    setResetStep: function (step) {
        var isStepTwo = Number(step) === 2
        this.$resetForm.attr("data-step", isStepTwo ? "2" : "1")
        this.$resetStepOne.toggle(!isStepTwo)
        this.$resetStepTwo.toggle(isStepTwo)
        this.$resetStepOne.find("input").prop("disabled", isStepTwo)
        this.$resetStepTwo.find("input").prop("disabled", !isStepTwo)
        if (this.$resetSubmit.length) {
            var btnText = isStepTwo ? this.$resetSubmit.data("step2-text") : this.$resetSubmit.data("step1-text")
            this.$resetSubmit.text(btnText || "")
        }
        if (this.$subtitle && this.$subtitle.length) {
            var subtitle = isStepTwo ? this.$resetPanel.attr("data-subtitle-step2") : (this.$resetPanel.attr("data-subtitle-step1") || this.$resetPanel.attr("data-subtitle"))
            this.$subtitle.text(subtitle || "")
        }
    },
    /**
     * 进入找回密码第二步（验证码 + 新密码）。
     */
    enterResetStepTwo: function () {
        this.setResetStep(2)
        this.clearAlert()
    },
    refreshCaptcha: function ($img) {
        var src = $img.attr("src") || ""
        if (src.indexOf("?") > -1) {
            src = src.split("?")[0]
        }
        $img.attr("src", src + "?_t=" + Date.now())
    },
    accountUrl: function (action, withS) {
        var cfg = window.emAuthConfig || {}
        var base = cfg.accountBase || "/admin/account.php"
        var url = base + "?action=" + action
        if (withS && cfg.adminPathCode) {
            url += "&s=" + cfg.adminPathCode
        }
        return url
    },
    clearAlert: function () {
        this.$alert.removeClass("show success").text("")
    },
    showAlert: function (message, success) {
        this.$alert.text(message || "").addClass("show")
        if (success) {
            this.$alert.addClass("success")
        } else {
            this.$alert.removeClass("success")
        }
    },
    getErrorMessage: function (xhr) {
        var fallback = this.$modal.data("msg-error")
        if (!xhr) {
            return fallback
        }
        if (xhr.responseJSON && xhr.responseJSON.msg) {
            return xhr.responseJSON.msg
        }
        if (xhr.responseText) {
            try {
                var parsed = JSON.parse(xhr.responseText)
                if (parsed && parsed.msg) {
                    return parsed.msg
                }
            } catch (e) {
                return xhr.responseText
            }
            return xhr.responseText
        }
        return fallback
    },
    submitSignIn: function () {
        var self = this
        var payload = this.$signinForm.serializeArray()
        payload.push({name: "resp", value: "json"})
        this.clearAlert()
        this.toggleSubmit(this.$signinForm, true)
        $.ajax({
            type: "POST",
            url: this.accountUrl("dosignin", true),
            data: $.param(payload),
            success: function () {
                window.location.reload()
            },
            error: function (xhr) {
                self.showAlert(self.getErrorMessage(xhr))
                self.refreshAllCaptcha()
                self.toggleSubmit(self.$signinForm, false)
            }
        })
    },
    submitSignUp: function () {
        var self = this
        var payload = this.$signupForm.serializeArray()
        payload.push({name: "resp", value: "json"})
        this.clearAlert()
        this.toggleSubmit(this.$signupForm, true)
        $.ajax({
            type: "POST",
            url: this.accountUrl("dosignup"),
            data: $.param(payload),
            success: function () {
                self.showAlert(self.$modal.data("msg-signup-success"), true)
                self.toggleSubmit(self.$signupForm, false)
                setTimeout(function () {
                    self.switchPanel("signin")
                }, 900)
            },
            error: function (xhr) {
                self.showAlert(self.getErrorMessage(xhr))
                self.refreshAllCaptcha()
                self.toggleSubmit(self.$signupForm, false)
            }
        })
    },
    submitReset: function () {
        if ((this.$resetForm.attr("data-step") || "1") === "2") {
            this.submitResetStepTwo()
            return
        }
        this.submitResetStepOne()
    },
    /**
     * 找回密码第一步：提交注册邮箱并发送邮件验证码。
     */
    submitResetStepOne: function () {
        var self = this
        var payload = this.$resetForm.serializeArray()
        payload.push({name: "resp", value: "json"})
        this.clearAlert()
        this.toggleSubmit(this.$resetForm, true)
        $.ajax({
            type: "POST",
            url: this.accountUrl("doreset"),
            data: $.param(payload),
            success: function () {
                self.enterResetStepTwo()
                self.showAlert(self.$modal.data("msg-email-code-sent"), true)
                self.toggleSubmit(self.$resetForm, false)
            },
            error: function (xhr) {
                self.showAlert(self.getErrorMessage(xhr))
                self.refreshAllCaptcha()
                self.toggleSubmit(self.$resetForm, false)
            }
        })
    },
    /**
     * 找回密码第二步：提交邮件验证码与新密码完成重置。
     */
    submitResetStepTwo: function () {
        var self = this
        var payload = this.$resetForm.serializeArray()
        payload.push({name: "resp", value: "json"})
        this.clearAlert()
        this.toggleSubmit(this.$resetForm, true)
        $.ajax({
            type: "POST",
            url: this.accountUrl("doreset2"),
            data: $.param(payload),
            success: function () {
                self.showAlert(self.$modal.data("msg-reset-success"), true)
                self.toggleSubmit(self.$resetForm, false)
                setTimeout(function () {
                    self.switchPanel("signin")
                }, 900)
            },
            error: function (xhr) {
                self.showAlert(self.getErrorMessage(xhr))
                self.toggleSubmit(self.$resetForm, false)
            }
        })
    },
    sendMailCode: function () {
        var self = this
        var $mail = this.$signupForm.find('input[name="mail"]')
        var mail = $.trim($mail.val())
        if (!mail) {
            $mail.focus()
            return
        }
        var $btn = this.$sendMailBtn
        var defaultText = $btn.text()
        this.clearAlert()
        $btn.prop("disabled", true)
        $.ajax({
            type: "POST",
            url: this.accountUrl("send_email_code"),
            data: {mail: mail},
            success: function () {
                self.showAlert(self.$modal.data("msg-email-code-sent"), true)
                var seconds = 60
                var timer = setInterval(function () {
                    seconds--
                    if (seconds <= 0) {
                        clearInterval(timer)
                        $btn.text(defaultText).prop("disabled", false)
                    } else {
                        $btn.text(seconds + "s")
                    }
                }, 1000)
            },
            error: function (xhr) {
                self.showAlert(self.getErrorMessage(xhr))
                $btn.text(defaultText).prop("disabled", false)
            }
        })
    },
    refreshAllCaptcha: function () {
        this.$modal.find("[data-auth-captcha]").each(function () {
            var $img = $(this)
            var src = $img.attr("src") || ""
            if (src.indexOf("?") > -1) {
                src = src.split("?")[0]
            }
            $img.attr("src", src + "?_t=" + Date.now())
        })
    },
    toggleSubmit: function ($form, loading) {
        var $btn = $form.find(".auth-submit")
        $btn.prop("disabled", loading)
    }
}

/**
 * 事件监听
 */
$(document).ready(function () {
    myBlog.init()
    authModal.init()

    $(".com-reply").click(function () {
        myBlog.toggleCommentInput($(this))
    })

    $("#cancel-reply").click(function () {
        myBlog.cancelReply()
    })

    $(".blog-header-toggle").click(function () {
        myBlog.navToggle($(this))
    })

    $(".has-down").mouseenter(function () {
        myBlog.calMargin($(this))
    })

    $("#captcha").click(function () {
        myBlog.captchaRefresh($(this))
    })

    $('#comment_submit[type="button"], #close-modal').click(function () {
        myBlog.comSubmitTip('judge')
        if (myBlog.comSubmitTip()) {  // 在显示评论的验证码模态框前，先校验一下评论区内容
            myBlog.viewModal()
        }
    })

    $(".form-control").blur(function () {
        myBlog.comSubmitTip('judge')
    })

    $(".markdown img").click(function () {
        myBlog.toggleImgSrc($(this))
    })

    $("#archive").change(function () {
        myBlog.jumpLink($(this))
    })

    $("#closeToc").click(function () {
        myBlog.tocClose()
    })

    // 切换夜间模式主题
    const toggleButton = document.getElementById('theme-toggle');
    if (toggleButton) {
        toggleButton.addEventListener('click', () => {
            let currentTheme = document.documentElement.getAttribute('data-theme');
            let targetTheme = 'light';

            if (currentTheme === 'light') {
                targetTheme = 'dark';
            }

            document.documentElement.setAttribute('data-theme', targetTheme);
            localStorage.setItem('theme', targetTheme);
        });
    }
})
