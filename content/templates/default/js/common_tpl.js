"use strict"

/**
 * jqurey添加动画扩展。先加速度至配速的50%，再减速到零
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
		if ($("#comment-info").length == 0) {  // 大屏幕登录状态，评论框下两角变圆角
			$(".commentform #comment").css("height", "140px")
				.css('border-radius', '10px')
		}
		for (let num = 0; num < $(".markdown img").length; num++) {  // 为正文中的图片添加查看大图（默认认为图片父标签<a>中的链接是图片原地址）
			let $this = $(".markdown img:eq(" + num + ")")
			let sourceSrc = $(".markdown img:eq(" + num + ")").parent().attr('href')

			if (typeof sourceSrc == "undefined" || sourceSrc.match(/\.(jpeg|jpg|gif|png)$/i) == null) {
				continue
			}

			$this.attr("data-action", "zoom")
				.parent().attr("sourcesrc", sourceSrc)
				.removeAttr("href")
		}
		$("#commentform").attr("onsubmit", "return myBlog.comSubmitTip()")  // 评论提交在表单验证未通过的情况下是不能提交的
	},
	/**
	* 回复
	*/
	comReply: function ($t) {
		var $ele, getpid, $com_board
		$ele = $t.parent().parent()
		getpid = $ele.parent().attr("id")
		$com_board = $("#comment-post")

		$ele.append($com_board)
		$("#comment-pid").attr("value", getpid)
		$("#cancel-reply").css("display", "unset")
		$("#comment-place").toggleClass("com-bottom")
	},
	/**
	* 取消回复
	*/
	cancelReply: function ($t) {
		$("#comment-pid").attr("value", "0")
		$("#cancel-reply").css("display", "none")
		$("#comment-place").append($("#comment-post"))
			.toggleClass("com-bottom")
	},
	/**
	* 手机点击展开导航按钮
	*/
	navToggle: function ($t) {
		var time, effect, $navbar, $nav_c, nav_height
		time = 'fast'
		effect = 'easeInOut'
		$navbar = $("#navbarResponsive")
		$nav_c = $(".blog-header-c")
		nav_height = ($nav_c.height() == 74) ? $navbar.height() + 74 : 74

		$nav_c.animate({height: nav_height + 'px'}, time, effect)
		$navbar.slideToggle(time, effect)
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
		if (value == 'judge') {
			let cnReg = /[\u4e00-\u9fa5]/
			let mailReg = /^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$/
			let urlReg = /[^\s]*\.+[^\s]/

			let isCn = $('#commentform').attr('is-chinese')
			let comContent = $('#comment').val()
			let mail = $('#info_m').val()
			let url = $('#info_u').val()

			if (isCn == 'y' && !cnReg.test(comContent)) {
				this.comTip = "评论内容需要包含中文！"
			} else if (typeof mail !== "undefined" && mail != '' && !mailReg.test(mail)) {
				this.comTip = "邮箱格式错误！"
			} else if (typeof url !== "undefined" && url != '' && !urlReg.test(url)) {
				this.comTip = "网址格式错误！"
			} else {
				this.comTip = ''
			}
		} else {
			if (this.comTip != '') {
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
		var blogUrl = $("base").attr("href")

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
		$(window).attr("location",$t.val())
	},
	/**
	* toc 效果
	*
	* 启用 toc 目录方式: 在文章最开头写上'[toc]'或者'<!--[toc]-->',最好是单独一行
	*/
	tocFlag: /\[toc\]/gi,  // 判断toc是否声明的正则表达式
	tocArray: new Array(),  // 储存toc的数组
	tocSetArray: function(){  // 设置toc的数组内填数据
		var $titles = $("#emlogEchoLog h1,h2,h3,h4,h5,h6:eq(0)")

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
		var tocFlag = document.querySelector("#emlogEchoLog p")

		if ($("#emlogEchoLog").length == 0) return  // 不在阅读页面  退出
		if (!this.tocFlag.test($('#emlogEchoLog').html().substring(0, 30))) return  // 未声明 toc 标签，退出
		tocFlag.innerHTML = tocFlag.innerHTML.replace(this.tocFlag, "")  // 去除 toc 声明

		var $logCon = $(".log-con")
		var logConMar = parseInt($logCon.css("margin-left"))
		var $titles = $("#emlogEchoLog h1,h2,h3,h4,h5,h6:eq(0)")

		if ($titles.length > 0) {
			if (window.outerWidth > 1275 || window.outerWidth === 0){
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
	tocRender: function() {
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
		tocHtml = tocHtml + '<div style="height:calc(100vh - 70px);overflow-y:scroll;" ><lu>'
		for (var i = 0; i < data.length; i++) {
			let k = minType
			let itemType = data[i]['type']
			let isPadding = ''
			let isBold = ['', '']

			if (itemType != judgeN) isPadding = 'style="padding-top:' + chilPad + 'px"'
			tocHtml = tocHtml + '<li ' + isPadding + ' id="to' + i + '" title="' + data[i]['content'] + '" >'
			if (itemType == minType) {
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
		tocHtml = tocHtml + '</lu></div></div>'
		$logcon.before(tocHtml)

		function tocSetListen(){  // 批量添加监听事件
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
			if ($tempItem){
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

		setInterval(function(){  // 每 1.5 秒刷新一次 toc 监听事件和 toc 目录坐标
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
			if($(".toc-con") && $(".toc-con").css("display") == "block") {
				$(".toc-con").hide()
			}
			e.stopPropagation() 
		})
	}
}

/**
 * 事件监听
 */
$(document).ready(function () {
	myBlog.init()

	$(".com-reply").click(function () {
		myBlog.comReply($(this))
	}),

	$(".cancel-reply").click(function () {
		myBlog.cancelReply($(this))
	}),

	$(".blog-header-toggle").click(function () {
		myBlog.navToggle($(this))
	}),

	$(".has-down").mouseenter(function () {
		myBlog.calMargin($(this))
	}),

	$("#captcha").click(function () {
		myBlog.captchaRefresh($(this))
	}),

	$('#comment_submit[type="button"], #close-modal').click(function () {
		myBlog.comSubmitTip('judge')
		if (myBlog.comSubmitTip()) {  // 在显示评论的验证码模态框前，先校验一下评论区内容
			myBlog.viewModal()
		}
	}),

	$(".form-control").blur(function () {
		myBlog.comSubmitTip('judge')
	}),

	$(".markdown img").click(function () {
		myBlog.toggleImgSrc($(this))
	}),

	$("#archive").change(function () {
		myBlog.jumpLink($(this))
	})
})