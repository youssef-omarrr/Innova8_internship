##  **PHP Security & Input Handling**

### `password_hash()`

- Used to securely hash passwords before storing in the database.
    
- Automatically uses a strong algorithm (default: `bcrypt`).
    
- Example:
    
    ```php
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    ```
    

---

### `htmlspecialchars(trim($_POST[$field] ?? $default))`

Sanitizes user input:

- `trim()`: Removes leading/trailing spaces.
    
- `?? $default`: Avoids "undefined index" warnings by using a fallback value.
    
- `htmlspecialchars()`: Converts special characters to HTML entities to prevent XSS.
    

---

### `addslashes()`

- Escapes characters like `'`, `"`, `\`, and `NULL`.
    
- Often used to escape strings before including them in JavaScript or SQL.
    
- Example:
    
    ```php
    echo "<script>alert('" . addslashes($message) . "');</script>";
    ```
    

---

##  **Database Queries with Prepared Statements**

### `mysqli_prepare($this->conn, $sql)`

- Prepares a SQL statement with placeholders (`?`) to prevent SQL injection.
    
- `$this->conn`: MySQL connection object.
    
- `$sql`: SQL string, e.g.:
    
    ```php
    $sql = "INSERT INTO users (name, email) VALUES (?, ?)";
    ```
    

### Error Handling Example:

```php
$stmt = mysqli_prepare($this->conn, $sql);

if (!$stmt) {
    die("SQL error: " . mysqli_error($this->conn));
}
```

- If preparation fails (e.g., due to bad SQL), `die()` prints the error and stops execution.
    

---

### `fetch_assoc()` in PHP

- Retrieves a row from a `mysqli_result` as an **associative array**.
    
- Access values by column names:
    
    ```php
    $row = $result->fetch_assoc();
    echo $row['username'];
    ```
    
- Looping through results:
    
    ```php
    while ($row = $result->fetch_assoc()) {
        echo $row['email'];
    }
    ```
    

---

## **Form Data Handling**

### Hidden Inputs in HTML

```html
<input type="hidden" name="action" id="login-action" />
<input type="hidden" name="user_id" id="login-user-id" />
```

- Not visible on the page.
    
- Included in form submission.
    
- Set dynamically using JavaScript (e.g. to send user ID or action type).
    

### Example Use Case:

**Button:**

```html
<button class="btn delete-btn" data-id="7" data-action="delete">Delete</button>
```

**JavaScript:**

```javascript
userIdInput.value = 7;
actionInput.value = "delete";
```

**Form Submission:**

```php
$_POST['action'];   // "delete"
$_POST['user_id'];  // 7
```

**Advantage:**  
You can use **one login form** for multiple operations (edit, delete) based on dynamic hidden inputs.

---

## **Useful PHP Functions**

### `implode()`

- Joins array elements into a single string using a separator.
    
- Example:
    
    ```php
    $hobbies = ['Reading', 'Coding'];
    $result = implode(', ', $hobbies);  // "Reading, Coding"
    ```
    

---

## **Schema Tip: Email Field Length**

```sql
email VARCHAR(191) NOT NULL UNIQUE
```

- `191` characters is a safe limit.
    
- Ensures compatibility with `utf8mb4` (which may use up to 4 bytes per character → 191 × 4 = 764 bytes, just under MySQL’s 767-byte limit).
    

---

## **Client-Side Alert on Error (PHP + JS)**

```php
echo "<script>alert('Passwords do not match.'); window.history.back();</script>";
exit;
```

- `alert()`: Shows popup message to the user.
    
- `window.history.back()`: Takes user to the previous page (typically the form).
    
- `exit`: Halts PHP execution to avoid running any more code.
    

---