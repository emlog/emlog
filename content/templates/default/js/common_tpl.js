"use strict"

/**
 * jquery animation extension. First accelerate to 50%, then decelerate to zero
 */
jQuery.extend(jQuery.easing, {
	easeInOut: function (x, t, b, c, d) {
		if ((t /= d / 2) < 1) return c / 2 * t * t + b
		return -c / 2 * ((--t) * (t - 2) - 1) + b
	}
})

var myBlog = {
	/**
     * Initialization
	*/
	init: function () {
      this.tocAnalyse()  // TOC catalog generation
      if ($("#comment-info").length == 0) {  // Large screen login status, the bottom two corners of the comment box are rounded 
			$(".commentform #comment").css("height", "140px")
				.css('border-radius', '10px')
		}
      for (let num = 0; num < $(".markdown img").length; num++) {  // Add the function of viewing the large image in the text (by default, the link in the parent tag <a> of the image is the original address of the image)
			let $this = $(".markdown img:eq(" + num + ")")
			let sourceSrc = $(".markdown img:eq(" + num + ")").parent().attr('href')

			if (typeof sourceSrc == "undefined" || sourceSrc.match(/\.(jpeg|jpg|gif|png)$/i) == null) {
				continue
			}

			$this.attr("data-action", "zoom")
				.parent().attr("sourcesrc", sourceSrc)
				.removeAttr("href")
		}
      $("#commentform").attr("onsubmit", "return myBlog.comSubmitTip()")  // Comment submission cannot be submitted if the form verification fails
	},
	/**
	* Reply
	*/
	comReply: function ($t) {
		var $ele, getpid, $com_board
		$ele = $t.parent().parent()
		getpid = $ele.parent().attr("id").substring(8)
		$com_board = $("#comment-post")

		$ele.append($com_board)
		$("#comment-pid").attr("value", getpid)
		$("#cancel-reply").css("display", "unset")
		$("#comment-place").toggleClass("com-bottom")
	},
	/**
	* Cancel reply
	*/
	cancelReply: function ($t) {
		$("#comment-pid").attr("value", "0")
		$("#cancel-reply").css("display", "none")
		$("#comment-place").append($("#comment-post"))
			.toggleClass("com-bottom")
	},
	/**
	* Click on the mobile phone to expand the navigation button
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
	* Locate the position of the navigation drop-down box in the large screen state
	*/
	calMargin: function ($t) {
		if (window.outerWidth < 992) return
		var $childMenu, menuWidth, count

        menuWidth = 135  // The width of the sub-navigation drop-down box on the big screen (px), can be modified as neededmenuWidth = 135  // The width of the sub-navigation drop-down box on the big screen (px), can be modified as needed              menuWidth = 135  // The width of the sub-navigation drop-down box on the big screen (px), can be modified as neededmenuWidth = 135  // The width of the sub-navigation drop-down box on the big screen (px), can be modified as neededmenuWidth = 135  // The width of the sub-navigation drop-down box on the big screen (px), can be modified as neededmenuWidth = 135  // The width of the sub-navigation drop-down box on the big screen (px), can be modified as needed              menuWidth = 135  // The width of the sub-navigation drop-down box on the big screen (px), can be modified as neededmenuWidth = 135  // The width of the sub-navigation drop-down box on the big screen (px), can be modified as needed            menuWidth = 135  // The width of the sub-navigation drop-down box on the big screen (px), can be modified as neededmenuWidth = 135  // The width of the sub-navigation drop-down box on the big screen (px), can be modified as needed              menuWidth = 135  // The width of the sub-navigation drop-down box on the big screen (px), can be modified as neededmenuWidth = 135  // The width of the sub-navigation drop-down box on the big screen (px), can be modified as neededmenuWidth = 135  // The width of the sub-navigation drop-down box on the big screen (px), can be modified as neededmenuWidth = 135  // The width of the sub-navigation drop-down box on the big screen (px), can be modified as needed              menuWidth = 135  // The width of the sub-navigation drop-down box on the big screen (px), can be modified as neededmenuWidth = 135  // The width of the sub-navigation drop-down box on the big screen (px), can be modified as needed
		count = ($t.outerWidth() - menuWidth) / 2 + "px"
		$childMenu = $t.siblings('.dropdown-menus')

		$childMenu.css("width", menuWidth + "px")
			.css("margin-left", count)
	},
	/**
	* Validation of the form before submitting the comment
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
        this.comTip = lang('chinese_must_have')
			} else if (typeof mail !== "undefined" && mail != '' && !mailReg.test(mail)) {
        this.comTip = lang('email_invalid')
			} else if (typeof url !== "undefined" && url != '' && !urlReg.test(url)) {
        this.comTip = lang('url_invalid')
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
	* Show (hide) the verification code modal window
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
	* Click Refresh verification code
	*/
	captchaRefresh: function ($t) {
		var timestamp = new Date().getTime()
		var blogUrl = $("base").attr("href")

		$t.attr("src", blogUrl + "/include/lib/checkcode.php?" + timestamp)
	},
	/**
	* When the image is clicked, the thumbnail will be converted to the original image
	*/
	toggleImgSrc: function ($t) {
		$t.addClass('zoomFocus')
		$t.attr('src2', $t.attr('src'))
		$t.attr('src', $t.parent().attr('sourcesrc'))
	},
	/**
	* The value of the archive drop-down box is changed, jumping to the link of the corresponding date article
	*/
	jumpLink: function ($t) {
		$(window).attr("location",$t.val())
	},
	/**
	* toc analysis
	*
	* Enable toc directory method: write '[toc]' or'<!--[toc]-->' at the beginning of the article, preferably on a single line
	*/
	tocFlag: /\[toc\]/gi,  // Regular expression to determine whether toc is declared
	tocArray: new Array(),  // Array to store toc
	tocSetArray: function(){  // Fill the toc array with data
		var $titles = $("#emlogEchoLog h1,h2,h3,h4,h5,h6:eq(0)")

		for (var i = 0; i < $titles.length; i++) {  // Store the label data into an array in sequence
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
	* toc analysis (entrance to the toc effect program)
	*/
	tocAnalyse: function () {
		var tocFlag = document.querySelector("#emlogEchoLog p")

       if ($("#emlogEchoLog").length == 0) return  // Not reading the page, Exit
       if (!this.tocFlag.test($('#emlogEchoLog').html().substring(0,30))) return  // Toc tag bot detected, Exit
       tocFlag.innerHTML = tocFlag.innerHTML.replace(this.tocFlag,"")  // Remove toc statement

		var $logCon = $(".log-con")
		var logConMar = parseInt($logCon.css("margin-left"))
		var $titles = $("#emlogEchoLog h1,h2,h3,h4,h5,h6:eq(0)")

		if ($titles.length > 0) {
			if (window.outerWidth > 1275){
               $logCon.css("margin-left", logConMar + 150 + 'px')  // The text of the article is offset 150px to the right
			}
		} else {
           return  // No title found (h tag), Exit
		}

		$titles.attr("toc-date", "title")
		this.tocSetArray()
		this.tocRender()
		this.tocMobileSet()
	},
	/**
	* toc directory rendering
	*/
	tocRender: function() {
		var tocHtml = ''
		var data = this.tocArray
		var $logcon = $(".log-con")
		var padNum = (window.outerWidth < 1276) ? 0 : parseInt($logcon.css("margin-left")) - 270
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

		function tocSetListen(){  // Add listening events in batches
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

       function tocSetPos() {  // Determine location and set positioning style
			let articleTop = 200
			
			if (document.documentElement.scrollTop > articleTop) {
				$("#toc-con").css("position", "fixed")
					.css("top", "0px")
			} else {
				$("#toc-con").css("position", "absolute")
					.css("top", articleTop + "px")
			}
		}

       function tocGetPos() {  // Get the position and change the color of the specified title
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

           if (redScreenPos > tocHeight) {  // Adjust the position of the toc scroll bar according to the reading position of the article
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
       }  // Wheel event
       $('#toc-con div').mouseover(function (){  // Adjust the wheel event according to the mouse position
			window.onscroll = function () {
				tocSetPos()
			}
		}).mouseout(function () {
			window.onscroll = function () {
				tocSetPos();
				tocGetPos()
			}
		})

       setInterval(function(){  // Refresh toc listener events and toc directory coordinates every 1.5 seconds
			tocSetListen()
			myBlog.tocSetArray()
		}, 1500)
	},/**
    * Some settings of the mobile toc
	*/
	tocMobileSet: function () {
		if (window.outerWidth > 1275) return
		$(".toc-con").toggle()
$("[toc-date='title']").append('<a class="toc-link">[' + lang('toc') + ']</a>')

       $(".toc-link").click(function (e) {  // Add event listener
			$(".toc-con").show()
           e.stopPropagation()  // Prevent events from bubbling up
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
 * Event listener
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
            if (myBlog.comSubmitTip()) {  // Before displaying the verification code modal box of the comment, check the content of the comment area first
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