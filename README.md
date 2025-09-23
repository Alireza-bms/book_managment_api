# 📚 Library Management API

A modern and scalable **Library Management System API** built with **Laravel 12**.  
This project demonstrates clean architecture, API versioning, role & permission management (using **Spatie Laravel Permission**), and follows RESTful best practices.

---

## 🚀 Features

- Authentication with **Laravel Sanctum**
- Role & Permission system with **Spatie**
- Versioned API (`/api/v1/...`)
- User profile management
- CRUD for:
    - Users (Admin only)
    - Roles & Permissions
    - Books, Authors, Categories
- Borrow, Return & Cancel loan system
- Clean code with **Service Layer**, **Form Requests**, and **Resources**
- Ready for **production deployment**

---

## 🛠 Tech Stack

- [Laravel 12](https://laravel.com/)
- [Laravel Sanctum](https://laravel.com/docs/sanctum)
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission/v6/introduction)
- [L5 Swagger](https://github.com/DarkaOnLine/L5-Swagger) for API documentation
- PHP 8.2+
- MySQL (or PostgreSQL)
- Composer
- Docker (optional)

---

## 📦 Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/<your-username>/<repo-name>.git
   cd <repo-name>
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Copy `.env` file and configure database:
   ```bash
   cp .env.example .env
   ```

4. Generate app key:
   ```bash
   php artisan key:generate
   ```

5. Run migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```

6. Start the development server:
   ```bash
   php artisan serve
   ```

---

## 🔐 Authentication & Authorization

- Auth handled by **Laravel Sanctum** (token-based, stateless).
- Admin-only routes are protected with:
    - `can:access-admin-panel` middleware
    - Spatie roles/permissions (`admin`, `librarian`, `user` by default).
- Example roles:
    - `admin`: Full access to all resources
    - `librarian`: Manage books, authors, categories, loans
    - `user`: Borrow & return books, manage profile

---

## 📖 API Documentation

Interactive API documentation is available via **Swagger UI**.  
Once your project is running, you can access it at:

```
http://localhost:8000/api/documentation
```

- The UI uses the OpenAPI specification generated from your project.
- You can switch between **JSON** and **YAML** formats.
- All endpoints are documented with request/response schemas, parameters, and example payloads.

### Notes

- Make sure `L5_SWAGGER_GENERATE_ALWAYS` is set to `true` in `.env` during development to regenerate docs automatically:
```bash
L5_SWAGGER_GENERATE_ALWAYS=true
```
- The generated OpenAPI files are stored in:
```text
storage/api-docs/
```
- The default file names are `api-docs.json` and `api-docs.yaml`.

---

## 📂 Project Structure

```
app/
 ├── Http/
 │    ├── Controllers/
 │    │    ├── v1/
 │    │    │    ├── Admin/
 │    │    │    ├── Auth/
 │    │    │    ├── Library/
 │    │    │    └── User/
 │    ├── Requests/
 │    └── Resources/
 ├── Models/
 └── Services/
```

---

## 📡 API Endpoints (v1)

### Auth
- `POST /api/v1/register`
- `POST /api/v1/login`
- `POST /api/v1/logout`

### Profile
- `GET /api/v1/profile`
- `PUT /api/v1/profile`
- `PUT /api/v1/profile/password`

### Books
- `GET /api/v1/books`
- `POST /api/v1/books`
- `GET /api/v1/books/{id}`
- `PUT /api/v1/books/{id}`
- `DELETE /api/v1/books/{id}`

### Authors
- `GET /api/v1/authors`
- `POST /api/v1/authors`
- `GET /api/v1/authors/{id}`
- `PUT /api/v1/authors/{id}`
- `DELETE /api/v1/authors/{id}`

### Categories
- `GET /api/v1/categories`
- `POST /api/v1/categories`
- `GET /api/v1/categories/{id}`
- `PUT /api/v1/categories/{id}`
- `DELETE /api/v1/categories/{id}`

### Loans
- `POST /api/v1/loans` → Borrow
- `POST /api/v1/loans/{loan}/return` → Return
- `POST /api/v1/loans/{loan}/cancel` → Cancel

### Admin (only for `admin` role)
- CRUD for `users`, `roles`, `permissions`

---

## 🧪 Testing

> ⚠️ No tests are currently written for this project. Future updates may include unit and feature tests.

---

## 📌 License

This project is licensed under the [MIT License](LICENSE).

