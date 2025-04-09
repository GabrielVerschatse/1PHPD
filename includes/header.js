// Try to obtain the current user in the session

let user = sessionStorage['id'] ? JSON.parse(sessionStorage['id']) : null;


// If the user is logged in, show the logout button
if (user) {
    let notLoginElements = document.getElementsByClassName('not-login');
    for (let element of notLoginElements) {
        element.classList.add("invisible");
        element.classList.remove("visible");
    }

    let loginElements = document.getElementsByClassName('login');
    for (let element of loginElements) {
        element.classList.add("visible");
        element.classList.remove("invisible");
    }
}

console.log("User ID: ", user);




// Handle buttons redirection

if (document.getElementById('login-button')) {
    document.getElementById('login-button').onclick = function () {
        window.location.href = 'Assets/pages/login.php  ';
    }
} else if (document.getElementById('user-button')) {
    document.getElementById('user-button').onclick = function () {
        window.location.href = 'Assets/pages/user.php  ';
    }
} else if (document.getElementById('cart-button')) {
    document.getElementById('cart-button').onclick = function () {
        sessionStorage.clear();
        window.location.href = 'Assets/pages/cart.php  ';
    }
}