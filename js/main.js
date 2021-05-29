// video 

if(document.querySelector("#my-video") != undefined){
    var video = videojs('my-video');
    
    const url = window.location.href;
    const id = url.slice(34, url.length);
    window.addEventListener("beforeunload", () => {
        // set new current time
        const onLeaveData = {
            currentTime: video.currentTime(),
            id: id
        }

        const JSONData = JSON.stringify(onLeaveData);
        request.open("post", '/Code1/functions/setCurrentTime.php');
        request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        request.send(JSONData);
        
    })
    
    const request = new XMLHttpRequest()
    request.onload = () => {
        let responseObject = null;
        try {
            responseObject = JSON.stringify(request.responseText);
        } catch (e) {
            console.error('Could not parse JSON');
        }

        if(responseObject){
            const pasrseResponseObject = JSON.parse(JSON.parse(responseObject));
            video.currentTime(pasrseResponseObject.currentTime);
        }
    }

    request.open("post", '/Code1/functions/getCurrentTime.php');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.send(id);

    
}

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

function createCourseResponse(responseObject, form){
    const response = JSON.parse(responseObject);
        if (response.ok) {
            form.courseName.value = "";
            form.courseDescription.value = "";
            form.courseMiniature.value = "";
            form.courseVideo.value = "";
            form.courseTags.value = "";
            form.coursePrize.value = "";
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

//  creating course
const createCourseForm = {
    courseName: document.getElementById('course-name'),
    courseDescription: document.getElementById('course-description'),
    courseMiniature: document.getElementById('course-miniature'),
    courseVideo: document.getElementById('course-video'),
    courseTags: document.getElementById('tags'),
    coursePrize: document.getElementById('prize'),
    submit: document.getElementById('create-course-submit'),
    error: document.getElementById('create-course-error-message'),
    success: document.getElementById('create-course-success-message')
}

if(createCourseForm.submit != undefined){
    createCourseForm.submit.addEventListener('click', e => {
        e.preventDefault();
        const request = new XMLHttpRequest();
        var requestData = new FormData();

        requestData.append('courseName', createCourseForm.courseName.value)
        requestData.append('courseDescription', createCourseForm.courseDescription.value)
        requestData.append("courseMiniature", createCourseForm.courseMiniature.files[0]);
        requestData.append("courseVideo", createCourseForm.courseVideo.files[0]);
        requestData.append("courseTags", createCourseForm.courseTags.value);
        requestData.append("coursePrize", createCourseForm.coursePrize.value);

        request.onload = () => {
            let responseObject = null;
            try{
                responseObject = request.responseText;
            } catch(e) {
                console.error('Could not parse JSON');
            }
            if(responseObject){
                createCourseResponse(responseObject, createCourseForm);
            }
        }

        request.open('post', '/Code1/functions/createCourse.php');
        
        request.send(requestData);  
    })
}

// switiching display on opinions and description
const description = document.getElementById("course-decription-btn");
const opinions = document.getElementById("course-opinions-btn");


if(description != undefined && opinions != undefined){

    const descriptionContent = document.querySelector(".course-description");
    const opinionsContent = document.createElement("div");
    opinionsContent.className = "course-opinions";
    const section = document.querySelector(".section-content");

    function showComments(){
        const request = new XMLHttpRequest();
        opinionsContent.innerHTML = '';
        descriptionContent.style.display = "none";
        section.appendChild(opinionsContent);
        description.classList.remove("active");
        opinions.classList.add("active");
       
            
            const url = window.location.href;
            const id = url.slice(34, url.length);
    
            request.onload = () => {
                let responseObject = null;
                try{
                    responseObject = request.responseText;
                } catch(e) {
                    console.error('Could not parse JSON');
                }
                if(responseObject){
                    const requestData = JSON.parse(responseObject);
                    if(!requestData[requestData.length-1].owner == true){
                        opinionsContent.innerHTML += `
                        <h1>Opinie</h1>
                        <form>
                            <label for="opinion_content">Podziel się opinią</label>
                            <textarea id="opinion_content" cols="20" rows="10"></textarea>
                            <label for="opinion_rating">Oceń w skali od 1 do 5</label>
                            <input type="number" min="1" max="5" id="opinion_rating">
                            <button id="opinion_submit" required>Opublikuj</button>
                        </form>`;
                    }
                    
                    if(requestData[0].username == undefined){
                        opinionsContent.innerHTML += `
                            <h2>Brak opini</h2>
                        `
                    } else {
                        for(let i = 0; i<=requestData.length-2; i++){
                            opinionsContent.innerHTML += `
                            <div class="opinion-card">
                                <div class="opinion-card-header">
                                    <h3>${requestData[i]['username']}</h3>
                                    <p>${requestData[i]['opinionDateTime']}</p>
                                </div>
                                <div class="opinion-card-content">
                                    <p>${requestData[i]['opinionContent']}</p>
                                </div>
                                <div class="opinion-card-rating">
                                    <p>Ocena: ${requestData[i]['rating']}/5</p>
                                </div>
                            </div>`;
                        }
                    }
                    
                    if(!requestData[requestData.length-1].owner == true){
                        document.querySelector("#opinion_submit").addEventListener("click", e => {
                            const addOpinionForm = {
                                opinionContent: document.getElementById("opinion_content"),
                                opinionRating: document.getElementById("opinion_rating"),
                                submit: document.getElementById("opinion_submit")
                            }
                                e.preventDefault();
                                const opinionRequest = new XMLHttpRequest();
                        
                                const url = window.location.href;
                                const id = url.slice(34, url.length);
                        
                                const requestData = {
                                    opinionContent: addOpinionForm.opinionContent.value,
                                    opinionRating: addOpinionForm.opinionRating.value,
                                    courseId: id
                                };
                        
                                opinionRequest.onload = () => {
                                    let responseObject = null;
                                    try{
                                        responseObject = JSON.stringify(request.responseText);
                                    } catch(e) {
                                        console.error('Could not parse JSON');
                                    }
                                    if(responseObject){
                                        showComments()
                                    }
                                }
                                const fields = JSON.stringify(requestData);
                                opinionRequest.open('post', '/Code1/functions/addOpinion.php');
                                opinionRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                                opinionRequest.send(fields);       
                        })
                    }
                }
                
                    }
                    request.open('post', '/Code1/functions/getOpinions.php');
                request.send(id);
                    
    }

    // show course description
    
    description.addEventListener('click', () => {
        opinionsContent.remove();
        descriptionContent.style.display = "block";
        description.classList.add("active");
        opinions.classList.remove("active");
    })
    // show opinions
    opinions.addEventListener('click', () => {    
        showComments();
    });

}
// edit course
const editCourseBtn = document.getElementById("course-edit-btn");
if(editCourseBtn != undefined){
    const editPopup = document.querySelector(".edit-popup");
    editCourseBtn.addEventListener("click", () => {
        
        editPopup.style.display = "flex"
    })
    const closeEditBtn = document.querySelector('.close-edit')
    closeEditBtn.addEventListener('click', () => {
        editPopup.style.display = "none";
    })
    
    editPopup.addEventListener('click', e => {
        if(e.target == editPopup){
            editPopup.style.display = "none";
        }
    })

    const editCourseForm = {
        name: document.getElementById("edit-course-name"),
        description: document.getElementById("edit-course-description"),
        prize: document.getElementById("edit-course-prize"),
        submit: document.getElementById("edit-course-submit"),
        error: document.getElementById("edit-course-error-message")
    }
    editCourseForm.submit.addEventListener("click", e => {
        e.preventDefault();
        const request = new XMLHttpRequest();
        const url = window.location.href;
        const id = url.slice(34, url.length);
        const requestData = {
            name: editCourseForm.name.value,
            description : editCourseForm.description.value,
            prize: parseFloat(editCourseForm.prize.value),
            id: id
        };

        request.onload = () => {
            let responseObject = null;
            try{
                responseObject = JSON.stringify(request.responseText);
            } catch(e) {
                console.error('Could not parse JSON');
            }
            if(responseObject){
                singleResponse(responseObject, editCourseForm);
            }
        }
        const fields = JSON.stringify(requestData);

        request.open('post', '/Code1/functions/editCourse.php');
        request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        request.send(fields);     
    })
}