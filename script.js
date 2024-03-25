const signInBtnLink =  document.querySelector('.sign-in-link');
const signUpBtnLink =  document.querySelector('.sign-up-link');
const wrapper =  document.querySelector('.wrapper');

signUpBtnLink.addEventListener('click', () => {
    wrapper.classList.toggle('active');
})