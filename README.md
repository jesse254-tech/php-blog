# Karibu

A dynamic travel & lifestyle blog with a PHP and MySQL admin panel.

## Features

- Public homepage listing posts pulled live from the database
- Individual post pages
- Admin login with session handling and hashed passwords
- Admin dashboard to create, edit, and delete posts
- Image upload for post photos
- Responsive design

## Built With

- PHP (PDO, prepared statements)
- MySQL / MariaDB
- HTML5 & CSS3

## Setup

1. Import `database.sql` into MySQL — it creates the `karibu_blog` database, the tables, and a few sample posts.
2. Adjust the credentials in `includes/db.php` if your database user/password differ.
3. Serve the folder with PHP (e.g. XAMPP) and open `http://localhost/php-blog/`.
4. Admin panel: `http://localhost/php-blog/admin/`.

## Structure

```
php-blog/
├── index.php        # homepage
├── post.php         # single post
├── includes/        # db connection + shared header/footer
├── admin/           # login + post management
├── images/          # post photos
├── style.css
└── database.sql
```

## Author

Jesse Kiplagat
