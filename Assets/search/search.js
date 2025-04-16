document.addEventListener("DOMContentLoaded", () => {
    const searchForm = document.getElementById("searchForm");
    const searchResults = document.getElementById("searchResults");

    searchForm.addEventListener("submit", async (event) => {
        event.preventDefault();

        const searchInput = document.getElementById("search");
        const genreInput = document.getElementById("genre");
        const sortInput = document.getElementById("sort");

        const searchTypeInputs = document.querySelectorAll('input[name="search_type"]');
        let searchType = "";
        for (const input of searchTypeInputs) {
            if (input.checked) {
                searchType = input.value;
                break;
            }
        }

        const search = searchInput && searchInput.value ? searchInput.value.trim() : "";
        let genre = "";
        let sort = "";
        if (search === "") {
            genre = genreInput && genreInput.value ? genreInput.value : "";
            sort = sortInput && sortInput.value ? sortInput.value : "";
        }

        let queryParams = new URLSearchParams();
        if (search !== "") {
            queryParams.set("search", search);
            if (searchType !== "") {
                queryParams.set("search_type", searchType);
            }
        } else {
            if (genre !== "") queryParams.set("genre", genre);
            if (sort !== "") queryParams.set("sort", sort);
        }

        try {
            console.log(queryParams.toString())
            const response = await fetch(`../../API/movie.php?${queryParams.toString()}`);
            if (!response.ok) {
                throw new Error(`Erreur serveur : ${response.statusText}`);
            }

            const responseText = await response.text();
            let movies = [];
            try {
                movies = JSON.parse(responseText);
                if (movies.length === 0) {
                    throw new Error("Aucun film trouvé");
                }
            } catch (error) {
                throw new Error("Réponse invalide de l'API : " + responseText);
            }

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

                cardBody.appendChild(title);
                cardBody.appendChild(genre);
                cardBody.appendChild(releaseDate);
                movieCard.appendChild(cardBody);
                searchResults.appendChild(movieCard);
            });
        } catch (error) {
            searchResults.innerHTML = `
                <div class="text-center text-danger">
                    <p>${error.message}</p>
                </div>
            `;
        }
    });
});