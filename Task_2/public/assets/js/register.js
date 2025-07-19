// Add an event listener to the form with ID "container" for when it is submitted
document.getElementById("container").addEventListener("submit", async function (e) {

    e.preventDefault(); // Stop the default form submission (which reloads the page)

    // Collects all input data from the form into a FormData object
    // Automatically includes all <input>, <select>, and <textarea> values
    const formData = new FormData(this); 

    try {
        const response = await fetch("../src/controllers/register_handler.php", {
            method: "POST",   // Use POST to send data securely
            body: formData    // Send the collected form data to the PHP backend
        });


        // Wait for the server response, and read it as plain text
        const result = await response.text(); 
        
        // Show the server's response in a popup alert
        alert("Server Response: " + result);
        
        // Only reset the form if registration is successful
        if (result.includes("successfully")) {
            this.reset();
        }

    } catch (error) {
        // Log any errors (like connection issues) to the browser console
        console.error("Error submitting form:", error); 
        
        // Show an error message to the user if something goes wrong
        alert("Submission failed. Please try again."); 
    }
});

document.getElementById("view_btn").addEventListener("click", ()=>{
    window.location.href = "../src/views/view.php"; // Opens in the same tab
    })
