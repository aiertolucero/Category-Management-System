# Category-Management-System
Responsive Gallery using Bootstrap 3, Flickr API and Laravel framework.

Install [Composer](https://getcomposer.org/download/), [Xampp](https://www.apachefriends.org/download.html) or just [MySQL](https://www.mysql.com/downloads/) and run the following:


1.  `composer install` - This command will install all the dependencies via Composer

2.  Create a `.env` file and copy whats inside the `.env.example`

3.  Modify your database config inside your `.env` file e.g.

        `DB_DATABASE=category_management`
        
        `DB_USERNAME=mysql_user`
        
        `DB_PASSWORD=password`
        
4.  Create a database in your MySql (Should match the database name inside your .env) 

5.  Run `php artisan key:generate` - This command will generate an application key to your `.env` file

6.  Run `php artisan migrate` - This command will generate `users` and `categories` tables in your database

7.  Run `php artisan db:seed --class=UsersTableSeeder` - This command will generate a `user` with a username of `admin_user@test.com` and a password of `password1234` in your database

8.  Run `php artisan serve` - This command will start a development server at `http://localhost:8000`
