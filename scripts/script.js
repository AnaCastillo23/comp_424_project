const indicator = document.querySelector('.indicator'),
iconText = document.querySelector('.icon-text'),
text = document.querySelector('.text');


function Strength(password) {
    let i = 0;
    if(password.length > 6) {
        i++;
    }
    if(password.length >= 10) {
        i++;
    }
    if(/[A-Z]/.test(password)) {
        i++;
    }
    if(/[a-z]/.test(password)) {
        i++;
    }
    if(/[0-9]/.test(password)) {
        i++;
    }
    if(/[A-Za-z0-8]/.test(password)) {
        i++;
    }
    return i;
}

let wrapper = document.querySelector('.wrapper');
document.addEventListener("keyup",function(e){
    let passwordInput = document.querySelector('#myPassword').value;

    let strength = Strength(passwordInput);
    if(strength <= 2) {
        wrapper.classList.add('weak');
        wrapper.classList.remove('medium');
        wrapper.classList.remove('strong');
    } else if (strength >= 2 && strength <= 4) {
        wrapper.classList.remove('weak');
        wrapper.classList.add('medium');
        wrapper.classList.remove('strong');
    } else {
        wrapper.classList.remove('weak');
        wrapper.classList.remove('medium');
        wrapper.classList.add('strong');
    }
})

function checkPassword() {
    let passwordInput = document.querySelector('#myPassword').value;
    let confirmPassword = document.querySelector('#myPasswordReentered').value;
    console.log(passwordInput,confirmPassword);
    let message = document.getElementById("message");

    if (passwordInput.length != 0) {
        if (passwordInput !== confirmPassword) {
            message.textContent = "Passwords do not match";
            

        } else {
            //GET RID OF PASSWORD NOT MATCHING MESSAGE
            message.textContent = " ";
            //SEND USER TO HOME PAGE
                      
        }
    }
}





