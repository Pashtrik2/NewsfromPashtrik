<?php
$pageTitle = 'About - News Portal';
include 'header.php';
require_once __DIR__ . '/app/database.php';
?>
<section class="hero">
    <div class="hero-copy">
        <span class="hero-badge">About</span>
        <h2 class="hero-title">A simpler way to read the day</h2>
        <p class="hero-text">News Portal is built to make browsing headlines feel lighter, faster, and easier to follow across every screen size.</p>
    </div>
</section>

<section class="section-shell">
    <div class="section-heading">
        <div>
            <p class="section-kicker">What We Do</p>
            <h2 class="section-title">Focused content, clean presentation</h2>
        </div>
        <p class="section-description">We keep the experience minimal so the content stays central and the layout stays readable.</p>
    </div>
    <div class="feature-grid">
        <article class="feature-card">
            <h3>Clarity First</h3>
            <p>Stories are presented in a compact structure with clean spacing and readable hierarchy.</p>
        </article>
        <article class="feature-card">
            <h3>Responsive Design</h3>
            <p>The interface adapts across desktop and mobile without losing alignment or visual rhythm.</p>
        </article>
        <article class="feature-card">
            <h3>Editorial Simplicity</h3>
            <p>Important updates stay easy to scan without clutter, noise, or distracting layout shifts.</p>
        </article>
    </div>
</section>
<?php include 'footer.php'; ?>
