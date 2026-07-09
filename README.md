# Karibu

A dynamic travel & lifestyle blog with a PHP and MySQL admin panel.

## Features

- Homepage listing posts pulled live from the database
- Individual post pages with estimated reading time
- Reader comments on each post
- Search and pagination
- About and Contact pages (the contact form saves to the database)
- Admin login with session handling and hashed passwords
- Admin dashboard to create, edit, and delete posts, with image upload
- Responsive design

## Built With

- PHP (PDO, prepared statements)
- MySQL / MariaDB
- HTML5 & CSS3

## Setup

1. Import `database.sql` into MySQL — it creates the `karibu_blog` database, the tables, and sample posts.
2. Adjust the credentials in `includes/db.php` if your database user/password differ.
3. Serve the folder with PHP (e.g. XAMPP) and open `http://localhost/php-blog/`. Admin: `http://localhost/php-blog/admin/`.

## Structure

```
php-blog/
├── index.php        # homepage (search + pagination)
├── post.php         # single post + comments
├── about.php
├── contact.php
├── includes/        # db connection, helpers, header/footer
├── admin/           # login + post management
├── images/          # post photos
├── style.css
└── database.sql
```

## Author

Jesse Kiplagat
