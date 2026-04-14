<?php
declare(strict_types=1);

require_once __DIR__ . '/app/bootstrap.php';

$auth->requireAuth('login.php');
$auth->requireRole('admin', 'news.php');

$pageTitle = 'Admin Dashboard - News Portal';
$users = $auth->allUsers();

include 'header.php';
?>

<section class="hero">
	<h2>Admin Dashboard</h2>
	<p>
		Review registered users and confirm which accounts can access admin-only controls.
	</p>
</section>

<section>
	<h2 class="section-title">Registered Users</h2>
	<div class="table-card">
		<table class="user-table">
			<thead>
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th>Role</th>
					<th>Joined</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($users as $user): ?>
					<tr>
						<td><?php echo htmlspecialchars($user['full_name']); ?></td>
						<td><?php echo htmlspecialchars($user['email']); ?></td>
						<td><span class="role-pill"><?php echo htmlspecialchars(ucfirst($user['role'])); ?></span></td>
						<td><?php echo htmlspecialchars(date('M j, Y', strtotime($user['created_at']))); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</section>

<?php include 'footer.php'; ?>