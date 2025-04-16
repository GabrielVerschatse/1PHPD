// Load data from the login user

const main_title = document.getElementById("data-insertion")
const movies = document.getElementById("card_container")

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

moviesOwn(user.id);


// Handle logout button
document.getElementById("logout").onclick = () => {
    sessionStorage.clear();
    window.location.href = '/1PHPD/index.php';
};






function showToast(message, type){
    // Toast wrapper (existing one or create a new one)
    const toastContainer = document.querySelector('.toast-container') || createToastContainer();

    // Create the toast element
    const toastHTML = `
        <div class="toast align-items-center text-bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button>
            </div>
        </div>
    `;

    // Creating a temporary div to bypass weirdo HTML parsing issues
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = toastHTML.trim();           // Without trim, extra whitespace break the whole thing
    const toastEl = tempDiv.firstChild;


    toastContainer.appendChild(toastEl);

    const toast = new bootstrap.Toast(toastEl, {
        delay: 3000,
        autohide: true
    });

    toast.show();
}

function createToastContainer() {
    // Create and insert the toast
    const container = document.createElement('div');
    container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
    document.body.appendChild(container);
    return container;
}





// Handle password change
const form = document.querySelector("form");

form.addEventListener("submit", function (event) {
    event.preventDefault();
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());

    // Before doing anything, check if the password is the same
    if (data.new_password !== data.confirm_password) {
        showToast("Les mots de passe ne correspondent pas.", "danger");
        console.log("Les mots de passe ne correspondent pas.");

    } else {
        // Add the user ID & token
        data.id = user.id;
        data.token = user.token;

        fetch("/1PHPD/API/client.php", {
            method: "PUT",
            body: JSON.stringify(data),
            headers: {
                "Content-Type": "application/json"
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    showToast("Votre mot de passe a été changé avec succès.", "success");
                } else{
                    showToast("Une erreur est survenue lors du changement de mot de passe.", "danger");
                }
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    }
})



async function moviesOwn($id) {
    const response = await fetch("/1PHPD/API/client.php?id=" + $id);
    const data = await response.json();
    console.log(data)

    // Insert the movies in the HTML
    data.forEach((movie) => {
            let card = document.createElement("div")
            card.className = "card flex-column flex-md-row p-3 gap-3 align-items-center w-100"
            card.style = "max-width: 800px; margin: auto;"
            card.innerHTML = `
            <img src=${movie.video}
                 className="img-fluid rounded"
                 style="max-height: 200px; object-fit: contain;"
                 alt="Minecraft Movie Poster"/>

            <div className="card-body">
                <h5 className="card-title">${movie.title}</h5>
                <small className="text-body-secondary">${movie.release_date} |</small>
                <small className="text-body-secondary">${movie.price} |</small>
                <small className="text-body-secondary">${movie.genre} </small>
                <p className="card-text mt-2">
                    ${movie.small_description}
                </p>
            </div>`
            movies.appendChild(card);
        }
    )
}