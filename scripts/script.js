const passwordInput = document.querySelector("input"),
indicator = document.querySelector(".indicator"),
iconText = document.querySelector(".icon-text"),
text = document.querySelector(".text");


function Strength(passwordInput) {
    let i = 0;
    if(passwordInput.length > 6) {
        i++;
    }
    if(passwordInput.length >= 10) {
        i++
    }
    if(/[A-Z]/.test(passwordInput)) {
        i++
    }
    if(/[a-z]/.test(passwordInput)) {
        i++
    }
    if(/[0-9]/.test(passwordInput)) {
        i++
    }
    if(/[A-Za-z0-9]/.test(passwordInput)) {
        i++
    }
    return i;

}

let wrapper = document.querySelector('.wrapper');
document.addEventListener('keyup', function(e){
    let passwordInput = document.querySelector('input').value;

    let strength = Strength(passwordInput);
    if(strength <=2) {
        wrapper.classList.add('weak');
        wrapper.classList.remove('medium');
        wrapper.classList.remove('strong');
    } else if (strength >= 2 || strength <= 4) {
        wrapper.classList.remove('weak');
        wrapper.classList.add('medium');
        wrapper.classList.remove('strong');
    } else {
        wrapper.classList.remove('weak');
        wrapper.classList.remove('medium');
        wrapper.classList.add('strong');
    }
})
