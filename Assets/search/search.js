document.addEventListener("DOMContentLoaded", () => {
    const searchForm = document.getElementById("searchForm");
    const searchResults = document.getElementById("searchResults");

    searchForm.addEventListener("submit", async (event) => {
        event.preventDefault(); // Empêche le rechargement de la page

        // Récupération des valeurs du formulaire
        const search = document.getElementById("search").value.trim();
        const genre = document.getElementById("genre").value;
        const sort = document.getElementById("sort").value;

        // Construction de l'URL avec les paramètres
        const queryParams = new URLSearchParams({
            search: search,
            genre: genre,
            sort: sort
        });

        try {
            // Requête à l'API
            const response = await fetch(`../../API/movie.php?${queryParams.toString()}`);
            if (!response.ok) {
                new Error(`Erreur serveur : ${response.statusText}`);
            }

            const movies = await response.json();
            if (movies.length === 0) {
                new Error("Aucun film trouvé");
            }

            // Affichage des résultats
            searchResults.innerHTML = ""; // Réinitialise les résultats
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

                cardBody.appendChild(title);
                cardBody.appendChild(genre);
                cardBody.appendChild(releaseDate);
                movieCard.appendChild(cardBody);
                searchResults.appendChild(movieCard);
            });
        } catch (error) {
            // Affichage d'un message d'erreur
            searchResults.innerHTML = `
                <div class="text-center text-danger">
                    <p>${error.message}</p>
                </div>
            `;
        }
    });
});