<?php
declare(strict_types=1);

namespace App\Auth;

use RuntimeException;

final class UserRepository
{
	public function __construct(private string $storagePath)
	{
		$this->ensureStorageExists();
	}

	public function all(): array
	{
		$records = $this->readStorage();

		return array_map(static fn (array $record): User => User::fromArray($record), $records);
	}

	public function count(): int
	{
		return count($this->readStorage());
	}

	public function findByEmail(string $email): ?User
	{
		$normalizedEmail = strtolower($email);

		foreach ($this->all() as $user) {
			if ($user->getEmail() === $normalizedEmail) {
				return $user;
			}
		}

		return null;
	}

	public function save(User $user): void
	{
		$records = $this->readStorage();
		$records[] = $user->toArray();
		$this->writeStorage($records);
	}

	private function ensureStorageExists(): void
	{
		$directory = dirname($this->storagePath);

		if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
			throw new RuntimeException('Unable to create storage directory.');
		}

		if (!file_exists($this->storagePath) && file_put_contents($this->storagePath, json_encode([], JSON_PRETTY_PRINT)) === false) {
			throw new RuntimeException('Unable to initialize user storage.');
		}
	}

	private function readStorage(): array
	{
		$content = file_get_contents($this->storagePath);

		if ($content === false) {
			throw new RuntimeException('Unable to read user storage.');
		}

		$records = json_decode($content, true);

		if (!is_array($records)) {
			return [];
		}

		return $records;
	}

	private function writeStorage(array $records): void
	{
		$encoded = json_encode($records, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

		if ($encoded === false || file_put_contents($this->storagePath, $encoded, LOCK_EX) === false) {
			throw new RuntimeException('Unable to write user storage.');
		}
	}
}