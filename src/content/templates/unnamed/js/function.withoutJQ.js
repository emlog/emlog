/*
 * Author: 奇遇
 * Url: http://www.qiyuuu.com
 */
$(function() {
	var a = location.hash.replace(/^#(.*)$/, '$1');
	if(a != "" && !/^comment/i.test(a) && !/^(\d+)$/.test(a)) {
		ajax.d(a);
	}
	if(!($.browser.msie && $.browser.version <= "8.0")) {
		$(".navi").mouseleave(function() {
			var top = $(".current").position().top;
			$(".navbg").stop().animate({top: top + "px"},200);
		});
		$(".navlist").mouseenter(function() {
			var top = $(this).position().top;
			$(".navbg").stop().animate({top: top + "px"},200);
		})
	 	$(".navlist a").click(function() {
			$(".current").removeClass("current");
			$(this).parent().addClass("current");
		});
		$(".navbg").animate({top: $(".current").position().top + "px"},	200);
	} else {
		$(".navlist").mouseenter(function() {
			var left = $(this).position().left;
			var width = $(this).width();
			$(".navbg").stop().animate({left: left + "px",width: width + "px"},200);
		}).mouseleave(function() {
			var left = $(".current").position().left;
			var width = $(".current").width();
			$(".navbg").stop().animate({left: left + "px",width: width + "px"},200);
		});
	 	$(".navlist a").click(function() {
			$(".current").removeClass("current");
			$(this).parent().addClass("current");
		});
		$(".navbg").animate({left: $(".current").position().left + "px",width: $(".current").width() + "px"},	200);
	}
	$(document).keypress(function(a){(a.ctrlKey&&a.which==13||a.which==10)&&$("#comment_submit").click()});
});
