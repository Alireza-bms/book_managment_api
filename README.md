# 📚 Library Management API

A modern and scalable **Library Management System API** built with **Laravel 12**.  
This project demonstrates clean architecture, API versioning, role & permission management (using **Spatie Laravel Permission**), and follows RESTful best practices.

---

## 🚀 Features

- **Authentication & Authorization**

  - Laravel Sanctum for token-based, stateless authentication
  - Role & permission system via Spatie
  - Admin, Librarian, and User roles

- **CRUD Operations**

  - Users (Admin only)
  - Roles & Permissions
  - Books, Authors, Categories

- **Loan Management**

  - Borrow, Return, and Cancel loans

- **Advanced API Features**

  - Versioned endpoints (`/api/v1/...`)
  - Relationship includes via query param `?include=`
  - API-level response caching via **Spatie ResponseCache**

- **Code Quality**

  - Clean architecture with Service layer
  - Form Requests for validation
  - API Resources for structured responses

- **Documentation**
  - Fully documented via Swagger UI / OpenAPI

---

## 🛠 Tech Stack

- [Laravel 12](https://laravel.com/)
- [Laravel Sanctum](https://laravel.com/docs/sanctum)
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission/v6/introduction)
- [Spatie ResponseCache](https://spatie.be/docs/laravel-responsecache/v8/introduction)
- Redis for caching
- [L5 Swagger](https://github.com/DarkaOnLine/L5-Swagger) for interactive API docs
- PHP 8.2+
- MySQL / PostgreSQL
- Composer

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

- Token-based auth via **Laravel Sanctum**
- Admin-only routes protected via:

  - `can:access-admin-panel` middleware
  - Spatie roles/permissions (`admin`, `librarian`, `user`)

- Example roles:
  - **Admin** → Full access
  - **Librarian** → Manage books, authors, categories, loans
  - **User** → Borrow/return books, manage profile

---

## ⚡ Caching

- **Redis** used as the cache backend
- Responses cached automatically with **Spatie ResponseCache**
  - GET requests like `/api/v1/books` are cached
  - Cache invalidated via model observers

```env
CACHE_DRIVER=redis
```

---

## 📖 API Documentation

Available via Swagger UI:

```
http://localhost:8000/api/documentation
```

- Switch between JSON and YAML formats
- Each endpoint includes schemas, params, examples
- Supports **`include`** query for relationships:

  - `GET /api/v1/authors?include=books,categories`
  - `GET /api/v1/books?include=authors,category`
  - `GET /api/v1/categories?include=books,authors`

> Make sure `L5_SWAGGER_GENERATE_ALWAYS=true` in `.env`.

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

### 🔐 Auth

- `POST /api/v1/register`
- `POST /api/v1/login`
- `POST /api/v1/logout`

---

### 👤 Profile

- `GET /api/v1/profile`
- `PUT /api/v1/profile`
- `PUT /api/v1/profile/password`

---

### 📘 Books

- `GET /api/v1/books?include=authors,category`
- `POST /api/v1/books`
- `GET /api/v1/books/{id}?include=authors,category`
- `PUT /api/v1/books/{id}`
- `DELETE /api/v1/books/{id}`

> Books can include both **authors** and **category** relationships in a single request.

---

### ✍️ Authors

- `GET /api/v1/authors?include=books,categories`
- `POST /api/v1/authors`
- `GET /api/v1/authors/{id}?include=books,categories`
- `PUT /api/v1/authors/{id}`
- `DELETE /api/v1/authors/{id}`

> Authors can include both **books** and **categories** in responses.

---

### 🏷️ Categories

- `GET /api/v1/categories?include=books,authors`
- `POST /api/v1/categories`
- `GET /api/v1/categories/{id}?include=books,authors`
- `PUT /api/v1/categories/{id}`
- `DELETE /api/v1/categories/{id}`

> Categories can include both **books** and **authors** in responses.

---

### 📦 Loans

- `POST /api/v1/loans` → Borrow a book
- `POST /api/v1/loans/{loan}/return` → Return a book
- `POST /api/v1/loans/{loan}/cancel` → Cancel a loan

---

### ⚙️ Admin (requires `admin` role)

#### 👥 Users

- `GET /api/v1/admin/users?include=roles,permissions,loans`
- `POST /api/v1/admin/users`
- `GET /api/v1/admin/users/{id}?include=roles,permissions,loans`
- `PUT /api/v1/admin/users/{id}`
- `DELETE /api/v1/admin/users/{id}`

> Admin users can now **include roles, permissions, and loans** in the response.

#### 🎭 Roles

- `GET /api/v1/admin/roles`
- `POST /api/v1/admin/roles`
- `GET /api/v1/admin/roles/{id}`
- `PUT /api/v1/admin/roles/{id}`
- `DELETE /api/v1/admin/roles/{id}`

#### 🛡️ Permissions

- `GET /api/v1/admin/permissions`
- `POST /api/v1/admin/permissions`
- `GET /api/v1/admin/permissions/{id}`
- `PUT /api/v1/admin/permissions/{id}`
- `DELETE /api/v1/admin/permissions/{id}`

---

## 📌 License

Licensed under the [MIT License](LICENSE).
