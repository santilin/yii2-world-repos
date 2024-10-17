/*<<<<<MAIN*/
/*Template:Yii2App/web/js/site.js*/

/*>>>>>MAIN*/
/*<<<<<MODULE_INIT_FORM*/
const ChurrosForm = (function() {
	return {
		formEnterAsTab: function(event) {
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
		},
		setFocusToFirstFormInput: function(form) {
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
		},
        moveCaretToEnd: function(input) {
			const val = input.value;
			input.value = '';
			input.value = val;
		},
		preventBackspaceNavigation: function(e) {
			var doPrevent = false;
			if (e.keyCode === 8) {
				var d = e.srcElement || e.target;
				if ((d.tagName.toUpperCase() === 'INPUT' &&
					(d.type.toUpperCase() === 'TEXT' ||
					d.type.toUpperCase() === 'PASSWORD' ||
					d.type.toUpperCase() === 'FILE' ||
					d.type.toUpperCase() === 'SEARCH' ||
					d.type.toUpperCase() === 'EMAIL' ||
					d.type.toUpperCase() === 'NUMBER' ||
					d.type.toUpperCase() === 'DATE' )) ||
					d.tagName.toUpperCase() === 'TEXTAREA') {
					doPrevent = d.readOnly || d.disabled;
				}
				else {
					doPrevent = true;
				}
			}
		},

		initForm: function(form, enterAsTab, setFocus, preventBackspace) {
			if (typeof form === 'string') {
				form = document.getElementById(formId);
			}
			if (form) {
				if (setFocus) {
					this.setFocusToFirstFormInput(form);
				}
				if (preventBackspace) {
					form.addEventListener('keydown', this.preventBackspaceNavigation);
				}
				if (enterAsTab) {
					form.addEventListener('keydown', this.formEnterAsTab);
				}
			}
		}
	};
})();
/*>>>>>MODULE_INIT_FORM*/
/*<<<<<EXTRA_JS*/

/*>>>>>EXTRA_JS*/
