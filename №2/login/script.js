const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});

function sign_up() {
    let form = document.getElementById("sign_up");

    let name = form.elements.name.value;
    let email = form.elements.email.value;
    let password = form.elements.password.value;

    $.ajax({
        type: 'post',
        url: 'http://event-register/event_register_2/login/sign_up.php',
        data: {
            sign_up_name: name, 
            sign_up_email: email, 
            sign_up_password: password
        },
        success: function(data) {
            console.log(data);
        }
    });
}

function sign_in() {
    let form = document.getElementById("sign_in");

    let email = form.elements.email.value;
    let password = form.elements.password.value;

    $.ajax({
        type: 'post',
        url: 'http://event-register/event_register_2/login/sign_in.php',
        data: {
            sign_in_email: email, 
            sign_in_password: password
        },
        success: function(data) {
            console.log(data);
        }
    });
}