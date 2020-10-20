<?php
namespace App\Auth\Guards;

use Illuminate\Support\Facades\Hash;
use App\Models\MySQLUser;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;


class MySQLGuard implements Guard {

    protected $user;

    public function check(): bool {
        return $this->user() !== null;
    }

    public function guest(): bool {
        return !$this->check();
    }

    public function id(): ?string {
		return $this->user() ? $this->user()->getAuthIdentifier() : null;
    }

    public function validate(array $credentials = []): bool {
		return $this->user->getAuthIdentifier() === $credentials['username'] && $this->user->getAuthPassword() === $credentials['password'];
    }
	
	public function user(): ?Authenticatable {
		return $this->user ?? $this->user = session()->get('user');
	}

	public function setUser(?Authenticatable $user): void {
		$this->user = $user;
	}

	public function login(array $credentials): bool {
		$this->user = MySQLUser::retrieveByCredentials($credentials);
		return $this->user !== null;
	}

	public function logout(): void {
		$this->user = null;
		session()->forget('user');
	}
}