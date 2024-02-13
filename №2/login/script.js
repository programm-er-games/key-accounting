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

function sign_up() {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("sign_up_message").textContent = this.responseText;
            console.log(this.responseText);
        }
    };
    xmlhttp.open("GET", "sign_up.php");
    xmlhttp.send();
}

function sign_in() {
    // let xmlhttp = new XMLHttpRequest();
    // xmlhttp.onreadystatechange = function () {
    //     if (this.readyState == 4 && this.status == 200) {
    //         document.getElementById("sign_in_message").textContent = this.response;
    //         alert(this.response);
    //         console.log(this.responseText);
    //     }
    // };
    // xmlhttp.open("GET", "sign_in.php");
    // xmlhttp.send();
    function getCookie(name) {
        let matches = document.cookie.match(new RegExp(
          "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }
    let temp = getCookie("sign_in_res");
    alert(document.getElementById("sign_in_message"));
    document.getElementById("sign_in_message").textContent = temp;
}