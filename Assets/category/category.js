// Acquire the URL parameters using a URLSearchParams object
const parameters = new URLSearchParams(window.location.search);
const category = parameters.get('category');

// Function to fetch and display products based on the category
async function Display_movies(category) {
    try {
        const response = await fetch(`http://localhost/1PHPD/API/movie.php?genre=${category}`);
        const movies = await response.json();

        // Retrieve the list of objects and process
        const productContainer = document.querySelector("main div");

        movies.forEach((film) => {
            const productCard = document.createElement('div');
            productCard.className = 'col';
            productCard.innerHTML =`
                <div class='card'>
                    <img src=${film.video} class='card-img-top img-fluid pt-2' style='max-height: 350px; object-fit: contain;' alt='...'>
                    <div class='card-body'>
                        <h5 class='card-title'>${film.title}</h5>
                        <small class='text-body-secondary'>${film.release_date} | Price : ${film.price} | Genre : ${film.genre}</small>
                        <p class='card-text'>${film.small_description}</p>
                        <div class='d-flex justify-content-center'>
                            <button type='button' class='btn btn-danger' data-film-id='${film.id}'>Plus d'informations</button>
                        </div>
                    </div>
                </div>`;
            productContainer.appendChild(productCard);
        });

        // Attach event listeners to buttons
        const buttons = document.getElementsByClassName('btn btn-danger');
        Array.from(buttons).forEach((button) => {
            button.addEventListener('click', function() {
                const filmId = this.getAttribute('data-film-id');
                window.location.href = `/1PHPD/Assets/more/more_info.php?id=${filmId}`;
            });
        });
    } catch (error) {
        console.error('Error fetching products:', error);
    }
}

console.log(category);
Display_movies(category);