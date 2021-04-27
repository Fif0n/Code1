const loginPopup = document.querySelector(".login-popup");

const loginBtn = document.querySelector('.log-in');

const closeBtn = document.querySelector('.close');

const loginBtn2 = document.querySelector('.log-in2');

if(loginBtn != undefined){
    loginBtn.addEventListener('click', e => {
        e.preventDefault();
        loginPopup.style.display = "block";
    });
}


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


function singleResponse(responseObject, form){
    const response = JSON.parse(JSON.parse(responseObject));
    if(response.ok){
        location.reload();
    } else {
            while (form.error.firstChild) {
                form.error.removeChild(form.error.firstChild);
            }
    
            response.error.forEach(error => {
                const li = document.createElement('li');
                li.textContent = error;
                form.error.appendChild(li);
            });
    
            form.error.style.display = "block";
    }
}
function doubleResponse(responseObject, form){
    const response = JSON.parse(JSON.parse(responseObject));
        if (response.ok) {
            form.error.style.display = "none";
            while (form.success.firstChild) {
                form.success.removeChild(form.success.firstChild);
            }
    
            response.error.forEach(success => {
                const li = document.createElement('li');
                li.textContent = success;
                form.success.appendChild(li);
            });
    
            form.success.style.display = "block";
        } else {
            form.success.style.display = "none";
            while (form.error.firstChild) {
                form.error.removeChild(form.error.firstChild);
            }
    
            response.error.forEach(error => {
                const li = document.createElement('li');
                li.textContent = error;
                form.error.appendChild(li);
            });
    
            form.error.style.display = "block";
        }
}

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
                doubleResponse(responseObject, registerForm);
                
            }
        }
        const fields = JSON.stringify(requestData);
    
        request.open("post", '/Code1/functions/register.php');
        request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        request.send(fields);
    });
    
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
                singleResponse(responseObject, loginForm);
            }

        }
            const fields = JSON.stringify(requestData);
            
            request.open("post", '/Code1/functions/login.php');
            request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            request.send(fields);
    })
}

// edit soft data

const editSoftForm = {
    username: document.getElementById('edit-soft-username'),
    email: document.getElementById('edit-soft-email'),
    password: document.getElementById('edit-soft-password'),
    submit: document.getElementById('edit-soft-submit'),
    error: document.getElementById('edit-soft-error-message')
}

if(editSoftForm.username != undefined){
    editSoftForm.submit.addEventListener('click', e => {
        e.preventDefault();
        const request = new XMLHttpRequest();

        const requestData = {
            username: editSoftForm.username.value,
            email: editSoftForm.email.value,
            password: editSoftForm.password.value
        }

        request.onload = () => {
            let responseObject = null;
            try{
                responseObject = JSON.stringify(request.responseText);
            } catch(e) {
                console.error('Could not parse JSON');
            }

            if(responseObject){
                singleResponse(responseObject, editSoftForm);
            }
        }

        const fields = JSON.stringify(requestData)

        request.open('post', '/Code1/functions/editSoft.php');
        request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        request.send(fields);
    })
}

// change password

const editPassowrdForm = {
    oldPassword: document.getElementById('edit-password-old'),
    newPassword: document.getElementById('edit-password-new'),
    repeatPassword: document.getElementById('edit-password-repeat'),
    submit: document.getElementById('edit-password-submit'),
    error: document.getElementById('edit-password-error-message')
};

if(editPassowrdForm.oldPassword != undefined){
    editPassowrdForm.submit.addEventListener('click', e => {
        e.preventDefault();
        const request = new XMLHttpRequest();

        const requestData = {
            oldPassword: editPassowrdForm.oldPassword.value,
            newPassword: editPassowrdForm.newPassword.value,
            repeatPassword: editPassowrdForm.repeatPassword.value
        }

        request.onload = () => {
            let responseObject = null;
            try{
                responseObject = JSON.stringify(request.responseText);
                
            } catch(e) {
                console.error('Could not parse JSON');
            }
            if(responseObject){
                singleResponse(responseObject, editPassowrdForm);
                
            }
        }
        const fields = JSON.stringify(requestData)
        request.open('post', '/Code1/functions/editPassword.php');
        request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        request.send(fields);
    });
}

// delete account

const delBtn = document.querySelector('.delete-button');

if(delBtn != undefined){
    const delPopup = document.querySelector('.delete-popup')
    const closeDelContent = document.querySelector('.close-delete-popup');

    delBtn.addEventListener('click', e => {
        e.preventDefault();
        delPopup.style.display = "block";
    });
    closeDelContent.addEventListener('click', e => {
        e.preventDefault();
        delPopup.style.display = 'none';
    })

    delPopup.addEventListener('click', e => {
        if(e.target == delPopup){
            delPopup.style.display = "none";
        }
    })
}
const delAccountForm = {
    password: document.getElementById('password-delete'),
    submit: document.getElementById('submit-delete'),
    error: document.getElementById('delete-error-message')
}
if(delAccountForm.submit != undefined){
    delAccountForm.submit.addEventListener('click', e => {
        e.preventDefault();
        const request = new XMLHttpRequest();

        const requestData = {
            password: delAccountForm.password.value
        };

        request.onload = () => {
            let responseObject = null;
            try{
                responseObject = JSON.stringify(request.responseText);
            } catch(e) {
                console.error('Could not parse JSON');
            }
            if(responseObject){
                singleResponse(responseObject, delAccountForm);
            }
        }
        const fields = JSON.stringify(requestData);

        request.open('post', '/Code1/functions/deleteAccount.php');
        request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        request.send(fields);     
    })
}