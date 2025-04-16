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
            addCart.className = "btn btn-secondary";
            addCart.textContent = "Ajouter au panier";
            addCart.onclick = () => {
                addToCart(movie.id);
            };

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

    function addToCart(movieId) {
        const userString = localStorage.getItem('user');
        if (!userString) {
            window.location.href = '../user/login.php';
            return;
        }

        try {
            const user = JSON.parse(userString);
            const userId = user.id;
            const token = user.token;

            if (!userId || !token) {
                window.location.href = '../user/login.php';
                return;
            }

            fetch('../../API/cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'user_id': userId,
                    'token': token
                },
                body: JSON.stringify({ movie_id: movieId })
            })
                .then(response => response.json())
                .then(data => {
                    alert('Film ajouté au panier avec succès');
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur lors de l\'ajout au panier');
                });
        } catch (e) {
            console.error("Erreur parsing user:", e);
            window.location.href = '../user/login.php';
        }
    }
});