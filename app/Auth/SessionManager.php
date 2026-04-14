<?php
declare(strict_types=1);

namespace App\Auth;

final class SessionManager
{
	public function start(): void
	{
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
	}

	public function regenerate(): void
	{
		$this->start();
		session_regenerate_id(true);
	}

	public function put(string $key, mixed $value): void
	{
		$this->start();
		$_SESSION[$key] = $value;
	}

	public function get(string $key, mixed $default = null): mixed
	{
		$this->start();

		return $_SESSION[$key] ?? $default;
	}

	public function forget(string $key): void
	{
		$this->start();
		unset($_SESSION[$key]);
	}

	public function flash(string $key, string $message): void
	{
		$this->start();
		$_SESSION['_flash'][$key] = $message;
	}

	public function pullFlash(string $key): ?string
	{
		$this->start();

		if (!isset($_SESSION['_flash'][$key])) {
			return null;
		}

		$message = (string) $_SESSION['_flash'][$key];
		unset($_SESSION['_flash'][$key]);

		if (empty($_SESSION['_flash'])) {
			unset($_SESSION['_flash']);
		}

		return $message;
	}

	public function destroy(): void
	{
		$this->start();
		$_SESSION = [];

		if (ini_get('session.use_cookies')) {
			$params = session_get_cookie_params();
			setcookie(
				session_name(),
				'',
				time() - 42000,
				$params['path'],
				$params['domain'],
				(bool) $params['secure'],
				(bool) $params['httponly']
			);
		}

		session_destroy();
	}
}