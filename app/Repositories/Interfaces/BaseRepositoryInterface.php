<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    public function getPaginated($page, $pageSize, $orderBy, $sortBy);

    public function getUnpaginated($orderBy, $sortBy);

    public function create($data);

    public function updateById($id, $data);

    public function getById($id);

    public function deleteById($id);
}
