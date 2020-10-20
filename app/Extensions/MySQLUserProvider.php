<?php
	namespace App\Extensions;

	use Illuminate\Contracts\Auth\UserProvider;
	use Illuminate\Contracts\Auth\Authenticatable;
	use App\Models\MySQLUser;

	class MySQLUserProvider implements UserProvider {

		public function retrieveById($identifier) {
			$user = session()->get('user');
			return $user && $user->getAuthIdentifier() === $identifier ? $user : null;
		}

		public function retrieveByToken($identifier, $token) {
			return null;
		}

		public function updateRememberToken($user, $token) {

		}

		public function retrieveByCredentials(array $credentials): ?Authenticatable {
			return MySQLUser::retrieveByCredentials($credentials);
		}

		public function validateCredentials(Authenticatable $user, array $credentials): bool {
			return $user->getAuthIdentifier() === $credentials['username'] && $user->getAuthPassword() === $credentials['password'];
		}
	}
