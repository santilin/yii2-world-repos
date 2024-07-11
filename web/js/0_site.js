/*<<<<<MAIN*/
/*Template:Yii2App/web/js/site.js*/

/*>>>>>MAIN*/
/*<<<<<FORM_JS*/
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
				form.elements[index].focus();
			}
			event.preventDefault();
		return false;
	} else {
		return true;
	}
}
function setFocusToFirstFormInput(form) {
	if (form!==undefined) {
		index = 0;
		while( (window.getComputedStyle(form.elements[index]).display === "none"
			|| form.elements[index].type === "hidden"
			|| form.elements[index].tabIndex == -1 )
			&& index <= form.elements.length ) {
			++index;
			}
			if (index <= form.elements.length ) {
				form.elements[index].focus();
			}
	}
}
function moveCaretToEnd(input) {
	const val = input.value;
	input.value = '';
	input.value = val;
}
/*>>>>>FORM_JS*/
/*<<<<<EXTRA_JS*/

/*>>>>>EXTRA_JS*/
