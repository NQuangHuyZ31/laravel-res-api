<?php

namespace App\Repositories\UserRepository;

use App\Repositories\BaseRepository;
use League\Uri\Contracts\UserInfoInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface {

	public function getModel()
	{
		return \App\Models\User::class;
	}

	public function getEmailUser()
	{
		throw new \Exception('Not implemented');
	}

}