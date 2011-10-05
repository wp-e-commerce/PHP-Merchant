(function($){
	$(function(){
		var toc = $('header nav').eq(0);
		var cse = $('#cse');
		var tocHeight = toc.height();
		var tocLink = $('header a[href=#toc]');
		var windowHeight = $(window).height();
		var scrollTimeout = null;
		toc.addClass('hidden');
		cse.addClass('hidden');
		$('a[href="#toc"]').click(
			function(){
				if (toc.hasClass('hidden')) {
					toc.animate({height : tocHeight}).removeClass('hidden');
					tocLink.html('Table of Contents &uarr;')
				} else {
					toc.animate({height : 0}).addClass('hidden');
					tocLink.html('Table of Contents &darr;')
				}
			}
		);

		cse.addClass('hidden');

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