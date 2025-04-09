const form = document.querySelector("form");

form.addEventListener("submit", function (event) {
    event.preventDefault();
    const formData = new FormData(form);

    const data = Object.fromEntries(formData.entries());            // Turn a list of list into a dictionary (JSON like)
    data.action = "register";                                                   // Add the action to the data object (API requires it)

    console.log(JSON.stringify(data));

    // After retrieving the data, send it to the server
    fetch("/1PHPD/API/client.php", {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "Content-Type": "application/json"
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === "Success") {
                console.log("Success:", data.message);
                window.location.href = '/1PHPD/Assets/user/login.php';
            } else{
                console.error("Error:", data.errorMessage);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
})