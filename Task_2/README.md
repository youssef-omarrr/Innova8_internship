![[Documentation/PASTED_IMG.png]]

---

###  File Structure Breakdown
#### **Registration Module**
- `registeration.html`  
  *Client-side registration form* (HTML markup)
- `registration_page.css`  
  *Styles for registration page* (visual presentation)
- `register.js`  
  *Client-side validation/behavior* (passes data to php file)
- `register.php`  
  *Server-side registration handler* (processes form submission, saves to DB)
####  **Profile Management**
- `view.php`  
  *Profile display page* (reads user data from DB)
- `view_page.css`  
  *Profile view styling*
- `view_page.js`  
  *Profile page interactivity* (opens login menu when edit/delete are selected)
- `edit.php`  
  *Profile editor UI* (form for modifying user data)
- `edit_handler.php`  
  *Update processor* (handles profile edit submissions)
####  **Authentication Module**
- `login_handler.php`  
  *Login processor* (verifies credentials, starts sessions)

---

###  Key Architecture Principles
1. **Separation of Concerns**:
   - Presentation (HTML/CSS) separated from logic (PHP/JS)
   - Dedicated handlers for database operations
2. **Client-Server Model**:
   - Frontend: HTML/CSS/JS for UI/UX
   - Backend: PHP for business logic and data persistence
3. **Stateless HTTP**:
   - Sessions managed via PHP session cookies
4. **Modular Design**:
   - Independent components for registration/auth/profile management

---