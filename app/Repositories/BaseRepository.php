<?php

namespace App\Repositories;

abstract class BaseRepository implements BaseRepositoryInterface {
	
protected $model;

	public function __construct() {
		$this->setModel();
	}

	abstract public function getModel();

	public function setModel() {
		$this->model = app()->make($this->getModel());
	}

	public function getAll()
	{
		return $this->model->all();
	}

	public function find(int $id)
	{
		return $this->model->find($id);
	}

	public function create(array $data)
	{
		return $this->model->create($data);
	}

	public function update(array $data, $id)
	{
		$result = $this->find($id);

		if (!$result) return false;

		return $result->update($data);
	}

	public function delete(int $id)
	{
		$result = $this->find($id);

		if (!$result) return false;

		return $result->delete();
	}
}