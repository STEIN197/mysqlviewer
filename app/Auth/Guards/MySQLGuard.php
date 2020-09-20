<?php
namespace App\Auth\Guards;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

/**
 * Class PinGuard
 */
class MySQLGuard implements Guard
{
    protected $user;
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function check(): bool {
        return (bool) $this->user();
    }

    public function guest(): bool {
        return !$this->check();
    }

    public function id(): ?string {
        $user = $this->user();
        return $user->id ?? null;
    }

    public function setUser(?Authenticatable $user): self {
        $this->user = $user;
        return $this;
    }

    public function validate(array $credentials = []): bool {
        throw new \BadMethodCallException('Unexpected method call');
    }

    public function authenticate(): User
    {
        $user = $this->user();
        if ($user instanceof User) {
            return $user;
        }
        throw new AuthenticationException();
    }

    public function user(): ?User
    {
        return $this->user ?: $this->signIn();
    }

    /**
     * Sign in using requested PIN.
     *
     * @return null|User
     */
    protected function signIn(): ?User
    {
        $user = new User;
		$user->username = $this->request->input('username');
		$user->password = Hash::make($this->request->input('password'));
		return $user;
    }

    /**
     * Logout user.
     */
    public function logout(): void {
        if ($this->user) {
            $this->setUser(null);
        }
    }
}