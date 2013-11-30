$(function() {
	$.extend($.fn, {
		lt: function(i) {
			return this.filter(':lt(' + i + ')');
		},
		gt: function(i) {
			return this.filter(':gt(' + i + ')');
		}
	});
	$.asyncAnim = function(context, callback) {
		return $.asyncAnim.add(context, callback);
	};
	$.extend($.asyncAnim, {
		stack: [],
		animating: false,
		add: function(context, callback) {
			this.stack.push({
				context: context,
				callback: callback
			});
			return this;
		},
		del: function(index) {
			var temp = this.stack[index];
			if (temp === undefined) {
				return undefined;
			}
			for (var j = index + 1; j < this.stack.length; j++) {
				this.stack[j - 1] = this.stack[j];
			}
			this.stack.pop();
			return temp;
		},
		fire: function(type) {
			if (this.stack.length == 0) {
				this.animating = false;
				return;
			}
			var animate = this.stack.shift();
			if (!$.isFunction(animate.callback)) {
				return;
			}
			animate.callback.call(animate.context);
			$.when($(animate.context).promise()).done(function() {
				if (type === 'animate') {
					$.asyncAnim.fire.call($.asyncAnim, type);
				}
			});
		},
		animate: function() {
			if (this.animating) {
				return;
			}
			this.animating = true;
			this.fire('animate');
		}
	});
	$('.post:first').addClass('current');
	$('#posts').on('click', '.post', function() {
		if ($.asyncAnim.animating || $(this).hasClass('current')) {
			return false;
		}
		var that = this,
			posts = $('.post').not('.hidden'),
			current = posts.index(that);
		posts.filter('.current').removeClass('current');
		$(this).addClass('current');
		if ($(this).hasClass('prev')) {
			var nextPosts = posts.not('.prev'),
				length = posts.length - nextPosts.length - current;
			posts.filter('.prev').not(':lt(' + current + ')').each(function(i) {
				$.asyncAnim(this, function() {
					$(this).transition({
						opacity: 1,
						rotate: -i * 10
					}, function() {
						$(this).removeClass('prev');
					});
				});
			});
			nextPosts.each(function(i) {
				$.asyncAnim(this, function() {
					$(this).transition({
						rotate: (- i - length) * 10
					});
				});
			});
		} else {
			var length = posts.filter('.prev').length;
			posts.lt(current).not('.prev').each(function(i) {
				$.asyncAnim(this, function() {
					$(this).transition({
						opacity: 0.2,
						rotate: 150 + (current - i - length) * 10
					}, function() {
						$(this).addClass('prev');
					});
				});
			});
			posts.filter('.prev').each(function(i) {
				$.asyncAnim(this, function() {
					$(this).transition({
						rotate: 150 + (current - i) * 10
					});
				});
			});
			posts.gt(current - 1).each(function(i) {
				$.asyncAnim(this, function() {
					$(this).transition({
						rotate: -i * 10
					});
				});
			});
		}
		$.asyncAnim.animate();
		return false;
	});
});