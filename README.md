# Secure PHP Form Handling

## 📌 Project Overview
This project demonstrates **secure user registration** in PHP with proper validation, session handling, cookies, and XSS protection.  
It also includes an implementation of **GET vs POST** methods to show their practical differences.

---

## 🚀 Features
- Secure **user registration form**
- Validation for:
  - Username (required)
  - Email (valid format)
  - Strong password (length, case, digit, special character)
  - Password confirmation
- Session handling (`$_SESSION`)
- Cookie handling (`setcookie`)
- XSS attack prevention (`htmlspecialchars`)
- GET and POST examples with clear differentiation

---

## 🧪 Dummy Input Test Cases
- ✅ Successful Registration  
  Username: `anujacharya`  
  Email: `anujacharya@gmail.com`  
  Password: `Passw0rd!`  
  Confirm Password: `Passw0rd!`  
  **Expected:** "Registration successful! Welcome, anujacharya."

- ❌ Missing field → "Please fill out this field."
- ❌ Invalid email (`user@invalid`) → "Invalid email format."
- ❌ Weak password (`abc123`) → "Password must be at least 8 characters..."
- ❌ Mismatched password → "Passwords do not match."
- 🔍 GET Test → `http://localhost:8000/Web_Programming_2_Assignment_Activity_Unit_4.php?username=anujacharya`  
  **Expected:** "Message received via GET: anujacharya"
- 🔒 XSS Test → `<script>alert('Hacked')</script>`  
  **Expected:** `&lt;script&gt;alert('Hacked')&lt;/script&gt;` (no popup)

---

## ⚙️ How to Run
1. Clone this repository:  
   ```bash
   git clone https://github.com/yourusername/Secure-PHP-Form-Handling.git
