let user = sessionStorage['user'] ? JSON.parse(sessionStorage['user']) : null;


// If a user is logged in, show the logout button and hide the login button
if (user){
    let logins = document.getElementsByClassName("not-login");
    for (element of logins){
        element.class.add("invisible");
        element.class.remove("visible");
    }

    let logouts = document.getElementsByClassName("login");
    for (element of logouts){
        element.class.add("visible");
        element.class.remove("invisible");
    }
}