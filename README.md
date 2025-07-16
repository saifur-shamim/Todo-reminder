
# 📝 Laravel 12 Todo Reminder Application

This is a Laravel 12-based **Todo Management App** with the following features:

* ✅ Create / Read / Update / Delete Todos
* ⏰ Send reminder emails **10 minutes before the due time**
* 📎 Emails include a **CSV attachment** with 10 titles from a public API
* 📬 Email logs are stored in the database
* 🧰 Uses Laravel **Scheduler** and **Queues**
* 🎨 Simple Bootstrap UI with separate pages for Create and Edit

---

## 📦 Tech Stack

* **Laravel 12**
* **PHP 8.2+**
* **Bootstrap 5**
* **MySQL / SQLite**
* **Laravel Queue + Scheduler**
* **Mailtrap** (for testing email)

---

## ⚙️ Installation Instructions

### 1. Clone the Project

```bash
git clone https://github.com/saifur-shamim/Todo-reminder.git

````
```bash
cd Todo-reminder
````
### 2\. Install Dependencies

```bash
composer install
```

### 3\. Copy `.env` File

```bash
cp .env.example .env
```

### 4\. Configure `.env`

Copy the contents of the provided `env.text` file into  `.env` file in the root directory of the project. Then update the configuration values to match your local environment — such as database credentials, mail settings, and port numbers (MySQL uses port 3306 by default).


#### 🔧 Database Configuration:

```env
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
DB_PORT=3306  # Update if your MySQL port is different
```

#### 📧 Email Configuration:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="Todo App"
```

> ⚠️ **Important Notes:**
>
> * Use a **Gmail App Password**, not your Gmail login password.
>   👉 [How to generate an App Password](https://support.google.com/accounts/answer/185833)


### 5\. Generate App Key

```bash
php artisan key:generate
```

### 6\. Run Migrations

```bash
php artisan migrate
```

### 7\. Start the Laravel Server

```bash
php artisan serve
```

Now visit: `http://localhost:8000`

-----

Got it. Here's the updated "Scheduler & Queue Setup" section, incorporating the `php artisan todo:send-reminders` command where it makes the most sense.

I'll assume `todo:send-reminders` is a custom command that needs to be run *after* the scheduler is set up (as the scheduler is what typically triggers custom commands).

## ⏲️ Scheduler & Queue Setup

### 1. Enable Queue with Database Driver


```bash
php artisan queue:table
````

```bash
php artisan migrate
````

Then run the queue worker:

```bash
php artisan queue:work
```

### 2\. Enable Scheduler

Set the Laravel scheduler in your system's cron job:

```bash
* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
```

Or, for local testing, run manually:

```bash
php artisan schedule:work
```

-----

## 🌐 Routes Overview

### 📄 Web Routes

| Route             | Description        |
| :---------------- | :----------------- |
| `/`               | View all todos     |
| `/todos/create`   | Create new todo    |
| `/todos/{id}/edit`| Edit existing todo |

### 🔌 API Routes

| Method | Endpoint          | Description       |
| :----- | :---------------- | :---------------- |
| `GET`  | `/api/todos`      | List all todos    |
| `POST` | `/api/todos`      | Create a todo     |
| `GET`  | `/api/todos/{id}` | View single todo  |
| `PUT`  | `/api/todos/{id}` | Update a todo     |
| `DELETE`| `/api/todos/{id}` | Delete a todo     |
| `GET`  | `/api/email-logs` | View email logs   |

-----

## 📧 Email Reminder Details

  * When a todo is created with a `due_datetime` in the future,
  * A scheduled command runs every minute and:
      * Checks if any todo is **10 minutes away from due**
      * Sends an email reminder
      * Attaches a **CSV file** containing 10 titles fetched from:
          * `https://jsonplaceholder.typicode.com/posts`
      * Marks the `email_sent` column as `true`
      * Saves a log in `email_logs` table

-----

## 📁 Project Structure Highlights

```
app/
├── Console/Commands/SendTodoReminders.php
├── Jobs/SendTodoEmailJob.php
├── Mail/TodoReminderMail.php
├── Services/EmailLogger.php
├── Models/Todo.php
├── Models/EmailLog.php
resources/views/
├── todos.blade.php
├── create-todo.blade.php
├── edit-todo.blade.php
routes/
├── web.php
├── api.php
```

````markdown
**⚠️ IMPORTANT NOTE FOR EMAIL TESTING ⚠️**

By default, reminder emails are sent to a hardcoded address for demonstration.
To receive reminder emails in your own inbox for testing,
you will need to modify the `$recipient` variable
within the `handle()` function of the `app/Jobs/SendTodoEmailJob.php` file:

```php
// app/Jobs/SendTodoEmailJob.php

public function handle(): void
{
    // ... other code ...

    $recipient = 'your-email@example.com'; // <--- Change 'your-email@example.com' to your actual email address.

    // ... rest of the code that uses $recipient ...
}
````

Remember to set up your Mailtrap (or other SMTP) credentials in your `.env` file as well for emails to be sent.

