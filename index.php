<?php
require_once __DIR__ . '/app/bootstrap.php';

$pageTitle = 'Home - News Portal';
include 'header.php';
?>

<section class="hero">
	<h2>Stay Updated With What Matters Today</h2>
	<p>
		Your daily source for top stories in technology, world events, business,
		and culture. Clean headlines, quick reads, and reliable updates.
	</p>
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

<section>
	<h2 class="section-title">Top Stories</h2>
	<div class="news-grid">
		<article class="news-card">
			<img src="https://picsum.photos/600/400?random=11" alt="City skyline at sunrise">
			<div class="news-content">
				<h3>Global Markets Open Higher as Tech Leads Gains</h3>
				<p>Investors react to positive earnings reports and renewed optimism across major sectors.</p>
			</div>
		</article>

		<article class="news-card">
			<img src="https://picsum.photos/600/400?random=12" alt="Modern newsroom desk with screens">
			<div class="news-content">
				<h3>New AI Tools Reshape How Journalists Report Live Events</h3>
				<p>Newsrooms are adopting faster workflows while balancing fact-checking and editorial standards.</p>
			</div>
		</article>

		<article class="news-card">
			<img src="https://picsum.photos/600/400?random=13" alt="People walking in a busy city street">
			<div class="news-content">
				<h3>Urban Innovation Projects Improve Public Transit Access</h3>
				<p>City planners roll out smart mobility updates aimed at reducing commute times.</p>
			</div>
		</article>
	</div>
</section>

<?php include 'footer.php'; ?>
