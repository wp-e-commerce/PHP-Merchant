(function(){
	var elements = ['header', 'section', 'nav', 'article', 'footer', 'hgroup'];
	for (i in elements) {
		document.createElement(elements[i]);
	}
})();