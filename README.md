# 📚 Library Management API

A modern and scalable **Library Management System API** built with **Laravel 12**.
This project demonstrates clean architecture, API versioning, role & permission management (using **Spatie Laravel Permission**), and follows RESTful best practices.

---

## 🚀 Features

-   **Authentication & Authorization**

    -   Laravel Sanctum for token-based, stateless authentication
    -   Role & permission system via Spatie
    -   Admin, Librarian, and User roles

-   **CRUD Operations**

    -   Users (Admin only)
    -   Roles & Permissions
    -   Books, Authors, Categories

-   **Loan Management**

    -   Borrow, Return, and Cancel loans

-   **Advanced API Features**

    -   Versioned endpoints (`/api/v1/...`)
    -   Resource filtering with `include` for relationships
    -   API-level response caching via **Spatie ResponseCache**

-   **Code Quality**

    -   Clean architecture with Service layer
    -   Form Requests for validation
    -   API Resources for structured responses

-   **Documentation**

    -   Fully documented via Swagger UI / OpenAPI

---

## 🛠 Tech Stack

-   [Laravel 12](https://laravel.com/)
-   [Laravel Sanctum](https://laravel.com/docs/sanctum)
-   [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission/v6/introduction)
-   [Spatie ResponseCache](https://spatie.be/docs/laravel-responsecache/v8/introduction) for caching API responses
-   Redis for caching
-   [L5 Swagger](https://github.com/DarkaOnLine/L5-Swagger) for interactive API docs
-   PHP 8.2+
-   MySQL / PostgreSQL
-   Composer

---

## 📦 Installation

```bash
git clone https://github.com/<your-username>/<repo-name>.git
cd <repo-name>
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

---

## 🔐 Authentication & Authorization

-   Token-based auth via **Laravel Sanctum**
-   Admin-only routes protected via:

    -   `can:access-admin-panel` middleware
    -   Spatie roles/permissions (`admin`, `librarian`, `user`)

-   Example roles:

    -   **Admin**: Full access
    -   **Librarian**: Manage books, authors, categories, loans
    -   **User**: Borrow/return books, manage profile

---

## ⚡ Caching

-   **Redis** is used as the cache backend.
-   API responses are cached automatically using **Spatie ResponseCache**.

    -   GET requests for resources (like `/api/v1/books`) are cached by default.
    -   Cache is automatically invalidated via model observers when data changes.

-   Redis connection is configurable in `.env` via:

    ```env
    CACHE_DRIVER=redis
    ```

---

## 📖 API Documentation

Interactive API documentation is available via Swagger UI:

```
http://localhost:8000/api/documentation
```

-   Switch between **JSON** and **YAML** formats
-   All endpoints include request/response schemas, parameters, and examples
-   Supports **`include` query parameter** for loading relationships, e.g.:

    -   `GET /api/v1/authors?include=books`
    -   `GET /api/v1/categories?include=books`

> Make sure `L5_SWAGGER_GENERATE_ALWAYS=true` in `.env` to regenerate docs automatically.

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

-   `POST /api/v1/register`
-   `POST /api/v1/login`
-   `POST /api/v1/logout`

### Profile

-   `GET /api/v1/profile`
-   `PUT /api/v1/profile`
-   `PUT /api/v1/profile/password`

### Books

-   `GET /api/v1/books` → Optional `include=authors,category`
-   `POST /api/v1/books`
-   `GET /api/v1/books/{id}`
-   `PUT /api/v1/books/{id}`
-   `DELETE /api/v1/books/{id}`

### Authors

-   `GET /api/v1/authors` → Optional `include=books`
-   `POST /api/v1/authors`
-   `GET /api/v1/authors/{id}` → Optional `include=books`
-   `PUT /api/v1/authors/{id}`
-   `DELETE /api/v1/authors/{id}`

### Categories

-   `GET /api/v1/categories` → Optional `include=books`
-   `POST /api/v1/categories`
-   `GET /api/v1/categories/{id}` → Optional `include=books`
-   `PUT /api/v1/categories/{id}`
-   `DELETE /api/v1/categories/{id}`

### Loans

-   `POST /api/v1/loans` → Borrow
-   `POST /api/v1/loans/{loan}/return` → Return
-   `POST /api/v1/loans/{loan}/cancel` → Cancel

### Admin (requires `admin` role)

-   Users CRUD: `GET/POST/PUT/DELETE /api/v1/admin/users`
-   Roles CRUD: `GET/POST/PUT/DELETE /api/v1/admin/roles`
-   Permissions CRUD: `GET/POST/PUT/DELETE /api/v1/admin/permissions`

---

## 📌 License

This project is licensed under the [MIT License](LICENSE).
