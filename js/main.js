const loginPopup = document.querySelector(".login-popup");

const loginBtn = document.querySelector('.log-in');

const closeBtn = document.querySelector('.close');

const loginBtn2 = document.querySelector('.log-in2');

loginBtn.addEventListener('click', e => {
    e.preventDefault();
    loginPopup.style.display = "block";
})

loginBtn2.addEventListener('click', () => {
    loginPopup.style.display = "block";
})

closeBtn.addEventListener('click', () => {
    loginPopup.style.display = "none";
})

loginPopup.addEventListener('click', e => {
    if(e.target == loginPopup){
        loginPopup.style.display = "none";
    }
})
    