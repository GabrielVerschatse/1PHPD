// Try to obtain the current user in the session

let user = sessionStorage['user'] ? JSON.parse(sessionStorage['user']) : null;


// If the user is logged in, show the logout button
if (user) {
    let notLoginElements = document.getElementsByClassName('not-login');
    for (let element of notLoginElements) {
        element.classList.add("hide")
    }

    let loginElements = document.getElementsByClassName('login');
    for (let element of loginElements) {
        element.classList.remove("hide")
    }
}

console.log("User ID: ", user);




// Handle buttons redirection

document.getElementById('connexion').onclick = function () {
    window.location.href = '/1PHPD/Assets/user/login.php';
}

document.getElementById('profil').onclick = function () {
    window.location.href = '/1PHPD/Assets/user/profil.php';
}

document.getElementById('cart').onclick = function () {
    window.location.href = '/1PHPD/Assets/user/view_cart.php';
}

document.getElementById('search').onclick = function () {
    event.preventDefault()
    window.location.href = '/1PHPD/Assets/search/search.php';
}