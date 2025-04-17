document.addEventListener('DOMContentLoaded', async () => {
    const urlParams = new URLSearchParams(window.location.search);
    const director = urlParams.get('director');

    if (director) {
        try {
            const response = await fetch(`../../API/movie.php?director=${encodeURIComponent(director)}??newest`);

            if (!response.ok) {
                throw new Error(`Erreur lors de la récupération des films: ${response.status}`);
            }

            let data;
            try {
                const text = await response.text();
                data = JSON.parse(text);
            } catch (err) {
                throw new Error('Erreur de format de réponse');
            }

            const moviesContainer = document.getElementById('moviesContainer');

            if (Array.isArray(data) && data.length > 0) {
                moviesContainer.innerHTML = '';

                data.forEach(movie => {
                    const movieCard = document.createElement('div');
                    movieCard.className = 'col';
                    movieCard.innerHTML = `
                        <div class="card movie-card h-100">
                            <img src="${movie.video || 'https://placehold.co/300x450?text=No+Image'}" class="card-img-top" alt="${movie.title}">
                            <div class="card-body">
                                <h5 class="card-title">${movie.title}</h5>
                                <p class="card-text">${movie.small_description || 'Pas de description'}</p>
                                <p class="card-text"><small class="text-muted">Sortie: ${movie.release_date}</small></p>
                                <a href="more_info.php?id=${movie.id}" class="btn btn-danger">Voir détails</a>
                            </div>
                        </div>
                    `;
                    moviesContainer.appendChild(movieCard);
                });
            } else {
                moviesContainer.innerHTML = '<div class="col-12"><div class="alert alert-info">Aucun film trouvé pour ce réalisateur.</div></div>';
            }
        } catch (error) {
            const moviesContainer = document.getElementById('moviesContainer');
            moviesContainer.innerHTML = `<div class="col-12"><div class="alert alert-danger">${error.message}</div></div>`;
        }
    }
});

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
        <div class="toast-body">${message}</div>
    </div>
    `;

    toastContainer.innerHTML += toastHtml;
    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement, { autohide: true, delay: 3000 });
    toast.show();

    toastElement.addEventListener('hidden.bs.toast', () => {
        toastElement.remove();
    });
}