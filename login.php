<?php
declare(strict_types=1);

require_once __DIR__ . '/app/bootstrap.php';

$email = '';
$errors = [
	'email' => '',
	'password' => '',
];

if ($auth->check()) {
	$auth->redirectAfterLogin();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$email = strtolower(trim((string) ($_POST['email'] ?? '')));
	$password = (string) ($_POST['password'] ?? '');

	if ($email === '') {
		$errors['email'] = 'Email is required.';
	} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = 'Enter a valid email address.';
	}

	if ($password === '') {
		$errors['password'] = 'Password is required.';
	} elseif (strlen($password) < 8) {
		$errors['password'] = 'Password must be at least 8 characters.';
	}

	if (!array_filter($errors) && !$auth->attemptLogin($email, $password)) {
		$errors['password'] = 'The email or password is incorrect.';
	}

	if (!array_filter($errors)) {
		$auth->flash('success', 'Login successful.');
		$auth->redirectAfterLogin();
	}
}

$pageTitle = 'Login - News Portal';
include 'header.php';
?>

<section class="auth-card" aria-labelledby="login-title">
	<h2 id="login-title">Welcome Back</h2>
	<p class="auth-intro">Log in to continue reading and managing your personalized news feed.</p>

	<form id="loginForm" class="auth-form" action="login.php" method="post" novalidate>
		<div class="field-group">
			<label for="loginEmail">Email Address</label>
			<input type="email" id="loginEmail" name="email" value="<?php echo htmlspecialchars($email); ?>" autocomplete="email" required>
			<p class="field-error" id="loginEmailError"><?php echo htmlspecialchars($errors['email']); ?></p>
		</div>

		<div class="field-group">
			<label for="loginPassword">Password</label>
			<input type="password" id="loginPassword" name="password" autocomplete="current-password" required>
			<p class="field-error" id="loginPasswordError"><?php echo htmlspecialchars($errors['password']); ?></p>
		</div>

		<button type="submit" class="auth-btn">Log In</button>
	</form>
	<p class="helper-text">Use the account you registered. The first registered account is granted the admin role.</p>
</section>

<script>
	(function () {
		var form = document.getElementById('loginForm');
		var email = document.getElementById('loginEmail');
		var password = document.getElementById('loginPassword');
		var emailError = document.getElementById('loginEmailError');
		var passwordError = document.getElementById('loginPasswordError');

		function isValidEmail(value) {
			return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
		}

		function setError(input, errorNode, message) {
			errorNode.textContent = message;
			input.classList.toggle('has-error', message.length > 0);
		}

		setError(email, emailError, emailError.textContent.trim());
		setError(password, passwordError, passwordError.textContent.trim());

		form.addEventListener('submit', function (event) {
			var emailValue = email.value.trim();
			var passwordValue = password.value;
			var hasErrors = false;

			setError(email, emailError, '');
			setError(password, passwordError, '');

			if (!emailValue) {
				setError(email, emailError, 'Email is required.');
				hasErrors = true;
			} else if (!isValidEmail(emailValue)) {
				setError(email, emailError, 'Enter a valid email address.');
				hasErrors = true;
			}

			if (!passwordValue) {
				setError(password, passwordError, 'Password is required.');
				hasErrors = true;
			} else if (passwordValue.length < 8) {
				setError(password, passwordError, 'Password must be at least 8 characters.');
				hasErrors = true;
			}

			if (hasErrors) {
				event.preventDefault();
			}
		});
	})();
</script>

<?php include 'footer.php'; ?>
