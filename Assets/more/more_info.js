document.addEventListener("DOMContentLoaded", () => {
    const addToCartButton = document.getElementById("addToCart");
    const urlParams = new URLSearchParams(window.location.search);
    const movieId = urlParams.get("id");

    if (addToCartButton && movieId) {
        addToCartButton.addEventListener("click", async (event) => {
            event.preventDefault();

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