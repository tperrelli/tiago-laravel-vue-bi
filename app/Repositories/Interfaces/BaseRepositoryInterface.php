<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    /**
     * Find a record by id
     * 
     * @param int id
     */
    public function findByID(int $id);
}