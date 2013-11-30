$(function() {
	var time = 300;
	var offset = $('.post').first().offset(), left = offset.left, top = offset.top;
	$.extend($.fn, {
		lt: function(i) {
			return this.filter(':lt(' + i + ')');
		},
		gt: function(i) {
			return this.filter(':gt(' + i + ')');
		}
	});
	$('.post').each(function(i) {
		var that = $(this), offset = that.offset();
		that.css({
			left: offset.left,
			top: offset.top,
			'z-index': 500 - i
		});
	}).addClass('post-loaded').gt(0).each(function(i) {
		var that = $(this);
		window.setTimeout(function() {
			that.transit({
				left: '+=80',
				rotate: '20deg'
			}, time, function() {
				that.transit({
					rotate: '0',
					left: left,
					top: top
				})
			})
		}, i * time);
	});
	$('body').addClass('loaded');
	window.setTimeout(function() {
		$('.post').each(function(i) {
			$(this).transit({
				rotate: (i * 9) + 'deg'
			}, 1000)
		})
	}, $('.post').length * time + time / 2);
	var timerN, timerP, speed = '0.05deg';
	function next() {
		$('.post').transit({
			rotate: '+=' + speed
		}, 10);
	}
	function prev() {
		$('.post').transit({
			rotate: '-=' + speed
		}, 10);
	}
	$('.next').on('mouseenter', function() {
		timerN = window.setInterval(next, 10);
	}).on('mouseleave', function() {
		$('.post').stop();
		window.clearInterval(timerN);
	});
	$('.prev').on('mouseenter', function() {
		timerP = window.setInterval(prev, 10);
	}).on('mouseleave', function() {
		$('.post').stop();
		window.clearInterval(timerP);
	});
});
