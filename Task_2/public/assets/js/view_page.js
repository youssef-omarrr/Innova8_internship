// Wait until the entire HTML document has been fully loaded and parsed
document.addEventListener("DOMContentLoaded", () => {

    // Get reference to the hidden login div and the close button
    const loginBox = document.getElementById("login");
    const closeBtn = document.getElementById("close-login");
    const overlay = document.getElementById("overlay");

    // Get hidden input fields inside the login div that will store action type (edit/delete) and the user ID
    const actionInput = document.getElementById("login-action");
    const userIdInput = document.getElementById("login-user-id");

    // Loop through all elements with class "btn" (these are the Edit and Delete buttons next to each entry)
    document.querySelectorAll(".btn").forEach(button => {

        // Add click event listener to each button
        button.addEventListener("click", () => {

            // Get the data-id attribute (user ID) from the clicked button
            const userId = button.dataset.id;

            // Get the data-action attribute (edit or delete) from the clicked button
            const action = button.dataset.action;

            // console.log("Button clicked:");
            // console.log("User ID:", userId);
            // console.log("Action:", action);

            // Store the values in hidden inputs inside the login form
            userIdInput.value = userId;
            actionInput.value = action;

            // Make the hidden login box visible by adding a class (e.g., class "show" sets opacity to 1)
            loginBox.classList.add("show");
            overlay.style.display = "block"; // <- SHOW OVERLAY
        });
    });

    closeBtn.addEventListener("click", ()=>{
        loginBox.classList.remove("show");
        overlay.style.display = "none"; // <- HIDE OVERLAY
    });
});
