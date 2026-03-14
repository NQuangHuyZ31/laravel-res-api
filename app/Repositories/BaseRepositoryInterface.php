<?php

namespace App\Repositories;

Interface BaseRepositoryInterface {

	public function getAll();

	public function find(int $id);

	public function create(array $data);

	public function update(array $data, $id);

	public function delete(int $id);
}