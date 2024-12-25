<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function all($search = '', $with = [], $withCount = [], $columns = ['*'])
    {
        return $this->userRepository->all($search, $with, $withCount, $columns);
    }

    public function find(int|User $id)
    {
        return $this->userRepository->find($id);
    }

    public function grow(int|User $id)
    {
        return $this->userRepository->grow($id);
    }

    public function shrink(int|User $id)
    {
        return $this->userRepository->shrink($id);
    }

    public function paginate($search = '', $with = [], $withCount = [], $columns = ['*'], $per_page = 10, $page = null)
    {
        return $this->userRepository->paginate($search, $with, $withCount, $columns, $per_page, $page);
    }

    // TODO:    Functions Below, Are not implemented yet. are handled by jetstream
    public function create(array $data)
    {
        return $this->userRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->userRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->userRepository->delete($id);
    }
}
