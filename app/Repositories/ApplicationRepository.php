<?php

namespace App\Repositories;

use App\Enums\ApplicationStatusEnum;

class ApplicationRepository
{
    protected $model;

    public function __construct(\App\Models\Application $application)
    {
        $this->model = $application;
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }


    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $application = $this->getById($id);

        if ($application) {
            $application->update($data);
            return $application;
        }

        return null;
    }

    public function updateModel($model, array $data)
    {
        $model->update($data);
        return $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function delete($id)
    {
        $application = $this->getById($id);

        if ($application) {
            $application->delete();
            return true;
        }

        return false;
    }

    public function userCanCreateApplication($user_id, $minutes = 5)
    {
        $last_created_at = $this->model->where('user_id', $user_id)->where('status', '!=', ApplicationStatusEnum::Resolved)
            ->max('created_at');

        if (!$last_created_at) {
            return true;
        }

        return now()->diffInMinutes($last_created_at) >= $minutes;
    }

}
