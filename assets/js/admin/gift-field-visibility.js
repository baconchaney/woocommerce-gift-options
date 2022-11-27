const giftWrapRadioField = document.querySelector('.cc_wc_gift_giftwrapping_option_field');
const giftWrapPriceField = document.querySelector('.cc_wc_gift_giftwrapping_price_field');

function cCWCPriceFieldVisibility() {
    const giftOptions =  giftWrapRadioField.querySelectorAll('input');
    let selectedGiftOption;
    for (giftOption of giftOptions) {
        if (!giftOption.checked) {
            continue;
        } else {
            selectedGiftOption = giftOption.value;   
        }
    }
    
    (selectedGiftOption == 2)? giftWrapPriceField.style.display = 'block': 
    giftWrapPriceField.style.display = 'none';
};

cCWCPriceFieldVisibility();

giftWrapRadioField.addEventListener('change',cCWCPriceFieldVisibility);