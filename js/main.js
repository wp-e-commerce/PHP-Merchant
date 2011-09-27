(function($){
	$(function(){
		var toc = $('header nav');
		var tocHeight = toc.height();
		var tocLink = $('header > a[href=#toc]');
		toc.addClass('hidden');
		$('a[href=#toc]').click(
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
	});
})(jQuery);