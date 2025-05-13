<?php

namespace App\Repositories;

class CategoryRepository 
{
    public function getAll(array $fields)
    {
        return Category::select($fields)->latest()->paginate(50);
    }





}

