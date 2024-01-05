<?php

namespace App\Services;

use App\Repositories\BaseRepository;

class BaseService
{
    protected $repository;

    /**
     * @param BaseRepository $repository
     */
    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $select
     * 
     * @return mixed
     */
    public function getAll(array $select): mixed
    {
        return $this->repository->getAll($select);
    }

    /**
     * @param array $select
     * @param int $count
     * 
     * @return mixed
     */
    public function paginate(array $select, int $count = 10): mixed
    {
        return $this->repository->paginate($select, $count);
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
        return $this->repository->skipLimit($select, $skip, $limit);
    }

    /**
     * @param array $select
     * @param int $id
     * 
     * @return mixed
     */
    public function findById(array $select, int $id): mixed
    {
        return $this->repository->findById($select, $id);
    }

    /**
     * @param array $select
     * @param array $data
     * 
     * @return mixed
     */
    public function create(array $select, array $data): mixed
    {
        return $this->repository->create($select, $data);
    }

    /**
     * @param mixed $model
     * @param array $data
     * 
     * @return mixed
     */
    public function update($model, array $data): mixed
    {
        return $this->repository->update($model, $data);
    }

    /**
     * @param array $select
     * @param int $id
     * 
     * @return void
     */
    public function delete(array $select, int $id): void
    {
        $this->repository->findById($select, $id)->delete();
    }
}
