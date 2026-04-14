<?php
declare(strict_types=1);

namespace App\Auth;

final class AuthService
{
	private const SESSION_USER_KEY = 'auth_user';

	public function __construct(
		private UserRepository $users,
		private SessionManager $session
	) {
	}

	public function register(string $fullName, string $email, string $password): User
	{
		$role = $this->users->count() === 0 ? 'admin' : 'user';
		$user = User::create($fullName, $email, password_hash($password, PASSWORD_DEFAULT), $role);
		$this->users->save($user);

		return $user;
	}

	public function attemptLogin(string $email, string $password): bool
	{
		$user = $this->users->findByEmail($email);

		if ($user === null || !password_verify($password, $user->getPasswordHash())) {
			return false;
		}

		$this->session->regenerate();
		$this->session->put(self::SESSION_USER_KEY, $user->withoutPasswordHash());

		return true;
	}

	public function logout(): void
	{
		$this->session->destroy();
	}

	public function check(): bool
	{
		return is_array($this->session->get(self::SESSION_USER_KEY));
	}

	public function user(): ?array
	{
		$user = $this->session->get(self::SESSION_USER_KEY);

		return is_array($user) ? $user : null;
	}

	public function isAdmin(): bool
	{
		return ($this->user()['role'] ?? null) === 'admin';
	}

	public function hasRole(string $role): bool
	{
		return ($this->user()['role'] ?? null) === $role;
	}

	public function requireAuth(string $redirectTo = 'login.php'): void
	{
		if ($this->check()) {
			return;
		}

		$this->session->flash('error', 'Please log in to continue.');
		$this->redirect($redirectTo);
	}

	public function requireRole(string $role, string $redirectTo = 'index.php'): void
	{
		if ($this->hasRole($role)) {
			return;
		}

		$this->session->flash('error', 'You do not have permission to access that page.');
		$this->redirect($redirectTo);
	}

	public function redirectAfterLogin(): void
	{
		$this->redirect($this->isAdmin() ? 'admin.php' : 'news.php');
	}

	public function redirect(string $path): void
	{
		header('Location: ' . $path);
		exit;
	}

	public function flash(string $key, string $message): void
	{
		$this->session->flash($key, $message);
	}

	public function pullFlash(string $key): ?string
	{
		return $this->session->pullFlash($key);
	}

	public function emailExists(string $email): bool
	{
		return $this->users->findByEmail($email) !== null;
	}

	public function allUsers(): array
	{
		return array_map(
			static fn (User $user): array => $user->withoutPasswordHash(),
			$this->users->all()
		);
	}
}