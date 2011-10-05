(function($){
	(function(){
		var toggleState = false;
		$.fn.toggleTextArrow = function() {
			var t = $(this).eq(0);
			toggleState = ! toggleState;
			if (toggleState) {
				t.html('Table of Contents &uarr;');
			} else {
				t.html('Table of Contents &darr;');
			}
		}
	})();

	$(function(){
		var toc           = $('header nav').eq(0),
		    cse           = $('#cse'),
		    tocLink       = $('header nav a[href=#toc]'),
		    windowHeight  = $(window).height(),
		    scrollTimeout = null;
		    toc.hide().addClass('hidden');
		    cse.hide().addClass('hidden');
		$('a[href="#toc"]').click(
			function(){
				var t = $(this);
				toc.slideToggle(function(){
					toc.toggleClass('hidden');
					t.toggleTextArrow();
				});
				return false;
			}
		);

		$('a[href="#cse"]').click(
			function(){
				cse.slideToggle(function(){
					cse.toggleClass('hidden');
				});
				return false;
			}
		);

		$('#scroll-to-top').hide();

		$(window).scroll(function(e){
			if (scrollTimeout) {
				clearTimeout(scrollTimeout);
			}

			scrollTimeout = setTimeout(function(){
			if ($(window).scrollTop() > windowHeight) {
				$('#scroll-to-top').fadeIn(150);
			} else {
			   $('#scroll-to-top').fadeOut(150);
			}
		  }, 160);
		});
	});
})(jQuery);