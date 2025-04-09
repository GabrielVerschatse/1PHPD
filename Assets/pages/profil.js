// Load data from the login user

const main_title = document.querySelector("main h1");

main_title.insertAdjacentHTML("afterend",`
    <div class='input-group mb-3'>
        <span class='input-group-text'>Nom</span>
        <p class='form-control mb-0'>${user.firstname}</p>
    </div>
    
    <div class='input-group mb-3'>
        <span class='input-group-text'>Prénom</span>
        <p class='form-control mb-0'>${user.lastname}</p>
    </div>
    
    <div class='input-group mb-3'>
        <span class='input-group-text'>Numéro de téléphone</span>
        <p class='form-control mb-0'>${user.phone ? user.phone : "Aucun"}</p>
    </div>
    
    <div class='input-group mb-3'>
        <span class='input-group-text'>Email</span>
        <p class='form-control mb-0'>${user.email}</p>
    </div>
    `);



// Handle logout button
document.getElementById("logout").onclick = () => {
    sessionStorage.clear();
    window.location.href = '/1PHPD/Assets/pages/login.php';
};


