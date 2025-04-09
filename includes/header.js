// Try to obtain the current user in the session

let user = sessionStorage['user'] ? JSON.parse(sessionStorage['user']) : null;


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

document.getElementById('connexion').onclick = function () {
    window.location.href = '/1PHPD/Assets/pages/login.php';
}

document.getElementById('profil').onclick = function () {
    window.location.href = '/1PHPD/Assets/pages/profil.php';
}

document.getElementById('cart').onclick = function () {
    sessionStorage.clear();
    window.location.href = '/1PHPD/Assets/pages/cart.php';
}