<?php

namespace App\Repositories;

use App\Interfaces\BoardingHouseRepositoryInterface;
use App\Models\BoardingHouse;
use App\Models\City;
use Filament\Forms\Components\Builder;

class BoardingHouseRepository implements BoardingHouseRepositoryInterface
{
    public function getAllboardinghouses($search = null, $city = null, $category = null)
    {
        $query = BoardingHouse::query();

        //jka search di isi maka dia akan dijalankan 
        if ($search) {
            $query->where('name', 'like', '%'. $search .'%');
        }

        //jika city di isi maka akan mencari berdasarkan slug city tersebut
        if ($city) {
            $query->whereHas('City', function (Builder $query) use ($city) {
                $query->where('slug', $city);
            });
        }  

        //jika category di isi maka akan mencari berdasarkan slug category tersebut
        if ($category) {
            $query->whereHas('category', function (Builder $query) use ($category) {
                $query->where('slug', $category);
            });
        }
        return $query->get();
    }
    
    public function getPopularboardinghouses($limit = 5)
    {
        return BoardingHouse::witchCount('transactions')->orderBy('transactions_count', 'desc')->take($limit)->get();
    }

    public function getboardinghousesByCitySlug($slug)
    {
        return BoardingHouse::whereHas('city', function (Builder $query) use($slug){
            $query->where('slug', $slug);
        })->get();
    }

    public function getboardinghousesByCategorySlug($slug)
    {
        return BoardingHouse::whereHas('Category', function (Builder $query) use($slug){
            $query->where('slug', $slug);
        })->get();
    }

    public function getboardinghousesBySlug($slug)
    {
        return BoardingHouse::where('slug', $slug)->frist();
    }
}

    