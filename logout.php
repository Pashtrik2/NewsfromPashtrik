<?php
declare(strict_types=1);

require_once __DIR__ . '/app/bootstrap.php';
require_once __DIR__ . '/app/database.php';

if ($auth->check()) {
	$auth->logout();
	$session = new \App\Auth\SessionManager();
	$session->start();
	$session->flash('success', 'You have been logged out.');
}

header('Location: login.php');
exit;