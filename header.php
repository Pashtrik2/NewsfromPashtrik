<?php
if (!isset($pageTitle)) {
    $pageTitle = 'News Portal';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            line-height: 1.5;
            background-color: #f4f4f4;
            color: #222;
        }

        header {
            background-color: #1f2937;
            color: #fff;
            padding: 16px;
        }

        nav ul {
            list-style: none;
            margin: 8px 0 0;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
        }

        main {
            max-width: 900px;
            margin: 24px auto;
            padding: 0 16px;
            min-height: 60vh;
        }

        footer {
            background-color: #e5e7eb;
            text-align: center;
            padding: 14px 16px;
            color: #374151;
            border-top: 1px solid #d1d5db;
        }
    </style>
</head>
<body>
<header>
    <h1>News Portal</h1>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="news.php">News</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        </ul>
    </nav>
</header>
<main>
