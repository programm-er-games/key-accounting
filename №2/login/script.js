const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');
let sign_in_message = document.getElementById("sign_in").getElementsByTagName("p");
let sign_up_message = document.getElementById("sign_up").getElementsByTagName("p");

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
    document.title = "Register";
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
    document.title = "Login";
});

// function sign_up() {
//     let form = document.getElementById("sign_up");

//     let name = form.elements.name.value;
//     let surname = form.elements.surname.value;
//     let email = form.elements.email.value;
//     let password = form.elements.password.value;
    
//     // $.ajax({
//     //     type: 'post',
//     //     url: 'http://test/event_register_2/key-accounting/%E2%84%962/login/sign_up.php',
//     //     data: {
//     //         sign_up_name: name, 
//     //         sign_up_surname: surname, 
//     //         sign_up_email: email, 
//     //         sign_in_password: password
//     //     },
//     //         success: function(data) {
//     //         console.log(data);
//     //     }
//     // });
    
//     let xmlhttp = new XMLHttpRequest();
//     xmlhttp.onreadystatechange = function() {
//         if (this.readyState == 4 && this.status == 200) {
//             form.getElementsByClassName("sign_up").content = this.response;
//             alert(this.response);
//         }
//     };
//     xmlhttp.open("POST", "sign_up.php", true);
//     xmlhttp.send("n=" + name + "&s=" + surname + "&e=" + email + "&p=" + password);
//     return;
// }

// function sign_in() {
//     let form = document.getElementById("sign_in");

//     let email = form.elements.email.value;
//     let password = form.elements.password.value;

//     // $.ajax({
//     //     type: 'post',
//     //     url: 'http://event-register/event_register_2/login/sign_in.php',
//     //     data: {
//     //         sign_in_email: email, 
//     //         sign_in_password: password
//     //     },
//         //     success: function(data) {
//         //     console.log(data);
//         // }
//     // });
//     let xmlhttp = new XMLHttpRequest();
//     xmlhttp.onreadystatechange = function() {
//         if (this.readyState == 4 && this.status == 200) {
//             document.getElementById("message").content = this.responseText;
//         }
//     };
//     let params = "e=" + email + "&p=" + password;
//     xmlhttp.open("GET", "sign_in.php?" + params, true);
//     xmlhttp.send();
//     return;
// }