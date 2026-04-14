<?php
declare(strict_types=1);

namespace App\Auth;

final class User
{
	public function __construct(
		private string $id,
		private string $fullName,
		private string $email,
		private string $passwordHash,
		private string $role,
		private string $createdAt
	) {
	}

	public static function create(string $fullName, string $email, string $passwordHash, string $role): self
	{
		return new self(
			bin2hex(random_bytes(16)),
			$fullName,
			strtolower($email),
			$passwordHash,
			$role,
			date(DATE_ATOM)
		);
	}

	public static function fromArray(array $data): self
	{
		return new self(
			(string) $data['id'],
			(string) $data['full_name'],
			(string) $data['email'],
			(string) $data['password_hash'],
			(string) $data['role'],
			(string) $data['created_at']
		);
	}

	public function toArray(): array
	{
		return [
			'id' => $this->id,
			'full_name' => $this->fullName,
			'email' => $this->email,
			'password_hash' => $this->passwordHash,
			'role' => $this->role,
			'created_at' => $this->createdAt,
		];
	}

	public function getId(): string
	{
		return $this->id;
	}

	public function getFullName(): string
	{
		return $this->fullName;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function getPasswordHash(): string
	{
		return $this->passwordHash;
	}

	public function getRole(): string
	{
		return $this->role;
	}

	public function getCreatedAt(): string
	{
		return $this->createdAt;
	}

	public function isAdmin(): bool
	{
		return $this->role === 'admin';
	}

	public function withoutPasswordHash(): array
	{
		return [
			'id' => $this->id,
			'full_name' => $this->fullName,
			'email' => $this->email,
			'role' => $this->role,
			'created_at' => $this->createdAt,
		];
	}
}