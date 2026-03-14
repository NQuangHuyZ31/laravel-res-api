<?php

namespace App\Services;

use App\Repositories\UserRepository\UserRepositoryInterface;

class UserService {

	public function __construct(protected UserRepositoryInterface $userRepository){}

	public function getAll() {
		return $this->userRepository->getAll();
	}

	public function find(int $id) {
		return $this->userRepository->find($id);
	}

	public function create(array $data) {

		return $this->userRepository->create($data);
	}
}