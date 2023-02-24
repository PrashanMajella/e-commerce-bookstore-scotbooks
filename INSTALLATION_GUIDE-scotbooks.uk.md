# App Installation Guide

## Required Dependencies
### **(PHP, MySQL)** OR **XAMPP Server**
- PHP - [A general-purpose scripting language](https://www.php.net/downloads)
- MySQL - [An open-source relational database management system](https://dev.mysql.com/)
- XAMPP - [A free and open-source cross-platform web server solution stack package developed by Apache](https://www.apachefriends.org/)

### Composer
- Composer - [A Dependency Manager for PHP](https://getcomposer.org/download/)

### Node.js
- Node.js [JavaScript Server Environment](https://nodejs.org/en/)
---

## Open Terminal and copy and paste the following commands
> *Project Directory*
> - Example: 
> ```
> H:\Users\Work\Downloads\scotbooks.uk>
> ```
>\.

---
## For the PHP Framework (Laravel)
>   **Directory:** [./]()

### Rename File *".env.example"* into *".env"*
-   `mv .env.example .env`
> - Example: 
> ```
> H:\Users\Work\Downloads\scotbooks.uk>mv .env.example .env
> ```
>\.

---
### Configure the Mail Service in the file *".env"*
Example: ([Mailtrap](https://mailtrap.io/))
-   Insert the Mailtrap SMTP mail server credentials. [More Details](https://mailtrap.io/blog/send-email-in-laravel/)
-   Replace "your-mailtrap-username" and "your-mailtrap-password" with your authentic credentials.
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="no-reply@scotbooks.uk"
MAIL_FROM_NAME="${APP_NAME}"
```

---
### Configure the Payment Gateway Service **([Stripe](https://stripe.com/))** in the file *".env"*
Example: 
-   Insert the Stripe Payment Gateway Service API Keys. [More Details](https://stripe.com/docs/keys)
-   [Stripe API reference – PHP](https://stripe.com/docs/api?lang=php)
-   Replace "your-stripe-publishable-key" and "your-stripe-secret-key" with your authentic credentials.
```env
STRIPE_PUBLISHABLE_KEY=your-stripe-publishable-key
STRIPE_SECRET_KEY=your-stripe-secret-key
```

---
### Install Dependencies
-   `composer install`
> - Example: 
> ```
> H:\Users\Work\Downloads\scotbooks.uk>composer install
> ```
>\.

---
### Generate Key
-   `php artisan key:generate`
> - Example: 
> ```
> H:\Users\Work\Downloads\scotbooks.uk>php artisan key:generate
> ```
>\.

---
### Create sqlite file
- `touch database/database.sqlite`
> - Example: 
> ```
> H:\Users\Work\Downloads\scotbooks.uk>touch database/database.sqlite
> ```
>\.

---
### Generate Migrations
> *Start the MySQL server before executing this command.*
- `php artisan migrate`
> - Example: 
> ```
> H:\Users\Work\Downloads\scotbooks.uk>php artisan migrate
> ```
>\.

---
### Generate Seeders
- `php artisan db:seed`
> - Example: 
> ```
> H:\Users\Work\Downloads\scotbooks.uk>php artisan db:seed
> ```
>\.

---
### Install Dependencies (Laravel)
-   `npm install`
> - Example: 
> ```
> H:\Users\Work\Downloads\scotbooks.uk>npm install
> ```
>\.

---
## Link Storage to Public Directory
- `php artisan storage:link`
> - Example: 
> ```
> H:\Users\Work\Downloads\scotbooks.uk>php artisan storage:link
> ```
>\.

---
## Start the Server (Laravel)
- `php artisan serve`
> - Example: 
> ```
> H:\Users\Work\Downloads\scotbooks.uk>php artisan serve
> ```
>\.


---
> (Without terminating the laravel server, open a new cmd window.)
## Start the NPM Server (Laravel)
- `npm run dev`
> - Example: 
> ```
> H:\Users\Work\Downloads\scotbooks.uk>npm run dev
> ```
>\.

---
> (Without terminating the laravel NPM server, open a new cmd window.)
## For the VueJs Framework (Admin Dashboard)
>   **Directory:** [./backend]()

## To the directory
-   `cd ./backend`
> - Example: 
> ```
> H:\Users\Work\Downloads\scotbooks.uk>cd ./backend
> ```
>\.

### Rename File *".env.example"* into *".env"*
-   `mv .env.example .env`
> - Example: 
> ```
> H:\Users\Work\Downloads\scotbooks.uk\backend>mv .env.example .env
> ```
>\.

---
### Install Dependencies
-   `npm install`
> - Example: 
> ```
> H:\Users\Work\Downloads\scotbooks.uk\backend>npm install
> ```
>\.

### (If any errors)
-   `npm audit fix`
> - Example: 
> ```
> H:\Users\Work\Downloads\scotbooks.uk\backend>npm audit fix
> ```
>\.

---
### Start the NPM Server
-   `npm run dev`
> - Example: 
> ```
> H:\Users\Work\Downloads\scotbooks.uk\backend>npm run dev
> ```
>\.

## Note
- The user must provide their original email address to be registered.
- With this Installation, All of the database records are stored within the application (SQLite Database).

### Built-in Admin Information:
- Email:
    ```
    admin@email.com
    ```
- Password:
    ```
    Admin@12345
    ```
