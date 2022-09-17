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
// CHURROS
$('.search-dropdown').change(function() {
	let value= $(this).val();
	console.log('#second-field-' + this.id);
	console.log($('#second-field-' + this.id).html());
	if( value == 'BETWEEN' || value == 'NOT BETWEEN' ) {
		$('#second-field-' + this.id).show(200);
	} else {
		$('#second-field-' + this.id).hide(200);
	}
});
$('.search-adv-field').click(function() {
	console.log($(this).data('input-name'));
});
/*>>>>>FORMS_JS*/
/*<<<<<EXTRA_JS*/

/*>>>>>EXTRA_JS*/
