# Backend Technical Task - Laravel 11

This project is a backend system built with **Laravel 11**. It includes a RESTful API with authentication, email verification, post management, and a dashboard for users to manage their posts.

---

## 📌 Features

### 🔐 User Authentication (API)
- **Registration** with email and password.
- Sends a **6-digit verification code** via email using **Mailtrap**.
- Users must be **verified** before logging in.
- **Login** returns a token for authenticated API access.

### 📮 Email Verification
- A 6-digit code is sent to the user's email.
- Verification is required before login is allowed.

### 📝 Post Management (API)
- List all posts or get a post by ID.
- List posts **created by the authenticated user** (requires token).
- Authenticated users can:
  - Create posts
  - Edit their own posts
  - Delete their own posts
- All post routes are protected using **API tokens (Sanctum)**.

### 📊 Stats Endpoint
Returns:
- Total number of users
- Total number of posts
- Number of users without any posts

---

## 🖥️ Dashboard (Blade Views)
- Built using **Corona Admin Template**.
- Login is required to access the dashboard.
- Dashboard shows:
  - User's own posts (title, body, image)
  - Buttons for:
    - **Create**
    - **Edit**
    - **Delete**
- **Create** and **Delete** actions are done using **AJAX**.

---

## ⚙️ Tech Stack

- Laravel 11
- Sanctum for API Authentication
- Blade Template (Corona Admin)
- AJAX (for Create & Delete in Dashboard)
- API Resources
- Mailtrap for email testing

---

## 🧪 Postman Collection

You can test all API endpoints using the Postman collection included in the project.

👉 [Download Postman Collection](postman/Jadara-task.postman_collection.json)

### How to use:

1. Open Postman
2. Click **Import**
3. Select the file `Jadara-task.postman_collection.json` from the `postman/` directory
4. Start testing on your local server (e.g., `http://127.0.0.1:8000`)

---

## 📂 Installation

```bash
git clone https://github.com/ZainabHarraz/Backend-Technical-Task.git
cd Backend-Technical-Task

composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
