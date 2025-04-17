document.addEventListener("DOMContentLoaded", () => {
    const searchForm = document.getElementById("searchForm");
    const searchResults = document.getElementById("searchResults");

    searchForm.addEventListener("submit", async (event) => {
        event.preventDefault();

        const searchInput = document.getElementById("search1").value;
        const genreInput = document.getElementById("genre");
        const sortInput = document.getElementById("sort");
        const search = searchInput.trim();
        const genre = genreInput.value;
        const sort = sortInput.value;

        const searchType = document.querySelector('input[name="search_type"]:checked').value;

        if (search === "") {
            searchResults.innerHTML = `
                <div class="text-center text-danger">
                    <p>Veuillez entrer des termes de recherche</p>
                </div>
            `;
            return;
        }

        try {
            let apiUrl = `../../API/movie.php?${searchType}=${search}?${genre}?${sort}`;

            const response = await fetch(apiUrl);

            if (!response.ok) {
                throw new Error(`Erreur serveur : ${response.statusText}`);
            }

            const responseText = await response.text();
            let movies = [];

            try {
                movies = JSON.parse(responseText);
                if (!Array.isArray(movies)) {
                    throw new Error("Réponse invalide de l'API");
                }
                if (movies.length === 0) {
                    throw new Error("Aucun film trouvé");
                }
            } catch (error) {
                throw new Error("Réponse invalide de l'API : " + responseText);
            }

            displayMovies(movies);
        } catch (error) {
            searchResults.innerHTML = `
                <div class="text-center text-danger">
                    <p>${error.message}</p>
                </div>
            `;
        }
    });

    function displayMovies(movies) {
        searchResults.innerHTML = "";

        movies.forEach((movie) => {
            const movieCard = document.createElement("div");
            movieCard.className = "card mb-3 movie-card";

            const cardBody = document.createElement("div");
            cardBody.className = "card-body";

            const title = document.createElement("h5");
            title.className = "card-title";
            title.textContent = movie.title;

            const genre = document.createElement("p");
            genre.className = "card-text";
            genre.textContent = `Genre : ${movie.genre}`;

            const releaseDate = document.createElement("p");
            releaseDate.className = "card-text";
            releaseDate.textContent = `Date de sortie : ${movie.release_date}`;

            const btnContainer = document.createElement("div");
            btnContainer.className = "d-flex gap-2";

            const moreInfo = document.createElement("button");
            moreInfo.className = "btn btn-primary";
            moreInfo.textContent = "En savoir plus";
            moreInfo.onclick = () => {
                window.location.href = `/1PHPD/Assets/more/more_info.php?id=${movie.id}`;
            };

            const addCart = document.createElement("button");
            addCart.className = "btn btn-secondary add-to-cart-btn";
            addCart.dataset.movieId = movie.id; // Stocker l'ID du film dans un attribut data
            addCart.textContent = "Ajouter au panier";

            // Ajouter le gestionnaire d'événement directement
            addCart.addEventListener("click", async () => {
                const movieId = movie.id;

                // Vérifier si l'utilisateur est connecté
                let user = null;
                const userString = sessionStorage.getItem("user");

                if (userString) {
                    try {
                        user = JSON.parse(userString);
                        if (!user.id || !user.token) {
                            throw new Error("Données utilisateur invalides");
                        }
                    } catch (e) {
                        console.error("Erreur parsing user ou données invalides:", e);
                        user = null;
                    }
                }

                if (!user) {
                    console.error("Utilisateur non connecté ou données invalides");
                    window.location.href = "/1PHPD/Assets/user/login.php";
                    return;
                }

                const userId = user.id;
                const token = user.token;

                try {
                    const data = {
                        user_id: userId,
                        token: token,
                        movie_id: movieId,
                        action: "add_cart"
                    };

                    const response = await fetch("/1PHPD/API/cart.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify(data)
                    });

                    if (response.ok) {
                        try {
                            const result = await response.json();
                            showToast("Succès", "Film ajouté au panier avec succès !", "success");
                        } catch (e) {
                            console.error("Erreur lors du traitement de la réponse:", e);
                            showToast("Erreur", "Une erreur est survenue lors du traitement de la réponse.", "danger");
                        }
                    } else {
                        try {
                            const error = await response.json();
                            showToast("Erreur", `Erreur: ${error.message || error}`, "danger");
                        } catch (e) {
                            console.error("Erreur lors de la récupération de l'erreur API:", e);
                            showToast("Erreur", "Une erreur inconnue est survenue.", "danger");
                        }
                    }
                } catch (error) {
                    console.error("Erreur lors de l'ajout au panier:", error);
                    showToast("Erreur", "Une erreur est survenue lors de l'ajout au panier.", "danger");
                }
            });

            btnContainer.appendChild(moreInfo);
            btnContainer.appendChild(addCart);

            cardBody.appendChild(title);
            cardBody.appendChild(genre);
            cardBody.appendChild(releaseDate);
            cardBody.appendChild(btnContainer);
            movieCard.appendChild(cardBody);
            searchResults.appendChild(movieCard);
        });
    }

    function showToast(title, message, type = "success") {
        let toastContainer = document.getElementById("toast-container");
        if (!toastContainer) {
            toastContainer = document.createElement("div");
            toastContainer.id = "toast-container";
            toastContainer.className = "toast-container position-fixed bottom-0 end-0 p-3";
            document.body.appendChild(toastContainer);
        }

        const toastId = `toast-${Date.now()}`;
        const toastHtml = `
        <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-${type} text-white">
                <strong class="me-auto">${title}</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;

        toastContainer.innerHTML += toastHtml;

        const toastElement = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastElement, {
            autohide: true,
            delay: 3000
        });
        toast.show();

        toastElement.addEventListener('hidden.bs.toast', () => {
            toastElement.remove();
        });
    }

});