# Session 2 & 3

## **SQL Injection**

###  **Definition:**

SQL Injection is a **code injection attack** where malicious SQL statements are inserted into an input field, allowing attackers to interfere with the queries that an application makes to its database.

###  **Goal:**

* Bypass login
* Retrieve, modify, or delete database data
* Gain administrative rights

###  **Example:**

Suppose this SQL query checks for a valid username and password:

```sql
SELECT * FROM users WHERE username = '$user' AND password = '$pass';
```

If an attacker enters:

* `user = admin`
* `pass = ' OR '1'='1`

The resulting query becomes:

```sql
SELECT * FROM users WHERE username = 'admin' AND password = '' OR '1'='1';
```

Since `'1'='1'` is always true, this may log in the attacker without a valid password.

###  **Prevention:**

* Use **prepared statements** or **ORMs**
* Validate and sanitize user inputs
* Use **least privilege** for database users

---

## **XSS (Cross-Site Scripting)**

###  **Definition:**

XSS is a **web vulnerability** that allows attackers to inject malicious scripts into webpages viewed by other users. These scripts are usually written in JavaScript.

###  **Goal:**

* Steal session cookies
* Deface websites
* Redirect users
* Perform actions on behalf of users

###  **Example:**

If a comment form doesn’t sanitize input:

```html
<input type="text" name="comment">
```

And an attacker submits:

```html
<script>alert('Hacked!');</script>
```

Then users viewing the comment will see a popup — worse, attackers can steal cookies or perform malicious actions silently.

###  **Prevention:**

* Escape user input before rendering (`&`, `<`, `>`, etc.)
* Use Content Security Policy (CSP)
* Sanitize HTML with libraries (like DOMPurify)

---


## OOP in PHP

Here are the key differences between **abstract classes**, **interfaces**, and **traits** in PHP Object-Oriented Programming (OOP):

---

### **1. Abstract Class**

#### Purpose:

Used as a **base class** to define common behavior for related classes while enforcing implementation of certain methods.

#### Characteristics:

* Can have **abstract methods** (no body) and **concrete methods** (with body).
* Can define **properties**.
* **Supports inheritance**: A class can **extend only one** abstract class.
* Used when classes share a common "is-a" relationship.

#### Example:

```php
abstract class Animal {
    abstract public function makeSound();
    
    public function eat() {
        echo "Eating...";
    }
}

class Dog extends Animal {
    public function makeSound() {
        echo "Bark";
    }
}
```

---

### **2. Interface**

#### Purpose:

Defines a **contract** that implementing classes must follow. It is used to specify **capabilities**, not inheritance.

#### Characteristics:

* All methods are **public and abstract** by default.
* **No method bodies** allowed (until PHP 8.0, which added limited support for method bodies via default methods).
* **No properties** (prior to PHP 8.1).
* A class can **implement multiple interfaces**.
* Used for defining capabilities like `Loggable`, `Serializable`, etc.

#### Example:

```php
interface Logger {
    public function log(string $message);
}

class FileLogger implements Logger {
    public function log(string $message) {
        echo "Logging to file: $message";
    }
}
```

---

### **3. Trait**

#### Purpose:

Used to **reuse method implementations** in multiple unrelated classes, solving the problem of **horizontal code reuse**.

#### Characteristics:

* Contains **methods (with bodies)** and **properties**.
* Cannot be instantiated or extended.
* Classes **use** traits, and can **use multiple traits**.
* Traits are not a type; they are a **code inclusion mechanism**, not for enforcing contracts.

#### Example:

```php
trait LoggerTrait {
    public function log(string $msg) {
        echo "Log: $msg";
    }
}

class Service {
    use LoggerTrait;
}
```

---

### **Summary Comparison Table**

| Feature              | Abstract Class | Interface               | Trait          |
| -------------------- | -------------- | ----------------------- | -------------- |
| Can have method body | Yes            | No (until PHP 8.0)      | Yes            |
| Can have properties  | Yes            | PHP 8.1+ only           | Yes            |
| Inheritance type     | Single         | Multiple (implements)   | Multiple (use) |
| Use case             | Base class     | Contract (capabilities) | Code reuse     |
| Instantiable         | No             | No                      | No             |

---
