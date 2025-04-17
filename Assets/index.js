loadMovies()

async function loadMovies() {
    let movies = await fetch("http://localhost/1PHPD/API/movie.php?genre=")
    movies = await movies.json()

    movies.forEach((film) => {
        const movie = document.createElement('div');
        movie.innerHTML = `
                    <div class="col">
                        <div class="card">
                            <img src=${film.video} class="card-img-top img-fluid pt-2" style="max-height: 350px; object-fit: contain;" alt="${film.title}">
                            <div class="card-body">
                                <h5 class="card-title">${film.title}</h5>
                                <small class="text-body-secondary">${film.release_date} |</small>
                                <small class="text-body-secondary">Price : ${film.price} |</small>
                                <small class="text-body-secondary">Genre : ${film.genre}</small>
                                <p class="card-text">${film.small_description}</p>
                                <div class="d-flex justify-content-center">
                                    <button type="button" class="btn btn-danger">Plus d'informations</button>
                                </div>
                            </div>
                        </div>
                    </div>`
        // Add the redirection to the button
        movie.querySelector("button").addEventListener("click", function() {
            window.location.href = `/1PHPD/Assets/more/more_info.php?id=${film.id}`
        })

        document.querySelector("main div").appendChild(movie);
    })
}