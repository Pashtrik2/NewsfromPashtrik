<?php
require_once __DIR__ . '/app/bootstrap.php';
require_once __DIR__ . '/app/database.php';

if (!isset($pageTitle)) {
    $pageTitle = 'News Portal';
}

$currentUser = $auth->user();
$successMessage = $auth->pullFlash('success');
$errorMessage = $auth->pullFlash('error');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <style>
        :root {
            --bg: #eef4f8;
            --surface: #ffffff;
            --surface-soft: rgba(255, 255, 255, 0.7);
            --ink: #172033;
            --muted: #5f6f86;
            --brand: #0f766e;
            --brand-dark: #0b5b55;
            --brand-soft: #d9f3ef;
            --accent: #d97706;
            --line: #d7e2ec;
            --line-strong: #c4d1dd;
            --shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
            --shadow-soft: 0 10px 28px rgba(15, 23, 42, 0.05);
            --radius: 24px;
            --radius-sm: 16px;
            --space-1: 8px;
            --space-2: 16px;
            --space-3: 24px;
            --space-4: 32px;
            --space-5: 48px;
            --container: 1200px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background:
                radial-gradient(circle at top left, rgba(180, 241, 232, 0.9) 0%, transparent 32%),
                radial-gradient(circle at top right, rgba(216, 230, 255, 0.95) 0%, transparent 30%),
                var(--bg);
            color: var(--ink);
        }

        a {
            color: inherit;
        }

        .container {
            width: min(100% - 32px, var(--container));
            margin: 0 auto;
        }

        .site-header {
            position: sticky;
            top: 0;
            z-index: 20;
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(18px);
            border-bottom: 1px solid var(--line);
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.04);
        }

        .header-wrap {
            width: min(100% - 32px, var(--container));
            margin: 0 auto;
            padding: 14px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: var(--space-2);
            flex-wrap: wrap;
        }

        .brand {
            margin: 0;
            font-size: 1.55rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--brand-dark);
        }

        .site-nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .site-nav a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 10px 14px;
            border-radius: 999px;
            color: var(--ink);
            text-decoration: none;
            font-size: 0.96rem;
            font-weight: 700;
            border: 1px solid transparent;
            transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease, transform 0.2s ease;
        }

        .site-nav a:hover {
            color: var(--brand-dark);
            background: rgba(15, 118, 110, 0.08);
            border-color: rgba(15, 118, 110, 0.14);
            transform: translateY(-1px);
        }

        .site-nav .accent-link {
            color: #ffffff;
            background: linear-gradient(135deg, var(--brand) 0%, #1f8a82 100%);
            box-shadow: 0 12px 24px rgba(15, 118, 110, 0.22);
        }

        .site-nav .accent-link:hover {
            color: #ffffff;
            background: linear-gradient(135deg, var(--brand-dark) 0%, #126f69 100%);
            border-color: transparent;
        }

        .user-meta {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            color: var(--muted);
            font-size: 0.94rem;
        }

        .role-badge,
        .role-pill,
        .hero-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 12px;
            border-radius: 999px;
            background: var(--brand-soft);
            color: var(--brand-dark);
            font-size: 0.8rem;
            font-weight: 800;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .page-shell {
            width: min(100% - 32px, var(--container));
            margin: 0 auto;
            padding: 20px 0 56px;
            min-height: calc(100vh - 96px);
        }

        .page-stack {
            display: grid;
            gap: var(--space-4);
        }

        .flash {
            margin: 0;
            padding: 14px 16px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--line);
            box-shadow: var(--shadow-soft);
        }

        .flash-success {
            background: #ecfdf5;
            color: #166534;
            border-color: #bbf7d0;
        }

        .flash-error {
            background: #fef2f2;
            color: #991b1b;
            border-color: #fecaca;
        }

        .hero {
            position: relative;
            overflow: hidden;
            display: grid;
            gap: var(--space-3);
            padding: clamp(24px, 4vw, 44px);
            border-radius: 30px;
            background:
                radial-gradient(circle at top right, rgba(255, 255, 255, 0.24) 0%, transparent 30%),
                linear-gradient(135deg, #0f766e 0%, #155e75 52%, #1d4f91 100%);
            color: #f8fafc;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255, 255, 255, 0.14);
        }

        .hero::after {
            content: "";
            position: absolute;
            inset: auto -8% -30% auto;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
            filter: blur(2px);
        }

        .hero > * {
            position: relative;
            z-index: 1;
        }

        .hero-home {
            grid-template-columns: minmax(0, 1.35fr) minmax(280px, 0.75fr);
            align-items: end;
        }

        .hero-copy {
            display: grid;
            gap: var(--space-2);
        }

        .hero-title {
            margin: 0;
            max-width: 12ch;
            font-size: clamp(2.2rem, 5vw, 4.3rem);
            line-height: 0.97;
            letter-spacing: -0.05em;
        }

        .hero-text {
            margin: 0;
            max-width: 58ch;
            color: rgba(248, 250, 252, 0.84);
            font-size: 1.02rem;
        }

        .hero-metrics {
            display: grid;
            gap: var(--space-2);
        }

        .stat-card,
        .mini-card,
        .auth-card,
        .table-card,
        .feature-card,
        .prose-card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow-soft);
        }

        .stat-card {
            padding: 18px 20px;
            background: rgba(255, 255, 255, 0.14);
            border-color: rgba(255, 255, 255, 0.18);
            color: #ffffff;
            backdrop-filter: blur(10px);
        }

        .stat-card strong {
            display: block;
            margin-bottom: 4px;
            font-size: 1.45rem;
            line-height: 1;
        }

        .stat-card span {
            color: rgba(248, 250, 252, 0.78);
            font-size: 0.92rem;
        }

        .section-shell {
            display: grid;
            gap: var(--space-3);
        }

        .section-heading {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: var(--space-2);
            flex-wrap: wrap;
        }

        .section-kicker {
            margin: 0;
            color: var(--brand-dark);
            font-size: 0.82rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .section-title {
            margin: 4px 0 0;
            font-size: clamp(1.7rem, 3vw, 2.4rem);
            line-height: 1.1;
            letter-spacing: -0.04em;
            color: #0f172a;
        }

        .section-description {
            margin: 0;
            max-width: 50ch;
            color: var(--muted);
        }

        .feature-grid,
        .news-grid,
        .admin-grid {
            display: grid;
            gap: var(--space-3);
        }

        .feature-grid,
        .news-grid {
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        }

        .feature-card,
        .prose-card,
        .auth-card,
        .table-card {
            padding: 24px;
        }

        .feature-card h3,
        .prose-card h3,
        .auth-card h2 {
            margin: 0;
            color: #0f172a;
        }

        .feature-card p,
        .prose-card p,
        .auth-intro,
        .helper-text {
            margin: 0;
            color: var(--muted);
        }

        .news-card {
            overflow: hidden;
            transition: transform 0.22s ease, box-shadow 0.22s ease;
        }

        .news-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 34px rgba(15, 23, 42, 0.1);
        }

        .news-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }

        .news-content {
            display: grid;
            gap: 10px;
            padding: 20px;
        }

        .news-content h3 {
            margin: 0;
            font-size: 1.14rem;
            line-height: 1.25;
        }

        .news-content p {
            margin: 0;
            color: var(--muted);
            font-size: 0.96rem;
        }

        .auth-card {
            max-width: 640px;
            margin: 0 auto;
        }

        .auth-card,
        .prose-card,
        .feature-card,
        .table-card {
            display: grid;
            gap: var(--space-2);
        }

        .auth-form,
        .stack-form,
        .toolbar-form {
            display: grid;
            gap: var(--space-2);
        }

        .toolbar-form {
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            align-items: end;
        }

        .field-group {
            display: grid;
            gap: 8px;
        }

        .field-group label {
            font-weight: 700;
            color: #1e293b;
        }

        .field-group input,
        .field-group select,
        .field-group textarea,
        .toolbar-form input,
        .toolbar-form select,
        .toolbar-form textarea,
        .table-card input,
        .table-card textarea,
        .table-card select {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid var(--line-strong);
            border-radius: 14px;
            font: inherit;
            color: var(--ink);
            background: #ffffff;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .field-group textarea,
        .table-card textarea {
            min-height: 120px;
            resize: vertical;
        }

        .field-group input:focus,
        .field-group select:focus,
        .field-group textarea:focus,
        .toolbar-form input:focus,
        .toolbar-form select:focus,
        .toolbar-form textarea:focus,
        .table-card input:focus,
        .table-card textarea:focus,
        .table-card select:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.12);
            outline: none;
        }

        .field-group input.has-error,
        .field-group select.has-error,
        .field-group textarea.has-error {
            border-color: #dc2626;
            box-shadow: none;
        }

        .field-error {
            min-height: 1.1em;
            margin: 0;
            font-size: 0.86rem;
            color: #b91c1c;
        }

        .auth-btn,
        .link-btn,
        .table-card button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 46px;
            padding: 12px 16px;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--brand) 0%, #1c8d84 100%);
            color: #ffffff;
            font-weight: 800;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 12px 24px rgba(15, 118, 110, 0.16);
            transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.2s ease;
        }

        .auth-btn:hover,
        .link-btn:hover,
        .table-card button:hover {
            transform: translateY(-1px);
            box-shadow: 0 16px 28px rgba(15, 118, 110, 0.2);
        }

        .toolbar-form button,
        .toolbar-form .auth-btn,
        .toolbar-form .link-btn {
            width: 100%;
        }

        .user-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 680px;
        }

        .user-table th,
        .user-table td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid var(--line);
            vertical-align: top;
        }

        .user-table th {
            color: #0f172a;
            background: #f8fbfd;
            font-size: 0.9rem;
            font-weight: 800;
        }

        .user-table tr:last-child td {
            border-bottom: none;
        }

        .table-actions {
            display: grid;
            gap: 10px;
        }

        .admin-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            align-items: start;
        }

        .admin-grid > * {
            min-width: 0;
        }

        .admin-grid-full {
            grid-column: 1 / -1;
        }

        .table-scroll {
            overflow-x: auto;
            margin: 0 -24px -24px;
            padding: 0 24px 24px;
        }

        .table-scroll .user-table {
            min-width: 680px;
        }

        .panel-note {
            padding: 18px 20px;
        }

        .site-footer {
            border-top: 1px solid var(--line);
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
        }

        .footer-wrap {
            width: min(100% - 32px, var(--container));
            margin: 0 auto;
            padding: 18px 0 28px;
            text-align: center;
            color: #334155;
            font-size: 0.95rem;
        }

        .footer-wrap p {
            margin: 0;
        }

        .footer-wrap p + p {
            margin-top: 6px;
        }

        @media (max-width: 640px) {
            .header-wrap {
                justify-content: center;
                padding: 12px 0;
            }

            .user-meta {
                justify-content: center;
            }

            .site-nav ul {
                justify-content: center;
            }

            .container,
            .page-shell,
            .header-wrap,
            .footer-wrap {
                width: min(100% - 20px, var(--container));
            }

            .hero {
                padding: 22px;
                border-radius: 24px;
            }

            .section-heading {
                align-items: start;
            }

            .user-table {
                min-width: 560px;
            }
        }

        @media (max-width: 900px) {
            .hero-home,
            .admin-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 1100px) {
            .toolbar-form {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .toolbar-form button,
            .toolbar-form .auth-btn,
            .toolbar-form .link-btn {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 640px) {
            .toolbar-form {
                grid-template-columns: 1fr;
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
                <?php if ($currentUser !== null): ?>
                    <?php if (($currentUser['role'] ?? null) === 'admin'): ?>
                        <li><a href="admin.php">Admin</a></li>
                    <?php endif; ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a class="accent-link" href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <?php if ($currentUser !== null): ?>
            <div class="user-meta" aria-label="Current user">
                <span><?php echo htmlspecialchars($currentUser['full_name']); ?></span>
                <span class="role-badge"><?php echo htmlspecialchars($currentUser['role']); ?></span>
            </div>
        <?php endif; ?>
    </div>
</header>
<main class="page-shell">
    <div class="page-stack">
        <?php if ($successMessage !== null): ?>
            <div class="flash flash-success"><?php echo htmlspecialchars($successMessage); ?></div>
        <?php endif; ?>

        <?php if ($errorMessage !== null): ?>
            <div class="flash flash-error"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endif; ?>
