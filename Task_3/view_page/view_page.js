// Wait until the entire HTML document has been fully loaded and parsed
document.addEventListener("DOMContentLoaded", () => {

    // Loop through all elements with class "btn" (the Edit and Delete buttons)
    document.querySelectorAll(".btn").forEach(button => {

        // Add click event listener to each button
        button.addEventListener("click", () => {

            // Get the button id
            const btn_id = button.id;

            // Split the action (edit/delete) and the user_id 
            const [action, user_id] = btn_id.split('-');

            console.log("Button clicked:");
            console.log("User ID:", user_id);
            console.log("Action:", action);

            // Redirect to the login page with user_id and action in the URL
            window.location.href = `../login_page/login_page.php?id=${user_id}&action=${action}`;

        });
    });
});
