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
		},

		copyToClipboard: function(text_area, text) {
			try {
				// Try to use the modern clipboard API
				navigator.clipboard.writeText(text).then(function() {
					console.log('Text successfully copied to clipboard');
				}).catch(function(err) {
					console.error('Unable to copy text: ', err);
				});
			} catch (err) {
				// Check if a textarea is provided
				if (text_area) {
					// If textarea exists, use it
					text_area.value = text;
					text_area.select();
				} else {
					// If no textarea, create a temporary one
					text_area = document.createElement("textarea");
					text_area.value = text;
					document.body.appendChild(text_area);
					text_area.select();
				}
				// Fallback to execCommand for older browsers
				try {
					console.log(text_area.value);
					debugger;
					var successful = document.execCommand('copy');
					var msg = successful ? 'successful' : 'unsuccessful';
					console.log('Fallback: Copying text was ' + msg);
				} catch (err) {
					console.error('Fallback: Unable to copy text: ', err);
				}
				// Remove the temporary textarea if we created one
				if (!text_area.parentNode) {
					document.body.removeChild(text_area);
				}
			}
		}

	};
})();
/*>>>>>MODULE_INIT_FORM*/
/*<<<<<EXTRA_JS*/

/*>>>>>EXTRA_JS*/
