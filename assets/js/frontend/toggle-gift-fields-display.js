const giftToggleButton = document.getElementById('gift_toggle');
const giftFields = document.getElementById('gift-fields');
const giftTextField = document.getElementById('message');
const giftTextFieldCounter = document.getElementById('gift-char-count-value');
const giftMaxLength = giftTextField.maxLength;

giftToggleButton.addEventListener('change',toggleGiftFieldsDisplay);
giftTextField.addEventListener('input',updateCharCounter);

(giftToggleButton.checked) ? giftFields.classList.remove('hide'): giftFields.classList.add('hide') ;

function toggleGiftFieldsDisplay() {
	giftFields.classList.toggle('hide');
}

function updateCharCounter() {
	let charCount = giftTextField.value.length;
	giftTextFieldCounter.textContent = giftMaxLength - charCount;
	
	(giftMaxLength - charCount < 50) ? giftTextField.classList.add('warning-colour') : giftTextField.classList.remove('warning-colour') ;
	
}