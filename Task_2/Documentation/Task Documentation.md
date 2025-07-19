## 1. JS part:

- `e.preventDefault()`: Stops the default form submission (which reloads the page)
---
- This code handles the *asynchronous* form submission to the server without reloading the page:
	```javascript
	const response = await fetch("../src/controllers/register_handler.php", {
	    method: "POST",   // Use POST to send data securely
	    body: formData    // Send the collected form data to the PHP backend
	});
	```
	- This sends the `formData` object to the PHP handler via a `POST` request using the `Fetch API`.
	- The PHP file (`register_handler.php`) processes the data (e.g., validates input, saves to the database).
	```javascript
	const result = await response.text();
	```
	- Awaits the server’s response and reads it as **plain text** (e.g., "Registered successfully" or an error message).
---
- **Hidden inputs**: are HTML form elements that are **not visible to the user** but are still included when the form is submitted. They are used to pass *extra data* to the server without requiring user interaction.

	```html
	<input type="hidden" name="action" id="login-action" /> <!-- Edit/Delete -->
	<input type="hidden" name="user_id" id="login-user-id" />
	```
	```javascript
	const actionInput = document.getElementById("login-action");
	const userIdInput = document.getElementById("login-user-id");
	```

	- In the JavaScript, these elements are accessed so their values can be set dynamically when the user clicks **Edit** or **Delete**.
	    
	- When the form is submitted, these values are sent along with the visible email and password inputs to the backend for processing.
---
- This code extracts custom data attributes from a button that the user clicks:
	```javascript
	const userId = button.dataset.id;
	const action = button.dataset.action;
	```

	#### **What It Does:**
	
	- `button.dataset` is an object containing all `data-*` attributes defined in the HTML element.
	- `data-id` and `data-action` are custom HTML attributes used to store:
	    - **`data-id`** → the user’s unique ID
	    - **`data-action`** → the intended operation (`edit` or `delete`)
	        
	
	#### **Example HTML:**
	```html
	<button class="btn" data-id="5" data-action="edit">Edit</button>
	<button class="btn" data-id="5" data-action="delete">Delete</button>
	```
	
	#### **Result:**
	- If the user clicks "Edit":
	    - `userId = "5"`
	    - `action = "edit"`
	        
	- These values can then be used to populate hidden inputs or control form logic.

---
## 2. PHP part:

### **MySQL functions Syntax**

1. **`mysqli_connect($this->host, $this->user, $this->pass, $this->dbname);`**  
    Attempts to establish a **new connection** to the MySQL database using the specified host, username, password, and database name.
    
2. **`mysqli_connect_error();`**  
    Returns the **error** message if the connection to the MySQL database fails.
    
3. **`$create_table_query = "...";`**  
    Prepares a **SQL statement** as a string to create a table named `users` if it doesn't already exist.
    
4. **`mysqli_query($this->conn, $create_table_query);`**  
    **Executes** the SQL query on the connected database and returns `true` on success or `false` on failure.
    
5. **`mysqli_error($this->conn);`**  
    Retrieves the **error message** from the last MySQL operation if the query execution failed.
    
6. **`mysqli_prepare($this->conn, $sql);`**  
    Prepares an **SQL statement** for execution to **safely** run queries and prevent **SQL injection**.
    
7. **`mysqli_stmt_bind_param($stmt, $types, $var1, ...);`**  
    **Binds parameters** to the prepared SQL statement using type definitions (`s`, `i`, `d`, `b`).
    
8. **`mysqli_stmt_execute($stmt);`**  
    Executes the **prepared and bound** SQL statement on the database.
    
9. **`mysqli_stmt_close($stmt);`**  
    **Closes** the prepared SQL statement and frees system resources.
    
10. **`mysqli_stmt_error($stmt);`**  
    Retrieves the **error message** from the most recent operation on the statement.
####  **Example: Insert a new user into the `users` table**

```php
// 1. Connect to the database
$conn = mysqli_connect($host, $user, $pass, $dbname);

// 2. Check connection error
if (mysqli_connect_error()) {
    die("Connection failed: " . mysqli_connect_error());
}

// 3. Prepare the SQL query
$sql = "INSERT INTO users (first_name, last_name, email) VALUES (?, ?, ?)";

// 4. Prepare the statement
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    die("Prepare failed: " . mysqli_error($conn));
}

// 5. Assign values to variables
$first_name = "Youssef";
$last_name = "Omar";
$email = "you@example.com";

// 6. Bind parameters
mysqli_stmt_bind_param($stmt, "sss", $first_name, $last_name, $email);

// 7. Execute the statement
if (!mysqli_stmt_execute($stmt)) {
    die("Execute failed: " . mysqli_stmt_error($stmt));
}

// 8. Close the statement
mysqli_stmt_close($stmt);

// 9. Close the connection (optional best practice)
mysqli_close($conn);
```

#### Used Functions (in order):

1. `mysqli_connect()` – Connects to DB
    
2. `mysqli_connect_error()` – Checks for connection failure
    
3. `mysqli_prepare()` – Prepares SQL safely
    
4. `mysqli_error()` – Gets error if prepare fails
    
5. `mysqli_stmt_bind_param()` – Binds user input
    
6. `mysqli_stmt_execute()` – Executes the query
    
7. `mysqli_stmt_error()` – Gets execution error
    
8. `mysqli_stmt_close()` – Frees statement resources
    
9. `mysqli_close()` – Ends the DB connection
    
---
- **`$result = $stmt->get_result();`**  
Retrieves the **result set** from the executed prepared statement (`$stmt`) as a `mysqli_result` object (like what `mysqli_query()` returns).


- **`$row = $result->fetch_assoc()`**  
Fetches the **next row** from the result as an **associative array** (like a **dictionary** in python).

---
### **PHP functions:**

- `array_map('htmlspecialchars', $_POST[$field])`: 
	Applies a given function (`htmlspecialchars` here) **to each element** of the array. Used to sanitize *each* hobby value.
    
- `htmlspecialchars( trim(...) )`:
	`trim()` Trims whitespace and `htmlspecialchars()` escapes HTML characters to prevent XSS (Cross-site scripting).

- `password_hash($password, PASSWORD_BCRYPT)`:  
    Hashes the plain password using the secure **BCRYPT** algorithm, safe to store in the database.
    
- `password_verify($password, $row['password'])`:  
    Checks if the plain password matches the **hashed password** (from the database), used during login.