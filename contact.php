<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$pageTitle = 'Contact - News Portal';
include 'header.php';
require_once __DIR__ . '/app/database.php';
require_once __DIR__ . '/app/ContactMessage.php';

$name = $email = $message = '';
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '') {
        $errors['name'] = 'Name is required.';
    }
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'A valid email is required.';
    }
    if ($message === '') {
        $errors['message'] = 'Message is required.';
    }

    if (empty($errors)) {
        $contact = new ContactMessage($conn);
        $contact->name = $name;
        $contact->email = $email;
        $contact->message = $message;
        if ($contact->create()) {
            $success = true;
            $name = $email = $message = '';
        } else {
            $errors['general'] = 'Failed to send message. Please try again.';
        }
    }
}
?>
<section class="hero">
    <div class="hero-copy">
        <span class="hero-badge">Contact</span>
        <h2 class="hero-title">Reach the editorial desk</h2>
        <p class="hero-text">Send feedback, story ideas, or technical questions using the form below.</p>
    </div>
</section>

<section class="auth-card" aria-labelledby="contact-title">
    <h2 id="contact-title">Send a Message</h2>
    <p class="auth-intro">We review incoming messages regularly and respond when follow-up is needed.</p>
    <?php if ($success): ?>
        <div class="flash flash-success">Thank you! Your message has been sent.</div>
    <?php endif; ?>
    <?php if (!empty($errors['general'])): ?>
        <div class="flash flash-error"><?php echo htmlspecialchars($errors['general']); ?></div>
    <?php endif; ?>
    <form id="contactForm" class="auth-form" method="post" novalidate>
        <div class="field-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            <p class="field-error" id="nameError"><?php echo htmlspecialchars($errors['name'] ?? ''); ?></p>
        </div>

        <div class="field-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            <p class="field-error" id="emailError"><?php echo htmlspecialchars($errors['email'] ?? ''); ?></p>
        </div>

        <div class="field-group">
            <label for="message">Message</label>
            <textarea id="message" name="message" required><?php echo htmlspecialchars($message); ?></textarea>
            <p class="field-error" id="messageError"><?php echo htmlspecialchars($errors['message'] ?? ''); ?></p>
        </div>

        <button class="auth-btn" type="submit">Send Message</button>
    </form>
</section>
<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    let valid = true;
    let name = document.getElementById('name');
    let email = document.getElementById('email');
    let message = document.getElementById('message');
    let nameError = document.getElementById('nameError');
    let emailError = document.getElementById('emailError');
    let messageError = document.getElementById('messageError');
    nameError.textContent = '';
    emailError.textContent = '';
    messageError.textContent = '';
    if (name.value.trim() === '') {
        nameError.textContent = 'Name is required.';
        valid = false;
    }
    if (email.value.trim() === '' || !/^\S+@\S+\.\S+$/.test(email.value)) {
        emailError.textContent = 'A valid email is required.';
        valid = false;
    }
    if (message.value.trim() === '') {
        messageError.textContent = 'Message is required.';
        valid = false;
    }
    if (!valid) e.preventDefault();
});
</script>
<?php include 'footer.php'; ?>
