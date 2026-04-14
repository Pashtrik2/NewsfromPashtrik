# NewsfromPashtrik

This project now includes PHP OOP authentication with:

- User registration and login
- Password hashing with `password_hash()` and `password_verify()`
- Session-based authentication
- Role-based access for `admin` and `user`
- A protected admin dashboard

## Role assignment

The first account registered is assigned the `admin` role. Every account created after that is assigned the `user` role.

## Storage

Registered users are stored in `storage/users.json` when that directory is writable. If the web server cannot write there, the app falls back to a writable directory inside the system temporary folder.

## Pages

- `register.php`: creates a new account
- `login.php`: authenticates an existing account
- `logout.php`: clears the session
- `news.php`: protected page for authenticated users
- `admin.php`: protected page for admin users only
