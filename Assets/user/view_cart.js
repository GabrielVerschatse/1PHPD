document.addEventListener('DOMContentLoaded', function() {
    let user = null;

    const userString = sessionStorage.getItem("user");
    if (userString) {
        try {
            user = JSON.parse(userString);
        } catch (e) {
            console.error("Erreur parsing user:", e);
        }
    }

    const userId = user?.id;
    const token = user?.token;

    if (!userId || !token) {
        window.location.href = '../user/login.php';
        return;
    }

    fetchCart();

    function fetchCart() {
        fetch('../../API/cart.php', {
            method: 'GET',
            headers: {
                'user_id': userId,
                'token': token
            }
        })
            .then(response => response.json())
            .then(data => {
                if (Array.isArray(data)) {
                    displayCart(data);
                } else {
                    displayEmptyCart();
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                displayEmptyCart();
            });
    }

    function displayCart(items) {
        const cartContent = document.getElementById('cart-content');
        let totalPrice = 0;

        let html = '';
        items.forEach(item => {
            const itemPrice = parseFloat(item.price);
            totalPrice += itemPrice;

            html += `
            <div class="row py-3 border-bottom" data-movie-id="${item.movie_id}">
                <div class="col-md-8">
                    <h5 class="fs-5 text-dark">${item.title}</h5>
                    <p class="text-muted">${item.genre} | ${item.release_date}</p>
                </div>
                <div class="col-md-2 text-end">
                    <span class="fw-bold text-danger">${itemPrice.toFixed(2)} €</span>
                </div>
                <div class="col-md-2 text-end">
                    <button class="btn btn-sm btn-outline-danger remove-item" data-movie-id="${item.movie_id}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg>
                    </button>
                </div>
            </div>
            `;
        });

        cartContent.innerHTML = html;

        document.getElementById('total-price').textContent = totalPrice.toFixed(2) + ' €';
        document.getElementById('total-container').classList.remove('d-none');
        document.getElementById('checkout-btn').classList.remove('d-none');

        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', function() {
                const movieId = this.getAttribute('data-movie-id');
                removeFromCart(movieId);
            });
        });
    }

    function displayEmptyCart() {
        const cartContent = document.getElementById('cart-content');
        cartContent.innerHTML = `
            <div class="text-center py-5 text-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                <h3 class="mt-3">Votre panier est vide</h3>
                <p>Découvrez notre catalogue et ajoutez des films à votre panier.</p>
                <a href="../../Assets/search/search.php" class="btn btn-danger mt-3">Parcourir le catalogue</a>
            </div>
        `;

        document.getElementById('total-container').classList.add('d-none');
        document.getElementById('checkout-btn').classList.add('d-none');
    }

    function removeFromCart(movieId) {
        fetch(`../../API/cart.php?user_id=${userId}&token=${token}&movie_id=${movieId}`, {
            method: 'DELETE'
        })
            .then(response => response.json())
            .then(data => {
                fetchCart();
                showToast("Succès", "Article supprimé du panier avec succès", "success");
            })
            .catch(error => {
                console.error('Erreur:', error);
                showToast("Erreur", "Impossible de supprimer l'article du panier", "danger");
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

    document.getElementById('checkout-btn').addEventListener('click', function() {
        alert('Fonctionnalité de paiement à implémenter');
    });
});