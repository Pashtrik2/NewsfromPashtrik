<?php
declare(strict_types=1);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/app/bootstrap.php';
require_once __DIR__ . '/app/database.php';

$auth->requireAuth('login.php');

$pageTitle = 'News - News Portal';
include 'header.php';
?>
<section class="hero">
    <div class="hero-copy">
        <span class="hero-badge">Members</span>
        <h2 class="hero-title">Latest headlines and breaking updates</h2>
        <p class="hero-text">Explore curated stories across world news, technology, business, and society in a layout designed to stay fast and readable.</p>
    </div>
</section>
<section class="auth-card">
    <h2>Member Access</h2>
    <p class="auth-intro">
        Signed in as <strong><?php echo htmlspecialchars($auth->user()['full_name']); ?></strong>
        with the <strong><?php echo htmlspecialchars($auth->user()['role']); ?></strong> role.
    </p>
    <?php if ($auth->isAdmin()): ?>
        <p class="helper-text">Admins can review account activity from the dashboard and still access all member news content.</p>
    <?php else: ?>
        <p class="helper-text">Standard users can view protected news content after logging in.</p>
    <?php endif; ?>
</section>
<section class="section-shell">
    <div class="section-heading">
        <div>
            <p class="section-kicker">Coverage</p>
            <h2 class="section-title">Today's news selection</h2>
        </div>
        <p class="section-description">Protected member content is shown here after authentication.</p>
    </div>
    <div class="news-grid">
        <?php
        require_once __DIR__ . '/app/News.php';
        $newsObj = new News($conn);
        echo $newsObj->displayNews();
        ?>
    </div>
</section>

<?php if ($auth->isAdmin()): ?>
    <section class="prose-card">
        <h3>Admin Access</h3>
        <p>Your role includes access to the full dashboard for managing stories, products, and incoming messages.</p>
        <a class="link-btn" href="admin.php">Open Admin Dashboard</a>
    </section>
<?php endif; ?>

<?php include 'footer.php'; ?>
