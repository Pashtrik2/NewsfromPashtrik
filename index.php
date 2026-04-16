<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/app/bootstrap.php';
require_once __DIR__ . '/app/database.php';

$pageTitle = 'Home - News Portal';
include 'header.php';
include 'swiper-head.html';
?>
<section class="hero hero-home">
    <div class="hero-copy">
        <span class="hero-badge">Daily Briefing</span>
        <h2 class="hero-title">Stay Updated With What Matters Today</h2>
        <p class="hero-text">Your daily source for top stories in technology, world events, business, and culture. Clear headlines, fast reads, and reliable updates in one focused feed.</p>
    </div>
    <div class="hero-metrics" aria-label="News portal highlights">
        <div class="stat-card">
            <strong>24/7</strong>
            <span>Live coverage and fresh stories throughout the day</span>
        </div>
        <div class="stat-card">
            <strong>4</strong>
            <span>Core beats: world, business, technology, and culture</span>
        </div>
        <div class="stat-card">
            <strong>Fast</strong>
            <span>Compact summaries designed for quick reading</span>
        </div>
    </div>
</section>
<?php if ($auth->check()): ?>
    <section class="auth-card">
        <h2>Welcome Back, <?php echo htmlspecialchars($auth->user()['full_name']); ?></h2>
        <p class="auth-intro">
            You are signed in as <strong><?php echo htmlspecialchars($auth->user()['role']); ?></strong>.
            <?php if ($auth->isAdmin()): ?>
                Use the admin area to review registered accounts.
            <?php else: ?>
                Your account can access member-only news content.
            <?php endif; ?>
        </p>
    </section>
<?php endif; ?>
<section class="section-shell">
    <div class="section-heading">
        <div>
            <p class="section-kicker">Top Stories</p>
            <h2 class="section-title">Latest stories from the newsroom</h2>
        </div>
        <p class="section-description">A quick scan of featured topics with a cleaner layout and tighter reading rhythm.</p>
    </div>
    <div class="swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="https://picsum.photos/600/400?random=11" alt="City skyline at sunrise">
                <h3>Global Markets Open Higher as Tech Leads Gains</h3>
                <p>Investors react to positive earnings reports and renewed optimism across major sectors.</p>
            </div>
            <div class="swiper-slide">
                <img src="https://picsum.photos/600/400?random=12" alt="Modern newsroom desk with screens">
                <h3>New AI Tools Reshape How Journalists Report Live Events</h3>
                <p>Newsrooms are adopting faster workflows while balancing fact-checking and editorial standards.</p>
            </div>
            <div class="swiper-slide">
                <img src="https://picsum.photos/600/400?random=13" alt="People walking in a busy city street">
                <h3>Urban Innovation Projects Improve Public Transit Access</h3>
                <p>City planners roll out smart mobility updates aimed at reducing commute times.</p>
            </div>
            <!-- Add more slides as needed -->
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Navigation -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</section>

<?php include 'footer.php'; ?>
