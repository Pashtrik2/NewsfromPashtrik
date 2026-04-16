<?php
declare(strict_types=1);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/app/bootstrap.php';
require_once __DIR__ . '/app/database.php';

$fullName = '';
$email = '';
$errors = [
	'full_name' => '',
	'email' => '',
	'password' => '',
	'confirm_password' => '',
];

if ($auth->check()) {
	$auth->redirectAfterLogin();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$fullName = trim((string) ($_POST['full_name'] ?? ''));
	$email = strtolower(trim((string) ($_POST['email'] ?? '')));
	$password = (string) ($_POST['password'] ?? '');
	$confirmPassword = (string) ($_POST['confirm_password'] ?? '');

	if ($fullName === '') {
		$errors['full_name'] = 'Full name is required.';
	}

	if ($email === '') {
		$errors['email'] = 'Email is required.';
	} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = 'Enter a valid email address.';
	} elseif ($auth->emailExists($email)) {
		$errors['email'] = 'An account with this email already exists.';
	}

	if ($password === '') {
		$errors['password'] = 'Password is required.';
	} elseif (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) {
		$errors['password'] = 'Use at least 8 characters with letters and numbers.';
	}

	if ($confirmPassword === '') {
		$errors['confirm_password'] = 'Please confirm your password.';
	} elseif ($password !== $confirmPassword) {
		$errors['confirm_password'] = 'Passwords do not match.';
	}

	if (!array_filter($errors)) {
		$newUser = $auth->register($fullName, $email, $password);
		$auth->flash(
			'success',
			$newUser->isAdmin()
				? 'Account created. You are the first user, so your role is admin. Please log in.'
				: 'Account created successfully. Please log in.'
		);
		$auth->redirect('login.php');
	}
}

$pageTitle = 'Register - News Portal';
include 'header.php';
?>

<section class="auth-card" aria-labelledby="register-title">
	<h2 id="register-title">Create Your Account</h2>
	<p class="auth-intro">Join the portal to bookmark stories and receive updates from your favorite categories.</p>

	<form id="registerForm" class="auth-form" action="register.php" method="post" novalidate>
		<div class="field-group">
			<label for="registerName">Full Name</label>
			<input type="text" id="registerName" name="full_name" value="<?php echo htmlspecialchars($fullName); ?>" autocomplete="name" required>
			<p class="field-error" id="registerNameError"><?php echo htmlspecialchars($errors['full_name']); ?></p>
		</div>

		<div class="field-group">
			<label for="registerEmail">Email Address</label>
			<input type="email" id="registerEmail" name="email" value="<?php echo htmlspecialchars($email); ?>" autocomplete="email" required>
			<p class="field-error" id="registerEmailError"><?php echo htmlspecialchars($errors['email']); ?></p>
		</div>

		<div class="field-group">
			<label for="registerPassword">Password</label>
			<input type="password" id="registerPassword" name="password" autocomplete="new-password" required>
			<p class="field-error" id="registerPasswordError"><?php echo htmlspecialchars($errors['password']); ?></p>
		</div>

		<div class="field-group">
			<label for="confirmPassword">Confirm Password</label>
			<input type="password" id="confirmPassword" name="confirm_password" autocomplete="new-password" required>
			<p class="field-error" id="confirmPasswordError"><?php echo htmlspecialchars($errors['confirm_password']); ?></p>
		</div>

		<button type="submit" class="auth-btn">Create Account</button>
	</form>
	<p class="helper-text">The first account registered in this app is assigned the admin role. Later accounts are standard users.</p>
</section>

<script>
	(function () {
		var form = document.getElementById('registerForm');
		var nameInput = document.getElementById('registerName');
		var emailInput = document.getElementById('registerEmail');
		var passwordInput = document.getElementById('registerPassword');
		var confirmInput = document.getElementById('confirmPassword');

		var nameError = document.getElementById('registerNameError');
		var emailError = document.getElementById('registerEmailError');
		var passwordError = document.getElementById('registerPasswordError');
		var confirmError = document.getElementById('confirmPasswordError');

		function isValidEmail(value) {
			return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
		}

		function isStrongPassword(value) {
			var hasLetter = /[A-Za-z]/.test(value);
			var hasNumber = /[0-9]/.test(value);
			return value.length >= 8 && hasLetter && hasNumber;
		}

		function setError(input, errorNode, message) {
			errorNode.textContent = message;
			input.classList.toggle('has-error', message.length > 0);
		}

		setError(nameInput, nameError, nameError.textContent.trim());
		setError(emailInput, emailError, emailError.textContent.trim());
		setError(passwordInput, passwordError, passwordError.textContent.trim());
		setError(confirmInput, confirmError, confirmError.textContent.trim());

		form.addEventListener('submit', function (event) {
			var nameValue = nameInput.value.trim();
			var emailValue = emailInput.value.trim();
			var passwordValue = passwordInput.value;
			var confirmValue = confirmInput.value;
			var hasErrors = false;

			setError(nameInput, nameError, '');
			setError(emailInput, emailError, '');
			setError(passwordInput, passwordError, '');
			setError(confirmInput, confirmError, '');

			if (!nameValue) {
				setError(nameInput, nameError, 'Full name is required.');
				hasErrors = true;
			}

			if (!emailValue) {
				setError(emailInput, emailError, 'Email is required.');
				hasErrors = true;
			} else if (!isValidEmail(emailValue)) {
				setError(emailInput, emailError, 'Enter a valid email address.');
				hasErrors = true;
			}

			if (!passwordValue) {
				setError(passwordInput, passwordError, 'Password is required.');
				hasErrors = true;
			} else if (!isStrongPassword(passwordValue)) {
				setError(passwordInput, passwordError, 'Use at least 8 characters with letters and numbers.');
				hasErrors = true;
			}

			if (!confirmValue) {
				setError(confirmInput, confirmError, 'Please confirm your password.');
				hasErrors = true;
			} else if (passwordValue !== confirmValue) {
				setError(confirmInput, confirmError, 'Passwords do not match.');
				hasErrors = true;
			}

			if (hasErrors) {
				event.preventDefault();
			}
		});
	})();
</script>

<?php include 'footer.php'; ?>
