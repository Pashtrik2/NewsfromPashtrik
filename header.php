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
        :root {
            --bg: #f3f6fb;
            --surface: #ffffff;
            --ink: #1f2937;
            --muted: #64748b;
            --brand: #0f766e;
            --brand-dark: #115e59;
            --line: #dbe3ec;
            --shadow: 0 14px 40px rgba(15, 23, 42, 0.08);
            --radius: 16px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background:
                radial-gradient(circle at 10% 5%, #dff8f5 0%, transparent 40%),
                radial-gradient(circle at 90% 0%, #eaf2ff 0%, transparent 35%),
                var(--bg);
            color: var(--ink);
        }

        .site-header {
            position: sticky;
            top: 0;
            z-index: 20;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--line);
        }

        .header-wrap {
            max-width: 1120px;
            margin: 0 auto;
            padding: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .brand {
            margin: 0;
            font-size: 1.35rem;
            letter-spacing: 0.3px;
            color: var(--brand-dark);
        }

        .site-nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .site-nav a {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 999px;
            color: var(--ink);
            text-decoration: none;
            font-weight: 600;
            border: 1px solid transparent;
            transition: all 0.2s ease;
        }

        .site-nav a:hover {
            color: var(--brand-dark);
            background-color: #e6fffb;
            border-color: #c9f4ef;
        }

        main {
            max-width: 1120px;
            margin: 28px auto;
            padding: 0 16px;
            min-height: 60vh;
        }

        .hero {
            background: linear-gradient(135deg, #0f766e 0%, #155e75 100%);
            color: #f8fafc;
            border-radius: 20px;
            padding: 48px 30px;
            box-shadow: var(--shadow);
            margin-bottom: 28px;
        }

        .hero h2 {
            margin: 0 0 10px;
            font-size: clamp(1.7rem, 4vw, 2.6rem);
            line-height: 1.2;
        }

        .hero p {
            margin: 0;
            max-width: 680px;
            color: #d7f8f3;
        }

        .section-title {
            margin: 0 0 14px;
            font-size: 1.4rem;
            color: #0f172a;
        }

        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 18px;
        }

        .news-card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .news-card img {
            width: 100%;
            height: 170px;
            object-fit: cover;
            display: block;
        }

        .news-content {
            padding: 14px;
        }

        .news-content h3 {
            margin: 0 0 6px;
            font-size: 1.05rem;
        }

        .news-content p {
            margin: 0;
            color: var(--muted);
            font-size: 0.95rem;
        }

        footer {
            background-color: #e8edf4;
            text-align: center;
            padding: 18px 16px;
            color: #334155;
            border-top: 1px solid var(--line);
        }

        @media (max-width: 640px) {
            .header-wrap {
                justify-content: center;
            }

            .site-nav ul {
                justify-content: center;
            }

            .hero {
                padding: 34px 20px;
            }
        }
    </style>
</head>
<body>
<header class="site-header">
    <div class="header-wrap">
    <h1 class="brand">News Portal</h1>
    <nav class="site-nav" aria-label="Main navigation">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="news.php">News</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        </ul>
    </nav>
    </div>
</header>
<main>
