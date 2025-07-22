## **Difference between sessions and cookies**

###  **Session**

- **Stored**: On the **server**.
    
- **Identified by**: A `PHPSESSID` cookie in the browser.
    
- **Lifetime**:
    
    - **By default**: Until the browser is closed (called a _session cookie_).
        
    - Can be changed using:
        
        ```php
        ini_set('session.gc_maxlifetime', 3600); // seconds
        session_set_cookie_params(3600);
        session_start();
        ```
        
- **Use case**: Storing sensitive login info, user roles, cart items.
    
- **More secure**: User can’t see session data, only the session ID.
    

---

### **Cookie**

- **Stored**: In the **browser** (client-side).
    
- **Lifetime**: You set it when creating the cookie:
    
    ```php
    setcookie("name", "value", time() + 3600); // lasts 1 hour
    ```
    
    - If you don’t set `time() + ...`, it becomes a session cookie (dies when browser closes).
        
- **Use case**: Remembering user preferences, themes, "Remember Me" login.
    
- **Less secure**: Can be modified or stolen if not handled over HTTPS.
    

---

###  Summary Table

|Feature|Session|Cookie|
|---|---|---|
|Storage|Server|Client (Browser)|
|Lifetime|Until browser closes or timeout|Custom (via `setcookie()`)|
|Capacity|Larger (server memory)|Smaller (~4 KB)|
|Security|More secure|Less secure|
|Visibility|Hidden from user|Visible to user|

---
