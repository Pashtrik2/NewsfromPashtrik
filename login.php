<?php
$pageTitle = 'Login - News Portal';
include 'header.php';
?>

<section class="auth-card" aria-labelledby="login-title">
	<h2 id="login-title">Welcome Back</h2>
	<p class="auth-intro">Log in to continue reading and managing your personalized news feed.</p>

	<form id="loginForm" class="auth-form" action="#" method="post" novalidate>
		<div class="field-group">
			<label for="loginEmail">Email Address</label>
			<input type="email" id="loginEmail" name="email" autocomplete="email" required>
			<p class="field-error" id="loginEmailError"></p>
		</div>

		<div class="field-group">
			<label for="loginPassword">Password</label>
			<input type="password" id="loginPassword" name="password" autocomplete="current-password" required>
			<p class="field-error" id="loginPasswordError"></p>
		</div>

		<button type="submit" class="auth-btn">Log In</button>
	</form>
</section>

<style>
	.auth-card {
		max-width: 480px;
		margin: 24px auto;
		padding: 24px;
		background: #ffffff;
		border: 1px solid #dbe3ec;
		border-radius: 16px;
		box-shadow: 0 14px 40px rgba(15, 23, 42, 0.08);
	}

	.auth-card h2 {
		margin: 0 0 6px;
		color: #0f172a;
	}

	.auth-intro {
		margin: 0 0 18px;
		color: #64748b;
	}

	.auth-form {
		display: grid;
		gap: 14px;
	}

	.field-group {
		display: grid;
		gap: 6px;
	}

	.field-group label {
		font-weight: 600;
		color: #1e293b;
	}

	.field-group input {
		width: 100%;
		padding: 10px 12px;
		border: 1px solid #cbd5e1;
		border-radius: 10px;
		font: inherit;
	}

	.field-group input:focus {
		border-color: #0f766e;
		outline: 2px solid rgba(15, 118, 110, 0.2);
		outline-offset: 1px;
	}

	.field-group input.has-error {
		border-color: #dc2626;
		outline: none;
	}

	.field-error {
		min-height: 1.1em;
		margin: 0;
		font-size: 0.86rem;
		color: #b91c1c;
	}

	.auth-btn {
		padding: 11px 14px;
		border: none;
		border-radius: 10px;
		background: #0f766e;
		color: #ffffff;
		font-weight: 700;
		cursor: pointer;
	}

	.auth-btn:hover {
		background: #115e59;
	}
</style>

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
