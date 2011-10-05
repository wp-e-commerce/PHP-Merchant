(function($){
	var handler = {
		search_complete : function() {
			if ('localStorage' in window && window['localStorage'] !== null && localStorage.getItem('hide_disclaimer')) {
				return;
			}
			$('#cse .ad-disclaimer').remove();
			var ads = $('.gsc-adBlock');
			if (ads.size() > 0) {
				$('.ad-disclaimer').clone().insertBefore(ads).fadeIn();
			}
		}
	}

	$('.ad-disclaimer a').live('click', function(){
		if ('localStorage' in window && window['localStorage'] !== null) {
			localStorage.setItem('hide_disclaimer', true);
		}
		$(this).parent().fadeOut();
		return false;
	});

	$(function(){
		var cse = $('#cse'),
			focused = false,
			cse_blur = function(){ cse.animate({opacity:0.5}); },
			cse_focus = function(){ cse.animate({opacity:1}) },
			input_blur = function() { };
		cse_blur();
		cse.hover(cse_focus);
		$('input.gsc-input').focus(cse_focus);
	});

	google.setOnLoadCallback(function() {
		var customSearchControl = new google.search.CustomSearchControl('006733622201477090442:6exp02ds8-w');
		customSearchControl.setResultSetSize(5);
		customSearchControl.setSearchCompleteCallback(handler, handler.search_complete);
		customSearchControl.draw('cse');
	}, true);
})(jQuery);