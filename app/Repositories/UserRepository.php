<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    protected function query($search = '', $with = [], $withCount = [])
    {
        $query = User::query();

        $query->whereLike("name", "%" . $search . "%");

        $query->with($with)->withCount($withCount);

        return $query;
    }

    public function find(int|User $id)
    {
        $user = $id;

        if (!$user instanceof User) {
            $user = User::findOrFail($user);
        }

        return $user;
    }

    public function all($search = '', $with = [], $withCount = [], $columns = ['*'])
    {
        return $this->query($search, $with, $withCount)->get($columns);
    }

    public function paginate($search = '', $with = [], $withCount = [], $columns = ['*'], $per_page = 10, $page = null)
    {
        return $this->query($search, $with, $withCount)->paginate($per_page, $columns, page: $page);
    }

    public function grow(int|User $id) {
        $user = $this->find($id);

        User::withoutTimestamps(function () use ($user) {
            $user->role = User::validateRole($user->role + 1);
            $user->save();
        });
    }

    public function shrink(int|User $id) {
        $user = $this->find($id);

        User::withoutTimestamps(function () use ($user) {
            $user->role = User::validateRole($user->role - 1);
            $user->save();
        });
    }

    // TODO:    Functions Below, Are not implemented yet. are handled by jetstream
    public function create(array $data) {}

    public function update(array $data, $id) {}

    public function delete($id) {}
}
