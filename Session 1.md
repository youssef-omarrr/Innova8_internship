# Session 1
### **Section 1.2: Hello, World!**

- The simplest output in PHP uses either `echo` or `print`:
    
    ```php
    echo "Hello, World!\n";
    print "Hello, World!\n";
    ```
    
- **Differences** between `echo` and `print`:
    
    - `echo` is slightly faster and can take multiple arguments.
        
    - `print` returns `1`, whereas `echo` does not return a value.
        
- Both are **language constructs**, not functions, where parentheses are optional.
    
- You can also use `printf()` for formatted output:
    
    ```php
    printf("%s\n", "Hello, World!");
    ```
    

---

### **Section 1.3: Non-HTML Output from Web Server**

- `header()` function is used to send raw HTTP header:
	```php
	header (string $header, bool $replace = true, int $response_code = 0): void
	```
	
- Use `header()` to change content type before output:
    ```php
    header("Content-Type: text/plain");
    echo "Hello World";
    ```
    output:
	```php
	Hello World
	```
    
- For JSON output, use "application/json":
    
    ```php
    header("Content-Type: application/json");
    
   // Create a PHP data array. 
   $data = ["response" => "Hello World"];
    
   // json_encode will convert it to a valid JSON string. 
   echo json_encode($data);
    ```
	output:
	```php
	{"response": "Hello World"}
	```
    
- **Important:** `header()` must be called before **any output**, or it will trigger a warning.
	```php
	// Error: We cannot send any output before the headers 
	echo "Hello"; 
	// All headers must be sent before ANY PHP output 
	header("Content-Type: text/plain"); 
	echo "World";
	```
    
- **Best Practice:** *Avoid* whitespace before `<?php` and *skip* the closing `?>` in pure PHP files, because the output of the `header()` function is the **first byte** that's sent.
    

---

### **Section 1.4: PHP Built-in Server**

- It can be started by using the -S flag:
	 ```shell
	 php -S <host/ip>:<port>
	```

- From PHP 5.4+, you can run a local server using:
    
    ```bash
    php -S localhost:8080
    ```
    
- The default document root is the current directory. You can override it with `-t`:
    
    ```bash
    php -S localhost:8080 -t public/
    ```
    
- Logs are printed in the terminal for each request, useful for debugging.
    

---

### **Section 1.7: PHP Tags**

PHP supports several tag styles to embed code:

1. **Standard Tags** (Always recommended):
    
    ```php
    <?php echo "Hello"; ?>
    ```
    
2. **Echo Short Tags** (Always enabled since PHP 5.4):
    
    ```php
    <?= "Hello" ?>
    ```
    
3. **Short Tags** (Discouraged):
    
    ```php
    <? echo "Hello"; ?>
    ```
    
    - Controlled by `short_open_tag` in `php.ini`.
        
    - Not recommended for portability.
        
4. **ASP Tags** (Deprecated and removed in PHP 7.0):
    
    ```php
    <% echo "Hello"; %>
    ```
    
    - Do not use.
        

>  **Best Practice:** Use `<?php ... ?>` or `<?= ... ?>` only.

---

### **Section 1.6: Instruction Separation**

- Statements in PHP are terminated by a **semicolon (`;`)**.
    
- Closing PHP tags (`?>`) are **optional** at the end of a file but **required** if HTML follows.
    
- Example:
    
    ```php
    <?php echo "Hello"; ?>
    <p>This is HTML</p>
    ```
    
- You can omit the final `?>` if the file contains **only PHP**.
```php
<?php echo "No error"; // no closing tag is needed as long as there is no code below
```


> It is generally recommended to *always* use a semicolon and use a closing tag for every PHP code block **except** the *last* PHP code block, if no more code follows that PHP code block.
---

### **Section 1.5: PHP CLI (Command Line Interface)**

- Run PHP scripts outside the web server:
    
    1. From a file:
        
        ```bash
        php script.php
        ```
        
    2. Inline code:
        
        ```bash
        php -r 'echo "Hello world!";'
        ```
        
    3. Piped code:
        
        ```bash
        echo '<?php echo "Hi"; ?>' | php
        ```
        
    4. Interactive mode:
        
        ```bash
        php -a
        ```
        
- Outputs go to:
    
    - `stdout` (e.g., `echo`, `print`)
        
    - `stderr` (e.g., `trigger_error`, `fwrite(STDERR, ...)`)
        
- Great for scripting, automation, and debugging.
    

---