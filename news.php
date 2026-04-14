<?php
declare(strict_types=1);

require_once __DIR__ . '/app/bootstrap.php';

$auth->requireAuth('login.php');

$pageTitle = 'News - News Portal';
include 'header.php';
?>

<section class="hero">
	<h2>Latest Headlines and Breaking Updates</h2>
	<p>
		Explore curated stories across world news, technology, business, and society,
		presented in a clean and easy-to-read layout.
	</p>
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

<section>
	<h2 class="section-title">Today's Coverage</h2>
	<div class="news-grid">
		<article class="news-card">
			<img src="https://picsum.photos/600/400?random=21" alt="Reporter holding a microphone in city center">
			<div class="news-content">
				<h3>International Summit Focuses on Climate and Energy</h3>
				<p>Global leaders discuss new commitments designed to speed up clean energy transition plans.</p>
			</div>
		</article>

		<article class="news-card">
			<img src="https://picsum.photos/600/400?random=22" alt="Close-up of laptop with stock market chart">
			<div class="news-content">
				<h3>Startup Investments Rebound in Early Quarter Reports</h3>
				<p>Analysts cite stronger investor confidence in AI, health tech, and sustainable infrastructure.</p>
			</div>
		</article>

		<article class="news-card">
			<img src="https://picsum.photos/600/400?random=23" alt="Smartphone showing social media notifications">
			<div class="news-content">
				<h3>Digital Safety Campaign Targets Misinformation Awareness</h3>
				<p>Community initiatives encourage critical reading habits and improved source verification.</p>
			</div>
		</article>

		<article class="news-card">
			<img src="https://picsum.photos/600/400?random=24" alt="Aerial view of high-speed train passing through countryside">
			<div class="news-content">
				<h3>Transport Authorities Announce New High-Speed Rail Plan</h3>
				<p>The project aims to improve regional connectivity and reduce travel times over the next decade.</p>
			</div>
		</article>

		<article class="news-card">
			<img src="https://picsum.photos/600/400?random=25" alt="Scientists in laboratory discussing results">
			<div class="news-content">
				<h3>Medical Researchers Report Progress in Preventive Care</h3>
				<p>Recent trials show promising outcomes for early detection tools in public health programs.</p>
			</div>
		</article>

		<article class="news-card">
			<img src="https://picsum.photos/600/400?random=26" alt="Local community event in public square">
			<div class="news-content">
				<h3>Local Communities Launch Weekend Cultural Events</h3>
				<p>Organizers highlight art, food, and music to bring neighborhoods together.</p>
			</div>
		</article>
	</div>
</section>

<?php if ($auth->isAdmin()): ?>
	<section>
		<h2 class="section-title">Admin Notes</h2>
		<div class="table-card" style="padding: 18px 20px;">
			<p class="helper-text" style="margin-bottom: 10px;">
				Your admin role gives you access to the protected dashboard and the full member content set.
			</p>
			<a class="auth-btn" href="admin.php" style="display: inline-block; text-decoration: none;">Open Admin Dashboard</a>
		</div>
	</section>
<?php endif; ?>

<?php include 'footer.php'; ?>
