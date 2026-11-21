# E-Commerce Store (Laravel)

A full-featured e-commerce platform built with Laravel. This project demonstrates my skills in backend development, database design, and asynchronous task processing.

## 🛠 Tech Stack
*   **Backend:** PHP 8.x, Laravel 11
*   **Database:** PostgresSQL
*   **Message Broker:** RabbitMQ (for async background tasks)
*   **Frontend:** Blade templates, Tailwind CSS
*   **Testing:** PHPUnit (Unit & Feature tests)

## ✨ Key Features
*   **Admin Panel:** Full CRUD (Create, Read, Update, Delete) for products, categories, and user roles.
*   **Product Catalog:** Dynamic filtering and searching.
*   **Shopping Cart:** Session-based cart with checkout functionality.
*   **Authentication:** Role-based access control (Admin/Customer).
*   **Asynchronous Processing:** Integration with RabbitMQ for sending order notifications and background jobs.
*   **Testing:** Automated tests covering core business logic.

## ⚙️ Installation & Setup
To run this project locally:

1. Clone the repository:
   `git clone https://github.com/ulanovka12/Shop.git`
2. Navigate to the project folder and install dependencies:
   `composer install` and `npm install`
3. Copy `.env.example` to `.env` and configure your database & RabbitMQ settings.
4. Generate app key:
   `php artisan key:generate`
5. Run migrations:
   `php artisan migrate`
6. Start the local server:
   `php artisan serve`
