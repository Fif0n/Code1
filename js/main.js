const loginPopup = document.querySelector(".login-popup");

const loginBtn = document.querySelector('.log-in');

const closeBtn = document.querySelector('.close');

const loginBtn2 = document.querySelector('.log-in2');

loginBtn.addEventListener('click', e => {
    e.preventDefault();
    loginPopup.style.display = "block";
});

if(loginBtn2 != undefined){
    loginBtn2.addEventListener('click', () => {
        loginPopup.style.display = "block";
    });
}


closeBtn.addEventListener('click', () => {
    loginPopup.style.display = "none";
})

loginPopup.addEventListener('click', e => {
    if(e.target == loginPopup){
        loginPopup.style.display = "none";
    }
})

const registerForm = {
    username: document.getElementById('r_username'),
    email: document.getElementById('r_email'),
    password: document.getElementById('r_password'),
    passwordRepeat: document.getElementById('r_passwordRepeat'),
    submit: document.getElementById('register_submit'),
    error: document.getElementById('error-message'),
    success :document.getElementById('success-message')
};

// register

if(registerForm.username != undefined){
    registerForm.submit.addEventListener('click', e => {
        e.preventDefault();
        const request = new XMLHttpRequest();
        const requestData = {
            username : registerForm.username.value,
            email : registerForm.email.value,
            password : registerForm.password.value,
            passwordRepeat : registerForm.passwordRepeat.value
        }
    
        request.onload = () => {
            let responseObject = null;
            try {
                responseObject = JSON.stringify(request.responseText);
            } catch (e) {
                console.error('Could not parse JSON');
            }
    
            if(responseObject){
                handleResponse(responseObject);
                
            }
        }
        const fields = JSON.stringify(requestData);
    
        request.open("post", '/Code1/functions/register.php');
        request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        request.send(fields);
    });
    
    function handleResponse (responseObject) {
        const response = JSON.parse(JSON.parse(responseObject));
        if (response.ok) {
            registerForm.error.style.display = "none";
            while (registerForm.success.firstChild) {
                registerForm.success.removeChild(registerForm.success.firstChild);
            }
    
            response.error.forEach(success => {
                const li = document.createElement('li');
                li.textContent = success;
                registerForm.success.appendChild(li);
            });
    
            registerForm.success.style.display = "block";
        } else {
            registerForm.success.style.display = "none";
            while (registerForm.error.firstChild) {
                registerForm.error.removeChild(registerForm.error.firstChild);
            }
    
            response.error.forEach(error => {
                const li = document.createElement('li');
                li.textContent = error;
                registerForm.error.appendChild(li);
            });
    
            registerForm.error.style.display = "block";
        }
    }
}

const loginForm = {
    username: document.getElementById('l_username'),
    password: document.getElementById('l_password'),
    submit: document.getElementById('submit-login'),
    error: document.getElementById('login-error-message')
}

// login

if(loginForm.username != undefined){
    loginForm.submit.addEventListener('click', e => {
        e.preventDefault();
        const request = new XMLHttpRequest();

        const requestData = {
            username: loginForm.username.value,
            password: loginForm.password.value
        }

        request.onload = () => {
            let responseObject = null;
            try {
                responseObject = JSON.stringify(request.responseText); 
            } catch (e) {
                console.error('Could not parse JSON');
            }

            if(responseObject){
                // console.log(responseObject)
                loginResponse(responseObject);
            }

        }
            const fields = JSON.stringify(requestData);
            
            request.open("post", '/Code1/functions/login.php');
            request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            request.send(fields);
    })
}

function loginResponse(responseObject){
    const response = JSON.parse(JSON.parse(responseObject));
    if(response.ok){
        location.reload();
    } else {
            while (loginForm.error.firstChild) {
                loginForm.error.removeChild(loginForm.error.firstChild);
            }
    
            response.error.forEach(error => {
                const li = document.createElement('li');
                li.textContent = error;
                loginForm.error.appendChild(li);
            });
    
            loginForm.error.style.display = "block";
    }
}