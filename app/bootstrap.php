<?php
declare(strict_types=1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/Auth/User.php';
require_once __DIR__ . '/Auth/SessionManager.php';
require_once __DIR__ . '/Auth/UserRepository.php';
require_once __DIR__ . '/Auth/AuthService.php';

use App\Auth\AuthService;
use App\Auth\SessionManager;
use App\Auth\UserRepository;

function resolveUserStoragePath(): string
{
	$projectStorageDirectory = __DIR__ . '/../storage';
	$tempStorageDirectory = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'newsfrompashtrik-storage';

	foreach ([$projectStorageDirectory, $tempStorageDirectory] as $directory) {
		if (is_dir($directory) && is_writable($directory)) {
			return $directory . '/users.json';
		}

		if (!is_dir($directory) && @mkdir($directory, 0775, true) && is_writable($directory)) {
			return $directory . '/users.json';
		}
	}

	throw new RuntimeException('No writable storage directory is available for user accounts.');
}

$session = new SessionManager();
$session->start();

$userRepository = new UserRepository(resolveUserStoragePath());
$auth = new AuthService($userRepository, $session);