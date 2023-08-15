/*<<<<<FORMS_JS*/
function formEnterAsTab(event) {
	if (event.keyCode === 13 && ( event.target.nodeName === 'INPUT' || event.target.nodeName === 'SELECT') ) {
		var form = event.target.form;
		var index = Array.prototype.indexOf.call(form, event.target);
		index++;
		while( (window.getComputedStyle(form.elements[index]).display === "none"
			|| form.elements[index].tabIndex == -1 )
			&& index <= form.elements.length ) {
			++index;
			}
			if (index <= form.elements.length ) {
				console.log(form.elements[index]);
				form.elements[index].focus();
			}
			event.preventDefault();
		return false;
	} else {
		return true;
	}
}
/*>>>>>FORMS_JS*/
/*<<<<<EXTRA_JS*/

/*>>>>>EXTRA_JS*/
