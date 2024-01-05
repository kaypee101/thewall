<?php

namespace App\Repositories;

use Illuminate\Support\Arr;

class BaseRepository
{
    protected $modelClass;

    /**
     * @param string $modelClass
     */
    public function __construct(string $modelClass)
    {
        $this->modelClass = $modelClass;
    }

    /**
     * @return mixed
     */
    public function getModel(): mixed
    {
        return app($this->modelClass);
    }

    /**
     * @param array $select
     * 
     * @return mixed
     */
    public function getAll(array $select): mixed
    {
        return $this->getModel()::select(!empty($select) ? $select : '*')->get();
    }

    /**
     * @param array $select
     * @param int $count
     * 
     * @return mixed
     */
    public function paginate(array $select, int $count = 10): mixed
    {
        return $this->getModel()::select(!empty($select) ? $select : '*')->paginate($count);
    }

    /**
     * @param array $select
     * @param int $skip
     * @param int $limit
     * 
     * @return mixed
     */
    public function skipLimit(array $select, int $skip = 0, int $limit = 0): mixed
    {
        return $this->getModel()::select(!empty($select) ? $select : '*')->skip($skip)->limit($limit)->get();
    }

    /**
     * @param array $select
     * @param int $id
     * 
     * @return mixed
     */
    public function findById(array $select, int $id): mixed
    {
        return $this->getModel()::select(!empty($select) ? $select : '*')->findOrFail($id);
    }

    /**
     * @param array $select
     * @param array $data
     * 
     * @return mixed
     */
    public function create(array $select, array $data): mixed
    {
        return $this->getModel()::select(!empty($select) ? $select : '*')->create($data);
    }

    /**
     * @param mixed $model
     * @param array $data
     * 
     * @return mixed
     */
    public function update($model, array $data): mixed
    {
        $fillableData = Arr::only(array_filter($data), $model->getFillable());
        $model->update($fillableData);
        return $model;
    }

    /**
     * @param mixed $model
     * 
     * @return void
     */
    public function delete($model): void
    {
        $model->delete();
    }

    /**
     * @param array $appendFuncs
     * 
     * @return mixed
     */
    public function appendSearchConditions(array $appendFuncs): mixed
    {
        $query = $this->getModel();
        foreach ($appendFuncs as $appendFunc) {
            if (is_callable($appendFunc)) {
                $query = $appendFunc($query);
            }
        }
        return $query;
    }

    /**
     * @param array $appendFuncs
     * @param int $id
     * 
     * @return mixed
     */
    public function appendFindById(array $appendFuncs, int  $id): mixed
    {
        $query = $this->getModel();
        foreach ($appendFuncs as $appendFunc) {
            if (is_callable($appendFunc)) {
                $query = $appendFunc($query);
            }
        }
        return $query->findOrFail($id);
    }

    /**
     * @param array $appendFuncs
     * 
     * @return mixed
     */
    public function appendGet(array $appendFuncs): mixed
    {
        $query = $this->getModel();
        foreach ($appendFuncs as $appendFunc) {
            if (is_callable($appendFunc)) {
                $query = $appendFunc($query);
            }
        }
        return $query->get();
    }

    /**
     * @param array $appendFuncs
     * @param int $count
     * 
     * @return mixed
     */
    public function appendPaginate(array $appendFuncs, int $count = 10): mixed
    {
        $query = $this->getModel();
        foreach ($appendFuncs as $appendFunc) {
            if (is_callable($appendFunc)) {
                $query = $appendFunc($query);
            }
        }
        return $query->paginate($count);
    }

    /**
     * @param array $appendFuncs
     * 
     * @return mixed
     */
    public function appendCount(array $appendFuncs): mixed
    {
        $query = $this->getModel();
        foreach ($appendFuncs as $appendFunc) {
            if (is_callable($appendFunc)) {
                $query = $appendFunc($query);
            }
        }
        return $query->count();
    }
}
