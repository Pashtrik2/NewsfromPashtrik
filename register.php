<?php
$pageTitle = 'Register - News Portal';
include 'header.php';
?>

<section class="auth-card" aria-labelledby="register-title">
	<h2 id="register-title">Create Your Account</h2>
	<p class="auth-intro">Join the portal to bookmark stories and receive updates from your favorite categories.</p>

	<form id="registerForm" class="auth-form" action="#" method="post" novalidate>
		<div class="field-group">
			<label for="registerName">Full Name</label>
			<input type="text" id="registerName" name="full_name" autocomplete="name" required>
			<p class="field-error" id="registerNameError"></p>
		</div>

		<div class="field-group">
			<label for="registerEmail">Email Address</label>
			<input type="email" id="registerEmail" name="email" autocomplete="email" required>
			<p class="field-error" id="registerEmailError"></p>
		</div>

		<div class="field-group">
			<label for="registerPassword">Password</label>
			<input type="password" id="registerPassword" name="password" autocomplete="new-password" required>
			<p class="field-error" id="registerPasswordError"></p>
		</div>

		<div class="field-group">
			<label for="confirmPassword">Confirm Password</label>
			<input type="password" id="confirmPassword" name="confirm_password" autocomplete="new-password" required>
			<p class="field-error" id="confirmPasswordError"></p>
		</div>

		<button type="submit" class="auth-btn">Create Account</button>
	</form>
</section>

<style>
	.auth-card {
		max-width: 520px;
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
