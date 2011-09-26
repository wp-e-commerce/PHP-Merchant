(function($){
	$(function(){
		var toc = $('header nav');
		var tocHeight = toc.height();
		toc.addClass('hidden');
		$('a[href=#toc]').toggle(
			function(){
				toc.height(tocHeight);
				toc.removeClass('hidden');
				$('header > a[href=#toc]').html('Table of Contents &uarr;')
			},
			function(){
				toc.height(0);
				toc.addClass('hidden');
				$('header > a[href=#toc]').html('Table of Contents &darr;')
			}
		);
	});
})(jQuery);