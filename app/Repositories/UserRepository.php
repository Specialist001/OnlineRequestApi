<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function getByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $user = $this->getById($id);

        if ($user) {
            $user->update($data);
            return $user;
        }

        return null;
    }

    public function delete($id)
    {
        $user = $this->getById($id);

        if ($user) {
            $user->delete();
            return true;
        }

        return false;
    }

    // create api auth token function
    public function createApiAuthToken($user)
    {
        return $user->createToken('auth_token')->plainTextToken;
    }

}
