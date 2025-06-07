<?php

namespace App\Repositories;

use App\Interfaces\CityRepositoryInterface;
use App\Models\City;

class CityRepository implements CityRepositoryInterface
{
    public function getAllcities()
    {
        return City::all();
    }
}